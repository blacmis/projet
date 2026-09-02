<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Cashier\Concerns\HasCart;
use App\Models\ActivityLog;
use App\Models\CashierNotification;
use App\Models\CashRegisterSession;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use HasCart;

    private function currentUser(): ?User
    {
        return User::where('email', session('auth_user'))->first();
    }

    private function refreshStatus(Product $product): void
    {
        if ($product->stock_quantity <= 0) {
            $product->status = 'Out of Stock';
        } elseif ($product->stock_quantity <= ($product->low_stock_threshold ?? 5)) {
            $product->status = 'Low Stock';
        } else {
            $product->status = 'In Stock';
        }
        $product->save();
    }

    public function payment(Request $request)
    {
        $authUser = $this->currentUser();

        if (!$authUser) {
            return redirect()->route('login')->with('error', 'Session expirée. Reconnectez-vous.');
        }

        $registerSession = CashRegisterSession::openFor($authUser->email);

        if (!$registerSession) {
            return redirect()->route('cashier.register.open')
                ->with('error', 'Vous devez ouvrir la caisse avant de commencer une vente.');
        }

        $products = Product::orderBy('name')->get();
        $cart = $this->cart($request);
        $totals = $this->cartTotals($cart);

        return view('cashier.payment', compact('products', 'cart', 'totals'));
    }

    public function addToCart(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:999'],
        ]);

        $product = Product::find($data['product_id']);
        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        $quantity = $data['quantity'] ?? 1;
        if ($product->stock_quantity < $quantity) {
            return back()->with('error', "Only {$product->stock_quantity} unit(s) of {$product->name} remain.");
        }

        $cart = $this->cart($request);
        $key = (string) $product->id;
        $existing = $cart[$key]['quantity'] ?? 0;
        $newQuantity = $existing + $quantity;

        if ($newQuantity > $product->stock_quantity) {
            return back()->with('error', "Not enough stock for {$product->name}.");
        }

        $cart[$key] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'barcode' => $product->barcode,
            'price' => (float) $product->price,
            'discount' => 0,
            'quantity' => $newQuantity,
            'category' => $product->category,
        ];

        $request->session()->put('cashier_cart', $cart);

        return back()->with('success', "{$product->name} added to the sale.");
    }

    public function updateCart(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
        ]);

        $cart = $this->cart($request);
        $key = (string) $data['product_id'];

        if (!isset($cart[$key])) {
            return back()->with('error', 'Product is not in the current sale.');
        }

        $product = Product::find($data['product_id']);
        if ($product && $data['quantity'] > $product->stock_quantity) {
            return back()->with('error', "Only {$product->stock_quantity} unit(s) are available.");
        }

        $cart[$key]['quantity'] = $data['quantity'];
        $request->session()->put('cashier_cart', $cart);

        return back()->with('success', 'Cart updated.');
    }

    public function removeFromCart(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer'],
        ]);

        $cart = $this->cart($request);
        unset($cart[(string) $data['product_id']]);
        $request->session()->put('cashier_cart', $cart);

        return back()->with('success', 'Item removed.');
    }

    public function clearCart(Request $request)
    {
        $request->session()->forget('cashier_cart');

        return back()->with('success', 'Current sale cleared.');
    }

    public function checkout(Request $request)
    {
        $authUser = $this->currentUser();

        if (!$authUser) {
            return redirect()->route('login')->with('error', 'Session expirée. Reconnectez-vous.');
        }

        $registerSession = CashRegisterSession::openFor($authUser->email);

        if (!$registerSession) {
            return redirect()->route('cashier.register.open')
                ->with('error', 'Vous devez ouvrir la caisse avant d\'encaisser une vente.');
        }

        $data = $request->validate([
            'payment_method' => ['required', 'in:cash,mobile_money,card'],
            'amount_paid' => ['required', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
        ]);

        $cart = $this->cart($request);
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if (!$product || $product->stock_quantity < $item['quantity']) {
                return back()->with('error', "Stock insuffisant pour {$item['name']}.");
            }
        }

        $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);
        $discount = min((float) ($data['discount'] ?? 0), $subtotal);
        $tax = 0;
        $total = $subtotal - $discount + $tax;
        $amountPaid = (float) $data['amount_paid'];

        if ($amountPaid < $total) {
            return back()->with('error', 'Amount paid is less than the total.');
        }

        $sale = Sale::create([
            'register_session_id' => $registerSession->id,
            'transaction_number' => 'MS-' . now()->format('ymdHis') . '-' . rand(100, 999),
            'cashier_name' => $authUser->name,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $total,
            'payment_method' => $data['payment_method'],
            'amount_paid' => $amountPaid,
            'change_amount' => $amountPaid - $total,
            'status' => 'completed',
        ]);

        foreach ($cart as $item) {
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'line_total' => $item['price'] * $item['quantity'],
            ]);

            $product = Product::find($item['product_id']);
            $product->stock_quantity -= $item['quantity'];
            $product->save();
            $this->refreshStatus($product);
        }

        $request->session()->forget('cashier_cart');

        CashierNotification::create([
            'title' => 'Payment received',
            'message' => "Transaction {$sale->transaction_number} was completed for " . number_format($total, 0) . " FCFA.",
            'type' => 'payment',
            'is_read' => false,
        ]);

        ActivityLog::record(
            'sales',
            'Sales Completed',
            "Receipt #{$sale->transaction_number}",
            $sale->transaction_number
        );

        return redirect()->route('cashier.confirmation', $sale->id)
            ->with('success', 'Payment completed successfully.');
    }

    public function confirmation($sale = null)
    {
        $sale = Sale::with('items')->find($sale);

        if (!$sale) {
            return redirect()->route('cashier.payment')
                ->with('error', 'No completed sale exists yet.');
        }

        return view('cashier.payment-confirmation', compact('sale'));
    }
}
<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Cashier\Concerns\HasFakeCart;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use HasFakeCart;

    public function payment(Request $request)
    {
        $products = $this->fakeProducts();
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

        $product = $this->findFakeProduct($data['product_id']);
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

        $product = $this->findFakeProduct($data['product_id']);
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
        $data = $request->validate([
            'payment_method' => ['required', 'in:cash,mobile_money,card'],
            'amount_paid' => ['required', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
        ]);

        $cart = $this->cart($request);
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);
        $discount = min((float) ($data['discount'] ?? 0), $subtotal);
        $tax = 0;
        $total = $subtotal - $discount + $tax;
        $amountPaid = (float) $data['amount_paid'];

        if ($amountPaid < $total) {
            return back()->with('error', 'Amount paid is less than the total.');
        }

        $saleId = rand(1000, 9999);
        $transactionNumber = 'MS-' . now()->format('ymdHis') . '-' . rand(100, 999);

        $request->session()->forget('cashier_cart');
        $request->session()->put('last_sale', [
            'id' => $saleId,
            'transaction_number' => $transactionNumber,
            'cashier_name' => 'Cashier User',
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $total,
            'amount_paid' => $amountPaid,
            'change_amount' => $amountPaid - $total,
            'payment_method' => $data['payment_method'],
            'status' => 'completed',
            'items' => array_values($cart),
            'created_at' => now(),
        ]);

        return redirect()->route('cashier.confirmation', $saleId)
            ->with('success', 'Payment completed successfully (données fictives).');
    }

    public function confirmation($sale = null)
    {
        $saleData = session('last_sale');
        if (!$saleData) {
            return redirect()->route('cashier.payment')
                ->with('error', 'No completed sale exists yet.');
        }

        $sale = (object) $saleData;

        return view('cashier.payment-confirmation', compact('sale'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\CashierNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CashierController extends Controller
{
    private function cart(Request $request): array
    {
        return $request->session()->get('cashier_cart', []);
    }

    private function cartTotals(array $cart): array
    {
        $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);
        $discount = collect($cart)->sum(fn ($item) => ($item['discount'] ?? 0) * $item['quantity']);
        $tax = 0;
        $total = max(0, $subtotal - $discount + $tax);

        return compact('subtotal', 'discount', 'tax', 'total');
    }

    public function payment(Request $request)
    {
        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        $cart = $this->cart($request);
        $totals = $this->cartTotals($cart);

        return view('cashier.payment', compact('products', 'cart', 'totals'));
    }

    public function addToCart(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:999'],
        ]);

        $product = Product::where('is_active', true)->findOrFail($data['product_id']);
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

        $product = Product::findOrFail($data['product_id']);

        if ($data['quantity'] > $product->stock_quantity) {
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

        $sale = DB::transaction(function () use ($cart, $subtotal, $discount, $tax, $total, $amountPaid, $data) {
            foreach ($cart as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                if ($product->stock_quantity < $item['quantity']) {
                    throw new \RuntimeException("Insufficient stock for {$product->name}.");
                }
            }

            $sale = Sale::create([
                'transaction_number' => 'MS-' . now()->format('ymdHis') . '-' . random_int(100, 999),
                'cashier_name' => auth()->user()->name ?? 'Cashier',
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
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                $product->decrement('stock_quantity', $item['quantity']);

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'line_total' => $item['price'] * $item['quantity'],
                ]);
            }

            return $sale;
        });

        $request->session()->forget('cashier_cart');

        CashierNotification::create([
            'title' => 'Payment received',
            'message' => "Transaction {$sale->transaction_number} was completed for " . number_format($sale->total, 0) . " FCFA.",
            'type' => 'payment',
            'is_read' => false,
        ]);

        return redirect()->route('cashier.confirmation', $sale);
    }

    public function confirmation(Sale $sale)
    {
        $sale->load('items');

        return view('cashier.payment-confirmation', compact('sale'));
    }

    public function salesHistory(Request $request)
    {
        $query = Sale::with('items')->latest();

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where('transaction_number', 'like', "%{$search}%");
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $sales = $query->paginate(15)->withQueryString();

        return view('cashier.sales-history', compact('sales'));
    }

    public function showSale(Sale $sale)
    {
        $sale->load('items.product');

        return view('cashier.sale-show', compact('sale'));
    }

    public function receipt(?Sale $sale = null)
    {
        if (!$sale) {
            $sale = Sale::latest()->first();

            if (!$sale) {
                return redirect()->route('cashier.payment')->with('error', 'No completed sale exists yet.');
            }
        }

        $sale->load('items');

        return view('cashier.receipt', compact('sale'));
    }

    public function dailySummary()
    {
        $today = now()->startOfDay();

        $sales = Sale::where('created_at', '>=', $today)
            ->where('status', 'completed')
            ->get();

        $revenue = $sales->sum('total');
        $salesCount = $sales->count();
        $itemsSold = SaleItem::whereIn('sale_id', $sales->pluck('id'))->sum('quantity');
        $refunds = Sale::where('created_at', '>=', $today)->where('status', 'refunded')->count();

        $cash = $sales->where('payment_method', 'cash')->sum('total');
        $mobileMoney = $sales->where('payment_method', 'mobile_money')->sum('total');
        $card = $sales->where('payment_method', 'card')->sum('total');

        $hourly = $sales->groupBy(fn ($sale) => $sale->created_at->format('H:00'))
            ->map(fn ($group) => $group->sum('total'));

        return view('cashier.daily-summary', compact(
            'revenue', 'salesCount', 'itemsSold', 'refunds',
            'cash', 'mobileMoney', 'card', 'hourly'
        ));
    }

    public function profile()
    {
        $user = auth()->user();

        return view('cashier.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return back()->with('error', 'You must be logged in to update your profile.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $user->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function notifications()
    {
        $notifications = CashierNotification::latest()->paginate(15);

        return view('cashier.notifications', compact('notifications'));
    }

    public function markNotificationRead(CashierNotification $notification)
    {
        $notification->update(['is_read' => true]);

        return back();
    }

    public function markAllNotificationsRead()
    {
        CashierNotification::where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'All notifications marked as read.');
    }

    public function quickShop(Request $request)
    {
        $query = Product::where('is_active', true);

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->orderBy('name')->paginate(12)->withQueryString();
        $categories = Product::where('is_active', true)->whereNotNull('category')->distinct()->pluck('category');

        return view('cashier.quick-shop', compact('products', 'categories'));
    }
}

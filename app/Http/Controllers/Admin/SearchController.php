<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\CashierNotification;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $needle = strtolower($q);

        $sections = [
            'products' => collect(),
            'sales' => collect(),
            'activities' => collect(),
            'notifications' => collect(),
            'suppliers' => collect(),
            'categories' => collect(),
            'users' => collect(),
            'reports' => collect(),
        ];

        if ($q === '') {
            return view('admin.search', ['q' => $q, 'sections' => $sections, 'total' => 0]);
        }

        $sections['products'] = Product::where('name', 'like', "%{$q}%")
            ->orWhere('category', 'like', "%{$q}%")
            ->get()
            ->map(fn (Product $p) => (object) [
                'type' => 'Product',
                'code' => str_pad((string) $p->id, 5, '0', STR_PAD_LEFT),
                'name' => $p->name,
                'extra' => "{$p->category} | stock {$p->stock_quantity} | {$p->status}",
            ]);

        $sections['sales'] = Sale::where('transaction_number', 'like', "%{$q}%")
            ->orWhere('payment_method', 'like', "%{$q}%")
            ->get()
            ->map(fn (Sale $s) => (object) [
                'type' => 'Sale',
                'code' => $s->transaction_number,
                'name' => 'Receipt ' . ucfirst(str_replace('_', ' ', $s->payment_method)),
                'extra' => number_format($s->total) . ' XAF | ' . $s->created_at->format('d-m-Y'),
            ]);

        $sections['activities'] = ActivityLog::where('action', 'like', "%{$q}%")
            ->orWhere('details', 'like', "%{$q}%")
            ->orWhere('user_name', 'like', "%{$q}%")
            ->take(20)
            ->get()
            ->map(fn (ActivityLog $a) => (object) [
                'type' => 'Activity',
                'code' => $a->reference_id ?? ('LOG-' . $a->id),
                'name' => $a->action,
                'extra' => "{$a->user_name} | {$a->role} | {$a->details}",
            ]);

        $sections['notifications'] = CashierNotification::where('title', 'like', "%{$q}%")
            ->orWhere('message', 'like', "%{$q}%")
            ->get()
            ->map(fn ($n) => (object) [
                'type' => 'Notification',
                'code' => 'N' . $n->id,
                'name' => $n->title,
                'extra' => $n->message,
            ]);

        $sections['suppliers'] = Supplier::where('name', 'like', "%{$q}%")
            ->orWhere('email', 'like', "%{$q}%")
            ->get()
            ->map(fn (Supplier $s) => (object) [
                'type' => 'Supplier',
                'code' => 'SUP-' . $s->id,
                'name' => $s->name,
                'extra' => $s->phone . ' | ' . $s->email,
            ]);

        $sections['categories'] = Category::where('name', 'like', "%{$q}%")
            ->orWhere('description', 'like', "%{$q}%")
            ->get()
            ->map(fn (Category $c) => (object) [
                'type' => 'Category',
                'code' => 'CAT-' . $c->id,
                'name' => $c->name,
                'extra' => $c->description,
            ]);

        $sections['users'] = User::where('name', 'like', "%{$q}%")
            ->orWhere('email', 'like', "%{$q}%")
            ->get()
            ->map(fn (User $u) => (object) [
                'type' => 'User',
                'code' => 'U' . $u->id,
                'name' => $u->name,
                'extra' => ucfirst($u->role) . ' | ' . $u->email,
            ]);

        $allReports = collect([
            (object) ['type' => 'Page', 'code' => 'dashboard', 'name' => 'Dashboard', 'extra' => 'Admin home', 'url' => route('admin.dashboard')],
            (object) ['type' => 'Page', 'code' => 'inventory', 'name' => 'Inventory Manager', 'extra' => 'Product overview', 'url' => route('admin.inventory-manager')],
            (object) ['type' => 'Page', 'code' => 'cashier', 'name' => 'Cashier', 'extra' => 'Sales & products', 'url' => route('admin.cashier')],
            (object) ['type' => 'Page', 'code' => 'activities', 'name' => 'Activities Monitoring', 'extra' => 'Logs', 'url' => route('admin.activities')],
            (object) ['type' => 'Page', 'code' => 'sale', 'name' => 'Sale Report', 'extra' => 'Sales report', 'url' => route('admin.sale-report')],
            (object) ['type' => 'Page', 'code' => 'inv-report', 'name' => 'Inventory Report', 'extra' => 'Full inventory', 'url' => route('admin.inventory-report')],
            (object) ['type' => 'Page', 'code' => 'stock', 'name' => 'Stock Report', 'extra' => 'Stock summary', 'url' => route('admin.stock-report')],
            (object) ['type' => 'Page', 'code' => 'expiry', 'name' => 'Expiry Report', 'extra' => 'Expiring products', 'url' => route('admin.expiry-report')],
            (object) ['type' => 'Page', 'code' => 'revenue', 'name' => 'Revenue Report', 'extra' => 'Revenue & profit', 'url' => route('admin.revenue-report')],
            (object) ['type' => 'Page', 'code' => 'notif', 'name' => 'Notifications', 'extra' => 'Alerts', 'url' => route('admin.notifications')],
            (object) ['type' => 'Page', 'code' => 'profile', 'name' => 'Profile', 'extra' => 'Admin profile', 'url' => route('admin.profile')],
        ]);

        $sections['reports'] = $allReports->filter(fn ($i) =>
            str_contains(strtolower($i->name), $needle)
            || str_contains(strtolower($i->extra), $needle)
            || str_contains(strtolower($i->code), $needle)
        )->values();

        $total = collect($sections)->sum(fn ($c) => $c->count());

        return view('admin.search', compact('q', 'sections', 'total'));
    }
}
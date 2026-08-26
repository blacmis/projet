<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
    $q = trim($request->get('q', ''));
    $needle = strtolower($q);

    $sections = [
        'products'      => collect(),
        'sales'         => collect(),
        'activities'    => collect(),
        'notifications' => collect(),
        'suppliers'     => collect(),
        'categories'    => collect(),
        'users'         => collect(),
        'reports'       => collect(),
    ];

    if ($q === '') {
        return view('admin.search', [
            'q' => $q,
            'sections' => $sections,
            'total' => 0,
        ]);
    }

    // ========== PRODUITS (inventory + cashier + expiry) ==========
    $allProducts = collect([
        (object) ['type' => 'Product', 'code' => '001', 'name' => 'coca cola 1L', 'extra' => 'beverages | stock 53 | Good'],
        (object) ['type' => 'Product', 'code' => '002', 'name' => 'Rice 50kg', 'extra' => 'grains | stock 150 | Good'],
        (object) ['type' => 'Product', 'code' => '003', 'name' => 'Bread Loaf', 'extra' => 'bakery | stock 180 | Out of Stock'],
        (object) ['type' => 'Product', 'code' => '004', 'name' => 'Pick Milk', 'extra' => 'beverages | stock 125 | Low Stock'],
        (object) ['type' => 'Product', 'code' => '00001', 'name' => 'Coca Cola 1L', 'extra' => 'Beverage | ABC Foods Ltd | In Stock'],
        (object) ['type' => 'Product', 'code' => '00002', 'name' => 'Rice 50kg', 'extra' => 'Grains | Hilton Foods | Low Stock'],
        (object) ['type' => 'Product', 'code' => '00003', 'name' => 'Sardine', 'extra' => 'Beverage | Jasmine Food | Out-Of-Stock'],
        (object) ['type' => 'Product', 'code' => '00004', 'name' => 'Detol Soap', 'extra' => 'Household | Detol Ltd | In Stock'],
        (object) ['type' => 'Product', 'code' => '00005', 'name' => 'Chicken Egg(30pcs)', 'extra' => 'Groceries | Chang Farmers Ltd | Low Stock'],
    ]);
    $sections['products'] = $allProducts->filter(fn ($i) =>
        str_contains(strtolower($i->code), $needle)
        || str_contains(strtolower($i->name), $needle)
        || str_contains(strtolower($i->extra), $needle)
    )->values();

    // ========== VENTES / REÇUS ==========
    $allSales = collect([
        (object) ['type' => 'Sale', 'code' => 'RCPT-0048025', 'name' => 'Receipt Card', 'extra' => '11,250 | Card | 30-07-2026'],
        (object) ['type' => 'Sale', 'code' => 'RCPT-0048024', 'name' => 'Receipt Cash', 'extra' => '15,000 | Cash | 30-07-2026'],
        (object) ['type' => 'Sale', 'code' => 'RCPT-0048023', 'name' => 'Receipt Cash', 'extra' => '3,255 | Cash'],
        (object) ['type' => 'Sale', 'code' => 'RCPT-0048022', 'name' => 'Receipt Mobile Money', 'extra' => '5,200 | Mobile Money'],
        (object) ['type' => 'Sale', 'code' => '000136', 'name' => 'Recent sale cash', 'extra' => '8,350 | cash | 04:08pm'],
        (object) ['type' => 'Sale', 'code' => '000135', 'name' => 'Recent sale card', 'extra' => '19,725 | card'],
        (object) ['type' => 'Sale', 'code' => '000133', 'name' => 'Recent sale mobile', 'extra' => '3,600 | mobile money'],
    ]);
    $sections['sales'] = $allSales->filter(fn ($i) =>
        str_contains(strtolower($i->code), $needle)
        || str_contains(strtolower($i->name), $needle)
        || str_contains(strtolower($i->extra), $needle)
    )->values();

    // ========== ACTIVITÉS ==========
    $allActivities = collect([
        (object) ['type' => 'Activity', 'code' => 'STK-REC-00123', 'name' => 'Stock Received', 'extra' => 'Hillman | Inventory | 250 Items'],
        (object) ['type' => 'Activity', 'code' => 'RCPT-0048021', 'name' => 'Sales Completed', 'extra' => 'Ange | Cashier'],
        (object) ['type' => 'Activity', 'code' => 'LOGIN-00125', 'name' => 'User Login', 'extra' => 'System | Manager login'],
        (object) ['type' => 'Activity', 'code' => 'RCPT-0048010', 'name' => 'Sales Completed', 'extra' => 'Ange | Cashier'],
    ]);
    $sections['activities'] = $allActivities->filter(fn ($i) =>
        str_contains(strtolower($i->code), $needle)
        || str_contains(strtolower($i->name), $needle)
        || str_contains(strtolower($i->extra), $needle)
    )->values();

    // ========== NOTIFICATIONS ==========
    $allNotifs = collect([
        (object) ['type' => 'Notification', 'code' => 'N1', 'name' => 'Low stock alert', 'extra' => 'Rice 50kg below minimum'],
        (object) ['type' => 'Notification', 'code' => 'N2', 'name' => 'Product expiring soon', 'extra' => 'Coca-Cola 1L in 2 days'],
        (object) ['type' => 'Notification', 'code' => 'N3', 'name' => 'Daily sales summary', 'extra' => '4,769,000 FCFA | 96 sales'],
        (object) ['type' => 'Notification', 'code' => 'N4', 'name' => 'Failed login attempt', 'extra' => 'cashier terminal'],
    ]);
    $sections['notifications'] = $allNotifs->filter(fn ($i) =>
        str_contains(strtolower($i->name), $needle)
        || str_contains(strtolower($i->extra), $needle)
    )->values();

    // ========== FOURNISSEURS ==========
    $allSuppliers = collect([
        (object) ['type' => 'Supplier', 'code' => 'SUP-01', 'name' => 'ABC Foods Ltd', 'extra' => 'Beverage supplier'],
        (object) ['type' => 'Supplier', 'code' => 'SUP-02', 'name' => 'Hilton Foods', 'extra' => 'Grains'],
        (object) ['type' => 'Supplier', 'code' => 'SUP-03', 'name' => 'Jasmine Food', 'extra' => 'Sardine'],
        (object) ['type' => 'Supplier', 'code' => 'SUP-04', 'name' => 'Detol Ltd', 'extra' => 'Household'],
        (object) ['type' => 'Supplier', 'code' => 'SUP-05', 'name' => 'Chang Farmers Ltd', 'extra' => 'Groceries eggs'],
    ]);
    $sections['suppliers'] = $allSuppliers->filter(fn ($i) =>
        str_contains(strtolower($i->name), $needle)
        || str_contains(strtolower($i->extra), $needle)
        || str_contains(strtolower($i->code), $needle)
    )->values();

    // ========== CATÉGORIES (stock summary) ==========
    $allCategories = collect([
        (object) ['type' => 'Category', 'code' => 'CAT-01', 'name' => 'Groceries', 'extra' => '245 products | In Stock'],
        (object) ['type' => 'Category', 'code' => 'CAT-02', 'name' => 'Beverages', 'extra' => '120 products | In Stock'],
        (object) ['type' => 'Category', 'code' => 'CAT-03', 'name' => 'Dairy', 'extra' => '95 products'],
        (object) ['type' => 'Category', 'code' => 'CAT-04', 'name' => 'Health & Beauty', 'extra' => 'Low Stock'],
        (object) ['type' => 'Category', 'code' => 'CAT-05', 'name' => 'Household', 'extra' => 'Low Stock'],
        (object) ['type' => 'Category', 'code' => 'CAT-06', 'name' => 'Grains', 'extra' => 'Rice category'],
        (object) ['type' => 'Category', 'code' => 'CAT-07', 'name' => 'Bakery', 'extra' => 'Bread'],
    ]);
    $sections['categories'] = $allCategories->filter(fn ($i) =>
        str_contains(strtolower($i->name), $needle)
        || str_contains(strtolower($i->extra), $needle)
    )->values();

    // ========== UTILISATEURS ==========
    $allUsers = collect([
        (object) ['type' => 'User', 'code' => 'U1', 'name' => 'Admin User', 'extra' => 'Administrator | admin@marketsmart.com'],
        (object) ['type' => 'User', 'code' => 'U2', 'name' => 'Hillman', 'extra' => 'Inventory Manager'],
        (object) ['type' => 'User', 'code' => 'U3', 'name' => 'Ange', 'extra' => 'Cashier'],
        (object) ['type' => 'User', 'code' => 'U4', 'name' => 'System', 'extra' => 'System account'],
        (object) ['type' => 'User', 'code' => 'U5', 'name' => 'Inventory Manager', 'extra' => 'inventory.manager@marketsmart.com'],
        (object) ['type' => 'User', 'code' => 'U6', 'name' => 'Cashier User', 'extra' => 'cashier@marketsmart.com'],
    ]);
    $sections['users'] = $allUsers->filter(fn ($i) =>
        str_contains(strtolower($i->name), $needle)
        || str_contains(strtolower($i->extra), $needle)
    )->values();

    // ========== PAGES / RAPPORTS (raccourcis) ==========
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

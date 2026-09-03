<?php
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InventoryManagerController;
use App\Http\Controllers\Admin\CashierOverviewController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\SaleReportController;
use App\Http\Controllers\Admin\InventoryReportController;
use App\Http\Controllers\Admin\StockReportController;
use App\Http\Controllers\Admin\ExpiryReportController;
use App\Http\Controllers\Admin\RevenueReportController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\SearchController as AdminSearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\ProductController;
use App\Http\Controllers\Manager\StockInflowController;
use App\Http\Controllers\Manager\StockOutflowController;
use App\Http\Controllers\Manager\StockAdjustmentController;
use App\Http\Controllers\Manager\ExpiredController;
use App\Http\Controllers\Manager\SupplierController;
use App\Http\Controllers\Manager\CategoryController;
use App\Http\Controllers\Manager\UnitController;
use App\Http\Controllers\Manager\ReportController;
use App\Http\Controllers\Manager\ProfileController;
use App\Http\Controllers\Cashier\PaymentController;
use App\Http\Controllers\Cashier\ReceiptController;
use App\Http\Controllers\Cashier\SalesHistoryController;
use App\Http\Controllers\Cashier\DailySummaryController;
use App\Http\Controllers\Cashier\ProfileController as CashierProfileController;
use App\Http\Controllers\Cashier\NotificationController as CashierNotificationController;
use App\Http\Controllers\Cashier\QuickShopController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\InventoryActionController;
use App\Http\Controllers\Admin\SaleActionController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Cashier\CashRegisterController;






// ROUTES PUBLIQUES
// =========================================
Route::redirect('/','/login' );

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.email');

Route::get('/verify-otp', [AuthController::class, 'showOtp'])->name('password.otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->middleware('throttle:5,1')->name('password.otp.verify');

Route::get('/reset-password', [AuthController::class, 'showReset'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('throttle:5,1')->name('password.update');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/reset', function () {
    return view('marketsmart.resetting');
});
// ROUTES MANAGER
Route::prefix('manager')
    ->name('manager.')
    ->middleware('role:manager')
    ->group(function () {
        // toutes tes routes manager
        // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    // Stock Inflow
    Route::get('/stock-inflow', [StockInflowController::class, 'index'])->name('stock-inflow.index');
    Route::get('/stock-inflow/create', [StockInflowController::class, 'create'])->name('stock-inflow.create');
    Route::post('/stock-inflow', [StockInflowController::class, 'store'])->name('stock-inflow.store');
    // Stock Outflow
    Route::get('/stock-outflow', [StockOutflowController::class, 'index'])->name('stock-outflow.index');
    Route::get('/stock-outflow/create', [StockOutflowController::class, 'create'])->name('stock-outflow.create');
    Route::post('/stock-outflow', [StockOutflowController::class, 'store'])->name('stock-outflow.store');
    // Stock Adjustment
    Route::get('/stock-adjustment', [StockAdjustmentController::class, 'index'])->name('stock-adjustment.index');
    Route::get('/stock-adjustment/create', [StockAdjustmentController::class, 'create'])->name('stock-adjustment.create');
    Route::post('/stock-adjustment', [StockAdjustmentController::class, 'store'])->name('stock-adjustment.store');
    // Expired
    Route::get('/expired', [ExpiredController::class, 'index'])->name('expired.index');
    Route::get('/expiring-soon', [ExpiredController::class, 'expiringSoon'])->name('expiring.soon');
    Route::post('/expired', [ExpiredController::class, 'store'])->name('expired.store');
    // Suppliers
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{id}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    // Units
    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::get('/units/create', [UnitController::class, 'create'])->name('units.create');
    Route::post('/units', [UnitController::class, 'store'])->name('units.store');
    Route::get('/units/{id}/edit', [UnitController::class, 'edit'])->name('units.edit');
    Route::put('/units/{id}', [UnitController::class, 'update'])->name('units.update');
    Route::delete('/units/{id}', [UnitController::class, 'destroy'])->name('units.destroy');
    // Reports
    Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('/reports/low-stock', [ReportController::class, 'lowStock'])->name('reports.low-stock');
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
    });

// ROUTES CASHIER
Route::prefix('cashier')
    ->name('cashier.')
    ->middleware('role:cashier')
    ->group(function () {
        // toutes tes routes cashier
        Route::get('/quick-shop', [QuickShopController::class, 'quickShop'])->name('quick-shop');
        Route::get('/dashboard', [QuickShopController::class, 'quickShop'])->name('dashboard');
    Route::get('/register/open', [CashRegisterController::class, 'openForm'])->name('register.open');
    Route::post('/register/open', [CashRegisterController::class, 'store'])->name('register.store');
    Route::get('/register/close', [CashRegisterController::class, 'closeForm'])->name('register.close');
    Route::post('/register/close', [CashRegisterController::class, 'closeStore'])->name('register.close.store');
    Route::get('/payment', [PaymentController::class, 'payment'])->name('payment');
    Route::post('/cart/add', [PaymentController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [PaymentController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove', [PaymentController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/clear', [PaymentController::class, 'clearCart'])->name('cart.clear');
    Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
    Route::get('/confirmation/{sale?}', [PaymentController::class, 'confirmation'])->name('confirmation');

    Route::get('/receipt/{sale?}', [ReceiptController::class, 'receipt'])->name('receipt');

    // Sales History → cashier.sales + cashier.sale.show
    Route::get('/sales-history', [SalesHistoryController::class, 'salesHistory'])->name('sales');
    Route::get('/sales/{sale}', [SalesHistoryController::class, 'showSale'])->name('sale.show');

    // Daily Summary → cashier.summary  ← C’EST ÇA QUI MANQUAIT
    Route::get('/daily-summary', [DailySummaryController::class, 'dailySummary'])->name('summary');

    Route::get('/profile', [CashierProfileController::class, 'profile'])->name('profile');
    Route::put('/profile', [CashierProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/photo', [CashierProfileController::class, 'updatePhoto'])->name('profile.photo');

    Route::get('/notifications', [CashierNotificationController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{notification}/read', [CashierNotificationController::class, 'markNotificationRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [CashierNotificationController::class, 'markAllNotificationsRead'])->name('notifications.read-all');
    });

Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/inventory-manager', [InventoryManagerController::class, 'index'])->name('inventory-manager');
    Route::get('/cashier', [CashierOverviewController::class, 'index'])->name('cashier');
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities');
    Route::get('/sale-report', [SaleReportController::class, 'index'])->name('sale-report');
    Route::get('/inventory-report', [InventoryReportController::class, 'index'])->name('inventory-report');
    Route::get('/stock-report', [StockReportController::class, 'index'])->name('stock-report');
    Route::get('/expiry-report', [ExpiryReportController::class, 'index'])->name('expiry-report');
    Route::get('/revenue-report', [RevenueReportController::class, 'index'])->name('revenue-report');

    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/read-all', [AdminNotificationController::class, 'markAllRead'])->name('notifications.read-all');

    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [AdminProfileController::class, 'updatePhoto'])->name('profile.photo');
    Route::get('/search', [AdminSearchController::class, 'index'])->name('search');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/{id}/toggle', [UserController::class, 'toggleStatus'])->name('users.toggle');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/inventory-actions', [InventoryActionController::class, 'index'])->name('inventory-actions.index');
    Route::post('/inventory-actions/{id}/adjust', [InventoryActionController::class, 'adjust'])->name('inventory-actions.adjust');
    Route::post('/inventory-actions/{id}/status', [InventoryActionController::class, 'setStatus'])->name('inventory-actions.status');
    Route::get('/sale-actions', [SaleActionController::class, 'index'])->name('sale-actions.index');
    Route::post('/sale-actions/{id}/cancel', [SaleActionController::class, 'cancel'])->name('sale-actions.cancel');
    Route::post('/sale-actions/{id}/restore', [SaleActionController::class, 'restore'])->name('sale-actions.restore');
    Route::get('/audit-log', [AuditLogController::class, 'index'])->name('audit-log.index');
    Route::post('/audit-log/clear', [AuditLogController::class, 'clear'])->name('audit-log.clear');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/reset', [SettingsController::class, 'reset'])->name('settings.reset');
    Route::post('/users/{id}/unlock', [UserController::class, 'unlock'])->name('users.unlock');
    });
//acceptation des route par le midleware
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('role:admin,manager,cashier')
    ->name('logout');
    Route::get('/login/otp', [AuthController::class, 'showLoginOtp'])->name('login.otp');
    Route::post('/login/otp', [AuthController::class, 'verifyLoginOtp'])->name('login.otp.verify');
    Route::post('/login/otp/resend', [AuthController::class, 'resendLoginOtp'])->name('login.otp.resend');



// dans Route::prefix('admin')->middleware('role:admin')->group(...)


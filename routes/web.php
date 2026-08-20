<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CashierController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('cashier')->name('cashier.')->group(function () {
    Route::get('/payment', [CashierController::class, 'payment'])->name('payment');
    Route::post('/cart/add', [CashierController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [CashierController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove', [CashierController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/clear', [CashierController::class, 'clearCart'])->name('cart.clear');

    Route::post('/checkout', [CashierController::class, 'checkout'])->name('checkout');
    Route::get('/payment-confirmation/{sale}', [CashierController::class, 'confirmation'])->name('confirmation');

    Route::get('/sales-history', [CashierController::class, 'salesHistory'])->name('sales');
    Route::get('/sales/{sale}', [CashierController::class, 'showSale'])->name('sale.show');

    Route::get('/receipt/{sale?}', [CashierController::class, 'receipt'])->name('receipt');

    Route::get('/daily-summary', [CashierController::class, 'dailySummary'])->name('summary');
    Route::get('/profile', [CashierController::class, 'profile'])->name('profile');
    Route::put('/profile', [CashierController::class, 'updateProfile'])->name('profile.update');

    Route::get('/notifications', [CashierController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{notification}/read', [CashierController::class, 'markNotificationRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [CashierController::class, 'markAllNotificationsRead'])->name('notifications.read-all');

    Route::get('/quick-shop', [CashierController::class, 'quickShop'])->name('quick-shop');
});


Route::get('/login', function () {
    return view('marketsmart.login');
});

Route::get('/forgotpassword', function () {
    return view('marketsmart.forgotpassword');
});

Route::get('/reset', function () {
    return view('marketsmart.resetting');
});
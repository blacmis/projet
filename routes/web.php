<?php

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

Route::get('/',function(){
    return view('welcome');
});
Route::prefix('manager')->name('manager.')->group(function(){
    //route du dashboard
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard') ;
    //nouvelle route produits
    Route::get('/products',[ProductController::class, 'index'])->name('products.index');
    //affiche le formulaire d'ajout d'un produit
    Route::get('/products/create',[ProductController::class, 'create'])->name('products.create');
    //enregistre le nouveau produit traitement du formulaire
    Route::post('/products',[ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit',[ProductController::class,'edit'])->name('products.edit');
    Route::put('/products/{id}',[ProductController::class,'update'])->name('products.update');
    Route::delete('/products/{id}',[ProductController::class,'destroy'])->name('products.destroy');
    //nouvelle route de stockinflow
    Route::get('/stock-inflow', [StockInflowController::class, 'index'])->name('stock-inflow.index');
    Route::get('/stock-inflow/create', [StockInflowController::class, 'create'])->name('stock-inflow.create');
    Route::post('/stock-inflow', [StockInflowController::class, 'store'])->name('stock-inflow.store');
    //nouvelle route de stockoutflew
    Route::get('/stock-outflow', [StockOutflowController::class, 'index'])->name('stock-outflow.index');
    Route::get('/stock-outflow/create', [StockOutflowController::class, 'create'])->name('stock-outflow.create');
    Route::post('/stock-outflow', [StockOutflowController::class, 'store'])->name('stock-outflow.store');
    //nouvelle route de stockadjustment
    Route::get('/stock-adjustment', [StockAdjustmentController::class, 'index'])->name('stock-adjustment.index');
    Route::get('/stock-adjustment/create', [StockAdjustmentController::class, 'create'])->name('stock-adjustment.create');
    Route::post('/stock-adjustment', [StockAdjustmentController::class, 'store'])->name('stock-adjustment.store');
    //nouvelle route de expired
    Route::get('/expired',[ExpiredController::class,'index'])->name('expired.index');
    Route::get('/expiring-soon',[ExpiredController::class,'expiringSoon'])->name('expiring.soon');
    //nouvelle route pour supplier
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{id}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
    //nouvelle route pour le champs categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    //nouvelle route pour les champs units
    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::get('/units/create', [UnitController::class, 'create'])->name('units.create');
    Route::post('/units', [UnitController::class, 'store'])->name('units.store');
    Route::get('/units/{id}/edit', [UnitController::class, 'edit'])->name('units.edit');
    Route::put('/units/{id}', [UnitController::class, 'update'])->name('units.update');
    Route::delete('/units/{id}', [UnitController::class, 'destroy'])->name('units.destroy');
    //nouvelles routes pour les inventaire et le reports
    Route::get('/reports/inventory',[ReportController::class,'inventory'])->name('reports.inventory');
    Route::get('/reports/low-stock',[ReportController::class,'lowStock'])->name('reports.low-stock');
    //nouvelle route pour le profile
    Route::get('/profile',[ProfileController::class,'index'])->name('profile');
    

});






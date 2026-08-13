<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\StaffLoginController;
use App\Http\Controllers\SettingsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'staff') {
        return redirect()->route('sales.index');
    }

    $negativeStockProducts = \App\Models\Product::where('quantity', '<', 0)->get();

    return view('dashboard', compact('negativeStockProducts'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::middleware('module:products')->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::middleware('module:customers')->group(function () {
        Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    });

    Route::get('/stock', [StockMovementController::class, 'index'])->name('stock.index');
    Route::middleware('module:stock_create')->group(function () {
        Route::get('/stock/create', [StockMovementController::class, 'create'])->name('stock.create');
        Route::post('/stock', [StockMovementController::class, 'store'])->name('stock.store');
    });
    Route::middleware('module:stock_history')->group(function () {
        Route::get('/stock/history', [StockMovementController::class, 'history'])->name('stock.history');
    });

    Route::middleware('module:sales')->group(function () {
        Route::get('/sales', [SaleController::class, 'create'])->name('sales.index');
        Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    });
    Route::get('/sales/history', [SaleController::class, 'history'])->name('sales.history');
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::middleware('module:expenses')->group(function () {
        Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
        Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
        Route::get('/expenses/{expense}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
        Route::put('/expenses/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
        Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    });
    Route::middleware('module:reports')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });
    Route::middleware('module:settings')->group(function () {
        Route::get('/settings/users', [SettingsController::class, 'index'])->name('settings.index');
        Route::get('/settings/users/create', [SettingsController::class, 'create'])->name('settings.create');
        Route::post('/settings/users', [SettingsController::class, 'store'])->name('settings.store');
        Route::get('/settings/users/{user}/edit', [SettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings/users/{user}', [SettingsController::class, 'update'])->name('settings.update');
        Route::delete('/settings/users/{user}', [SettingsController::class, 'destroy'])->name('settings.destroy');
    });
    
});

require __DIR__.'/auth.php';

Route::get('/staff-login', [StaffLoginController::class, 'index'])->name('staff-login.index');
Route::get('/staff-login/{user}', [StaffLoginController::class, 'showPin'])->name('staff-login.pin');
Route::post('/staff-login/{user}', [StaffLoginController::class, 'attempt'])->name('staff-login.attempt');
<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\CustProdukController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

// Product Detail (Public - No Auth Required)


// ========== AUTH ROUTES (with middleware) ==========
Route::middleware('auth', 'customer')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ========== CUSTOMER CART & ORDERS (ALREADY PROTECTED BY MIDDLEWARE) ==========
    
    // Cart Routes
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::put('/update/{cartItem}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{cartItem}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
        Route::get('/count', [CartController::class, 'count'])->name('count'); // AJAX
    });
    
    // Checkout Routes
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    });
    
    // Customer Orders Routes
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [CustomerOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [CustomerOrderController::class, 'show'])->name('show');
        Route::post('/{order}/cancel', [CustomerOrderController::class, 'cancel'])->name('cancel');
    });

    // Product

    Route::get('/product/{slug}', [DashboardController::class, 'showProduct'])->name('product.show');
});

// ========== ADMIN ROUTES ==========

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function() {
        return view('admin.dashboard'); 
    })->name('dashboard');

    // CRUD Routes
    Route::resource('/customer', UserController::class);
    Route::resource('/product', ProdukController::class);
    Route::resource('/order', OrderController::class); // Admin order management
    
    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}', [CategoryController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/', [ProdukController::class, 'index'])->name('index');
        Route::get('/create', [ProdukController::class, 'create'])->name('create');
        Route::post('/', [ProdukController::class, 'store'])->name('store');
        
        // DELETE IMAGE ROUTE - HARUS SEBELUM {id} ROUTES!
        Route::delete('/image/{image}', [ProdukController::class, 'deleteImage'])->name('image.delete');
        
        Route::get('/{id}', [ProdukController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ProdukController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProdukController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProdukController::class, 'destroy'])->name('destroy');
    });

    
    // Analytics Route (bukan resource, cuma halaman view)
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    
    // Settings Route (optional)
    Route::get('/settings', function() {
        return view('admin.settings');
    })->name('settings');

});


require __DIR__.'/auth.php';
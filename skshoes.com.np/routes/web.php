<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\ShoeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PriceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//--------------------------------Cookies Stuff-------------------------------------------------------------------------------------
Route::get('/cookie', [CookieController::class, 'index'])->name('cookie');
Route::post('/cookie', [CookieController::class, 'setCookie']);
Route::delete('/cookie/{cookie}', [CookieController::class, 'deleteSingleCookie']);
Route::delete('/cookie', [CookieController::class, 'deleteCookies']);
//--------------------------------Cookies Stuff End---------------------------------------------------------------------------------

Route::get('/check-time', function() {
    return now();  // Returns current time in Laravel format (YYYY-MM-DD HH:MM:SS)
});

//--------------------------------Customer Routes-------------------------------------------------------------------------------------
Route::get('/', [CategoryController::class, 'home'])->name('customer.home');

Route::get('/products', [ShoeController::class, 'index'])->name('products');

Route::get('/products/{slug}', [PriceController::class, 'index'])->name('products.show');

Route::get('/cart', function () {
    return view('customer.cart', [
        'cartItems' => session()->get('cart', [])
    ]);
})->name('cart');

Route::get('/about', function () {
    return view('customer.about');
})->name('about');

Route::get('/contact', function () {
    return view('customer.contact');
})->name('contact');
Route::post('/checkout', [OrderController::class, 'checkout']);

//Esewa Routes
Route::get('/payment/esewa/success', [PaymentController::class, 'esewaSuccess'])->name('payment.esewa.success');
Route::get('/payment/failure', [PaymentController::class, 'failure'])->name('payment.failure');

//--------------------------------Customer Routes End-------------------------------------------------------------------------------------




//------------------------------------------------Admin Routes ----------------------------------------------------------------------------

Route::get('/admin', function () {
    return view('admin.login');
})->name('login')->middleware('guest');

Route::post('/admin', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::middleware(['auth:sanctum'])->prefix('admin')->name('admin.')->group(function () {
    // Add logout route
    Route::post('/logout', function () {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    })->name('logout');

    Route::delete('/products/{article_id}', [ShoeController::class, 'destroy'])->name('products.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Add these new routes for discount management
    Route::post('/discount/{discount_code}/update-status', [DiscountController::class, 'update'])->name('discount.update-status');
    Route::post('/discount/{discount_code}/delete', [DiscountController::class, 'destroy'])->name('discount.delete');

    // Orders routes
    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders', 'index')->name('orders');
        Route::get('/orders/{id}', 'show')->name('orders.show');
        Route::get('/orders/{id}/accept', 'accept')->name('orders.accept');
        Route::get('/orders/{id}/reject', 'reject')->name('orders.reject');
        Route::get('/orders/filter/{timeFrame}', 'filterOrders')->name('orders.filter');
    });

    // Stock routes
    Route::get('/stocks', [StockController::class, 'index'])->name('stocks');

    Route::post('/stocks', [StockController::class, 'store'])->name('stocks.store');
    Route::put('/stocks/{stock}', [StockController::class, 'update'])->name('stocks.update');
    Route::delete('/stocks/{stock}', [StockController::class, 'destroy'])->name('stocks.destroy');

    // Simple view routes
    Route::view('/products', 'admin.products')->name('products');

    Route::get('/categories', function () {
        return view('admin.categories');
    })->name('categories');

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories/data', 'index')->name('categories.data');
        Route::post('/categories', 'store')->name('categories.store');
        Route::get('/categories/{category_name}', 'show')->name('categories.show');
        Route::put('/categories/{category_name}', 'update')->name('categories.update');
        Route::delete('/categories/{category_name}', 'destroy')->name('categories.destroy');
        Route::patch('/categories/{category_name}/feature', 'update')->name('categories.feature');
    });

    Route::get('/discount', [DiscountController::class, 'index'])->name('discount');

    // Discount routes
    Route::controller(DiscountController::class)->group(function () {
        Route::post('/discount/store', 'store')->name('discount.store');
        Route::post('/discount/update/{discount_code}', 'update')->name('discount.update');
        Route::post('/discount/{discount_code}/delete', 'destroy')->name('discount.delete');
        Route::get('/discount/article-search', 'articleSearch')->name('discount.article-search');
    });
});

Route::get('search',[ShoeController::class, 'search']);
Route::get('shoes', [ShoeController::class, 'api']);

//------------------------------------------------Admin Routes End---------------------------------------------------------------------

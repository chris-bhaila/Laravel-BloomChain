<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ShoeController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

    //---------------------------------------------------Both Admin and Customer ---------------------------
    //Shoe Search Component
    Route::get('search',[ShoeController::class, 'search']);
    //Shoe
    Route::get('shoes', [ShoeController::class, 'api']);
    //Price
    Route::get('/shoe/{article_id}',[PriceController::class, 'index']);
    //Category
    Route::resource('category', CategoryController::class)->only('index');
    //Discount Check
    Route::get('/discountcheck',[DiscountController::class, 'discountcheck']);
    //Article Search Component
    Route::get('/articleSearch', [DiscountController::class, 'articleSearch']);
    //Category Search
    Route::get('/categoryList', [CategoryController::class, 'categoryList']);
    //Cart
    Route::get('/cart',[CartController::class, 'index']);
    //Notification
    Route::get('/notifications',[DashboardController::class, 'notification']);
    

    //--------------------------------------------------------- Admin -------------------------------------

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    // Route::post('/admin', [AdminAuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/dashboard',[DashboardController::class, 'index']);
        //Shoe
        Route::resource('shoes', ShoeController::class)->only('store','update','destroy');
        //Show shoe list
        Route::post('/shoelist',[ShoeController::class, 'show']);
        //Shoe Details
        Route::get('/shoedetail/{id}', [ShoeController::class, 'productDetail']);
        //Category
        Route::resource('category', CategoryController::class)->only('store','update','destroy');
        //Discount
        Route::resource('discount', DiscountController::class)->only('store','update','destroy');
        //Stock
        Route::resource('stock', StockController::class)->only('update','destroy');
        //Order
        Route::resource('order', OrderController::class)->only('index');
        //Update Order
        Route::post('/admin/orders/update-status/{order_id}', [OrderController::class, 'update'])->name('orderUpdate');  
    });
    
?>

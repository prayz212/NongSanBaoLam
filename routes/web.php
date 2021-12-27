<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::prefix('/')->group(function () {
    Route::get('', [HomeController::class, 'index'])->name('homepage');
    Route::get('/gioi-thieu', [HomeController::class, 'introduce'])->name('introducePage');

    Route::get('/danh-sach-san-pham', [ProductController::class, 'index'])->name('productpage');
    Route::get('/chi-tiet-san-pham/{id}', [ProductController::class, 'detail'])->name('productDetail');
    Route::get('/tim-kiem-san-pham', [ProductController::class, 'search'])->name('searchProduct');
    Route::get('/san-pham-ban-chay', [ProductController::class, 'topSales'])->name('topSales');
    Route::get('/san-pham-moi', [ProductController::class, 'newProducts'])->name('topSales');
    Route::get('/san-pham-khuyen-mai', [ProductController::class, 'flashSales'])->name('topSales');
    Route::get('/the-loai-san-pham/{type}', [ProductController::class, 'category'])->name('productByType');

    Route::post('/them-vao-gio-hang', [CartController::class, 'addToCart'])->name('addToCart');
    Route::post('/cap-nhat-so-luong', [CartController::class, 'updateToCart'])->name('updateToCart');
    Route::post('/xoa-khoi-gio-hang', [CartController::class, 'deleteFormCart'])->name('deleteFormCart');
    Route::get('/gio-hang', [CartController::class, 'index'])->name('shoppingCart');
    
    Route::post('/them-binh-luan', [CommentController::class, 'addComment'])->name('addComment');
    Route::post('/tra-loi-binh-luan', [CommentController::class, 'replyComment'])->name('replyComment');
});

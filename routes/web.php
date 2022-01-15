<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CommentController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\AccountController;

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminProductController;
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

/*          CLIENT          */
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

    Route::middleware('auth')->group(function() {
        Route::get('/thanh-toan', [CartController::class, 'payment'])->name('payment');
        Route::post('/thuc-hien-thanh-toan', [CartController::class, 'paymentProcess'])->name('postPayment');
        Route::post('/kiem-tra-so-luong', [CartController::class, 'checkProductQuantity'])->name('checkQuantity');
        Route::post('/kiem-tra-voucher', [CartController::class, 'checkVoucher'])->name('checkVoucher');

        Route::get('/tai-khoan', [AccountController::class, 'index'])->name('infopage');
        Route::post('/cap-nhat-tai-khoan', [AccountController::class, 'updateInfo'])->name('updateInfo');
        Route::get('/chi-tiet-hoa-don/{id}', [AccountController::class, 'billDetail'])->name('billDetail');
        Route::get('/danh-sach-hoa-don', [AccountController::class, 'bills'])->name('bills');

        Route::get('/dang-xuat', [AuthController::class, 'logout'])->name('logout');

        Route::post('/danh-gia-san-pham', [ProductController::class, 'rating'])->name('rating');
    });
    
    Route::post('/them-binh-luan', [CommentController::class, 'addComment'])->name('addComment');
    Route::post('/tra-loi-binh-luan', [CommentController::class, 'replyComment'])->name('replyComment');

    Route::get('/dang-nhap-dang-ky', [AuthController::class, 'index'])->name('authenticatepage');
    Route::post('/dang-nhap', [AuthController::class, 'login'])->name('login');
    Route::post('/dang-ky', [AuthController::class, 'register'])->name('register');
    Route::get('/quen-mat-khau', [AuthController::class, 'resetPassword'])->name('resetRequest');
    Route::post('/yeu-cau-quen-mat-khau', [AuthController::class, 'requestResetPassword'])->name('requestResetPassword');
    Route::get('/cap-nhat-mat-khau/{token}', [AuthController::class, 'updatePassword'])->name('updatePassword');
    Route::post('/cap-nhat-mat-khau-moi/{token}', [AuthController::class, 'updateNewPassword'])->name('updateNewPassword');
});

/*          ADMIN          */
Route::prefix('/admin')->group(function () {
    Route::get('/dang-nhap', [AdminAuthController::class, 'index'])->name('adminLogin');
    Route::post('/yeu-cau-dang-nhap', [AdminAuthController::class, 'login'])->name('adminLoginRequest');

    Route::group(['middleware' => 'auth:admin'], function() {
        Route::get('/trang-chu', [AdminHomeController::class, 'index'])->name('dashboard');
        Route::get('/dang-xuat', [AdminAuthController::class, 'logout'])->name('adminLogout');

        Route::get('/quan-ly-san-pham', [AdminProductController::class, 'index'])->name('productManagement');
        Route::get('/thong-tin-san-pham/{id}', [AdminProductController::class, 'detail'])->name('productInfo');
        Route::get('/chinh-sua-san-pham/{id}', [AdminProductController::class, 'update'])->name('updateProduct');
        Route::post('/yeu-cau-chinh-sua-san-pham', [AdminProductController::class, 'updateProcess'])->name('updateProcess');
        Route::get('/xoa-san-pham/{id}', [AdminProductController::class, 'delete'])->name('deleteProduct');
        Route::get('/nhap-kho', [AdminProductController::class, 'stockIn'])->name('productStockIn');
        Route::post('/yeu-cau-nhap-kho', [AdminProductController::class, 'stockInProcess'])->name('stockInProcess');
        Route::get('/api-danh-sach-san-pham', [AdminProductController::class, 'productsByCategory'])->name('getProductByCategory');
        
    });
});
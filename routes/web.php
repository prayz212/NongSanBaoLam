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
use App\Http\Controllers\Admin\AdminBillController;
use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\AdminVoucherController;
use App\Http\Controllers\Admin\AdminCommentController;
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
        Route::get('/thay-doi-mat-khau', [AccountController::class, 'resetPassword'])->name('resetPassword');
        Route::post('/yeu-cau-thay-doi-mat-khau', [AccountController::class, 'requestNewPassword'])->name('requestNewPassword');
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
        
        Route::get('/quan-ly-hoa-don', [AdminBillController::class, 'index'])->name('adminBill');
        Route::get('/thong-tin-hoa-don/{id}', [AdminBillController::class, 'billDetail'])->name('adminBillDetail');
        Route::post('/cap-nhat-hoa-don', [AdminBillController::class, 'billUpdateStatus'])->name('adminBillUpdate');

        Route::get('/quan-ly-tai-khoan', [AdminAccountController::class, 'index'])->name('accountManagement');
        Route::get('/thong-tin-tai-khoan/{id}', [AdminAccountController::class, 'accountInfo'])->name('adminAccountInfo');
        Route::get('/chinh-sua-tai-khoan/{id}', [AdminAccountController::class, 'update'])->name('updateAccount');
        Route::post('/yeu-cau-chinh-sua-tai-khoan/{id}', [AdminAccountController::class, 'updateProcess'])->name('updateAccountProcess');
        Route::get('/tao-moi-tai-khoan', [AdminAccountController::class, 'create'])->name('createAccount');
        Route::post('/yeu-cau-tao-moi-tai-khoan', [AdminAccountController::class, 'createProcess'])->name('createAccountProcess');
        Route::get('/xoa-tai-khoan/{id}', [AdminAccountController::class, 'delete'])->name('deleteAccount');

        Route::get('/quan-ly-voucher', [AdminVoucherController::class, 'index'])->name('voucherManagement');
        Route::get('/thong-tin-voucher/{code}', [AdminVoucherController::class, 'detail'])->name('voucherInfo');
        Route::get('/tao-moi-voucher', [AdminVoucherController::class, 'create'])->name('createVoucher');
        Route::post('/yeu-cau-tao-moi-voucher', [AdminVoucherController::class, 'createProcess'])->name('createVoucherProcess');
        Route::get('/xoa-voucher/{code}', [AdminVoucherController::class, 'delete'])->name('deleteVoucher');

        Route::get('/quan-ly-san-pham', [AdminProductController::class, 'index'])->name('productManagement');
        Route::get('/thong-tin-san-pham/{id}', [AdminProductController::class, 'detail'])->name('productInfo');
        Route::get('/tao-moi-san-pham', [AdminProductController::class, 'create'])->name('createProduct');
        Route::post('/yeu-cau-tao-moi-san-pham', [AdminProductController::class, 'createProcess'])->name('createProcess');
        Route::get('/chinh-sua-san-pham/{id}', [AdminProductController::class, 'update'])->name('updateProduct');
        Route::post('/yeu-cau-chinh-sua-san-pham', [AdminProductController::class, 'updateProcess'])->name('updateProcess');
        Route::get('/xoa-san-pham/{id}', [AdminProductController::class, 'delete'])->name('deleteProduct');
        Route::get('/nhap-kho', [AdminProductController::class, 'stockIn'])->name('productStockIn');
        Route::post('/yeu-cau-nhap-kho', [AdminProductController::class, 'stockInProcess'])->name('stockInProcess');
        Route::get('/api-danh-sach-san-pham', [AdminProductController::class, 'productsByCategory'])->name('getProductByCategory');

        Route::get('/binh-luan-san-pham', [AdminCommentController::class, 'index'])->name('commentManagement');
        Route::get('/api-cap-nhat-danh-sach-binh-luan', [AdminCommentController::class, 'fetch'])->name('fetchComment');
        Route::post('/api-xoa-binh-luan', [AdminCommentController::class, 'delete'])->name('deleteComment');
        Route::post('/api-danh-dau-binh-luan', [AdminCommentController::class, 'mark'])->name('markComment');
        Route::post('/api-tra-loi-binh-luan', [AdminCommentController::class, 'reply'])->name('replyComment');
        Route::post('/api-chinh-sua-binh-luan', [AdminCommentController::class, 'edit'])->name('editComment');
    });
});
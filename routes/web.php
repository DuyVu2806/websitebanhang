<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Customer\AuthController;
use App\Http\Controllers\Customer\HomeController;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Customer Route
// guest Page
Route::get('/', [HomeController::class, 'homePage'])->name('cus.home');
Route::get('/product',[HomeController::class,'productPage'])->name('cus.product_page');
Route::get('/product/{product_slug}',[HomeController::class,'productDetail'])->name('cus.product_detail');
Route::get('/contact',[HomeController::class,'contactPage'])->name('cus.contact');

// Route::get('/search-by-image',[HomeController::class,'searchByImage']);
// Route::post('/search-by-image',[HomeController::class,'post_searchByImage'])->name('cus.searchByImage');

// Auth Page
Route::get('/login', [AuthController::class, 'login'])->name('cus.login');
Route::post('/login', [AuthController::class, 'post_login'])->name('cus.post_login');
Route::get('/register', [AuthController::class, 'register'])->name('cus.register');
Route::post('/register', [AuthController::class, 'post_register'])->name('cus.post_register');
Route::get('/logout', [AuthController::class, 'logout'])->name('cus.logout');

Route::get('/password-request',[AuthController::class,'forgot_password'])->name('cus.passowrd-request');
Route::post('/password-request',[AuthController::class,'post_forgot_password'])->name('cus.post-passowrd-request');
Route::get('/get-password/{cus}/{token}',[AuthController::class,'get_password'])->name('cus.get-passowrd');
Route::post('/get-password/{cus}/{token}',[AuthController::class,'post_get_password'])->name('cus.post-get-passowrd');
// Route::get('/test-mail', [AuthController::class, 'test_mail']);

Route::middleware('cus')->group(function () {
    Route::get('/cart',[HomeController::class,'cart'])->name('cus.cart');
    Route::get('/checkout',[HomeController::class,'checkout'])->name('cus.checkout');
    Route::get('/view-order',[HomeController::class,'viewOrder'])->name('cus.order');
    Route::get('/view-order-detail/{id}',[HomeController::class,'ViewOrderDetail'])->name('cus.order_detail');
    Route::post('/review/{id}',[HomeController::class,'post_review'])->name('cus.review');
    Route::post('/reviewfsdf',[HomeController::class,'post_review0'])->name('cus.review0');
    Route::get('/profile',[HomeController::class,'profile'])->name('cus.profile');
});

// Admin Route
Route::get('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'post_login'])->name('admin.post_login');
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/revenue-analysis', [DashboardController::class, 'revenue_analysis'])->name('revenue_analysis');
    Route::prefix('permission')->name('permission.')->controller(AdminController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'post_create')->name('post_create');
        Route::get('/update/{id}','update')->name('update');
        Route::put('/update/{id}','post_update')->name('post_update');
    });
    Route::prefix('product')->name('product.')->controller(ProductController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/createQty','createQty')->name('create_qty');
        Route::post('/createQty','post_createQty')->name('post_create_qty');
        Route::get('/getProduct/{product_code}','getProduct')->name('getProduct');
        Route::get('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });
    Route::prefix('brand')->name('brand.')->controller(BrandController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
    });
    Route::prefix('category')->name('category.')->controller(CategoryController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
    });
    Route::prefix('business')->name('business.')->controller(BusinessController::class)->group(function(){
        Route::get('/goods_import','view_goods_import')->name('view_goods_import');
        Route::get('/orders','view_orders')->name('view_orders');
        Route::get('/order-detail/{orderDetailId}','view_order_detail')->name('view_order_detail');
    });
});

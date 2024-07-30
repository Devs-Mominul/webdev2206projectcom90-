<?php

use App\Http\Controllers\asha;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Library\SslCommerz\SslCommerzInterface;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RolePermissionController;

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

Route::get('/ddd', function () {
    return view('welcome');
});
Route::get('/', [CategoryController::class, 'index'])->name('index');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/add_category', [CategoryController::class, 'add_category'])->name('add.category');
Route::post('/add_category_post', [CategoryController::class, 'add_category_post'])->name('add.category.post');
Route::get('/add_subcategory', [CategoryController::class, 'add_subcategory'])->name('add.subcategory');
Route::post('/add_subcategory_post', [CategoryController::class, 'add_subcategory_post'])->name('add.subcategory.post');
Route::get('/add_brand', [CategoryController::class, 'add_brand'])->name('add.brand');
Route::post('/add_brand_post', [CategoryController::class, 'add_brand_post'])->name('add.brand.post');
Route::get('/add_product', [CategoryController::class, 'add_product'])->name('add.product');
Route::post('/getsubcategory', [CategoryController::class, 'getsubcategory']);
Route::post('/productstore', [CategoryController::class, 'product_store'])->name('product.store');
Route::get('/add_variation', [CategoryController::class, 'add_variation'])->name('add.variation');
Route::post('/sizestore', [CategoryController::class, 'size_store'])->name('size.store');
Route::get('/add_list_product', [CategoryController::class, 'product_list'])->name('product.list');
Route::get('/inventory/{id}', [CategoryController::class, 'inventory'])->name('inventory');
Route::post('/inventory/store/{id}', [CategoryController::class, 'inventory_store'])->name('inventory.store');
Route::get('/product/details/{slug}', [CategoryController::class, 'product_details'])->name('product.details');
Route::get('/customer/register', [CategoryController::class, 'register'])->name('customer.register');
Route::get('/customer/login', [CategoryController::class, 'login'])->name('customer.login');
Route::post('/customer/login', [CategoryController::class, 'login_store'])->name('login.store');
Route::post('/customer/store', [CategoryController::class, 'register_store'])->name('register.store');
Route::get('/customer/profile', [CategoryController::class, 'profile'])->name('customer.profile')->middleware('customer');
Route::get('/customer/logout', [CategoryController::class, 'logout'])->name('customer.logout');
Route::post('cart/store', [CategoryController::class, 'cart_store'])->name('cart.store');
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/update', [CartController::class, 'cart_update'])->name('cart.update');
Route::get('/coupon', [CartController::class, 'coupon'])->name('add.coupon');
Route::post('/coupon/store', [CartController::class, 'coupon_store'])->name('coupon.store');
Route::get('/checkout', [CartController::class, 'checkout'])->name('add.checkout');
Route::post('/getCity', [CartController::class, 'getCity']);
Route::post('/order/store', [CartController::class, 'order_store'])->name('order.store');
Route::get('/myorder', [CartController::class, 'myorder'])->name('myorder');
Route::get('/myorder/pdf/{id}', [CartController::class, 'myorder_pdf'])->name('myorder.pdf');
Route::get('/border', [CartController::class, 'border'])->name('border');
Route::post('/order/store/status', [CartController::class, 'order_status'])->name('order.status');
Route::post('/review/store', [CartController::class, 'review_store'])->name('review.store');




// SSLCOMMERZ Start



Route::get('/pay', [SslCommerzPaymentController::class, 'index'])->name('pay');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END


Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe')->name('stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});
Route::get('/password/reset', [PasswordResetController::class, 'password_reset'])->name('passwords.reset');
Route::post('/password/reset/request', [PasswordResetController::class, 'password_reset_request'])->name('passwords.reset.request');
Route::get('/password/reset/form/{data}', [PasswordResetController::class, 'password_reset_form'])->name('passwords.reset.form');
Route::post('/store/password/reset/form/{data}', [PasswordResetController::class, 'password_reset_form_store'])->name('passwords.reset.form.store');
Route::get('/role/permission',[RolePermissionController::class, 'Role'])->name('role.view');
Route::post('/role/permission/store',[RolePermissionController::class, 'role_store'])->name('role.store');
Route::post('/role/store',[RolePermissionController::class, 'role_store_org'])->name('role.store.org');
Route::post('/assign/role',[RolePermissionController::class, 'assign_role'])->name('assign.role');
Route::get('user/assign/remove/{id}',[RolePermissionController::class, 'assign_role_remove'])->name('user.assign.remove');
Route::resource('asha', asha::class);
Route::get('/recent/view', [CategoryController::class, 'recent_view'])->name('recent.view');
Route::get('/reload-captcha', [CategoryController::class, 'reloadCaptcha']);






require __DIR__.'/auth.php';

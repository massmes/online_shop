<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\BrandController;
use \App\Http\Controllers\Admin\AttributeController;
use \App\Http\Controllers\Admin\CategoryController;
use \App\Http\Controllers\Admin\TagController;
use \App\Http\Controllers\Admin\ProductController;
use \App\Http\Controllers\Admin\ProductImageController;
use \App\Http\Controllers\Admin\BannerController;
use \App\Http\Controllers\Admin\CommentController;
use \App\Http\Controllers\Admin\UserController;
use \App\Http\Controllers\Admin\CouponController;
use \App\Http\Controllers\Admin\OrderController;
use \App\Http\Controllers\Admin\TransactionController;
use Ghasedak\Laravel\GhasedakFacade;


//Home Controllers
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\CompareController;
use \App\Http\Controllers\Home\WishlistController;
use App\Http\Controllers\Home\CategoryController as HomeCategoryController;
use App\Http\Controllers\Home\ProductController as HomeProductController;
use App\Http\Controllers\Home\CommentController as HomeCommentController;
use App\Http\Controllers\Home\UserProfileController;
use App\Http\Controllers\Home\CartController;
use App\Http\Controllers\Home\AddressController;
use App\Http\Controllers\Home\PaymentController;

use App\Models\User;
use App\Notifications\OTPSms;

//Auth Controller
use App\Http\Controllers\Auth\AuthController;

use RealRashid\SweetAlert\Facades\Alert;


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

Route::get('/admin-panel/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::prefix('admin-panel/management')->name('admin.')->group(function () {
    Route::resource('brands', BrandController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('products', ProductController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('comments', CommentController::class);
    Route::resource('users', UserController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('transactions', TransactionController::class);

    //for approved comments
    Route::get('/comments/{comment}/change-status', [CommentController::class, 'changeStatus'])->name('comments.change.status');
    // Get Category Attributes
    Route::get('/category-attributes/{category}', [CategoryController::class, 'getCategoryAttributes']);

    // Edit Product Image
    Route::get('/products/{product}/images-edit/{title}', [ProductImageController::class, 'edit'])->name('products.images.edit');
    Route::delete('/products/{product}/images-destroy', [ProductImageController::class, 'destroy'])->name('products.images.destroy');
    Route::put('/products/{product}/images-set-primary', [ProductImageController::class, 'setPrimary'])->name('products.images.set_primary');
    Route::post('/products/{product}/images-add', [ProductImageController::class, 'add'])->name('products.images.add');
    // Edit Product category
    Route::get('/products/{product}/category-edit/{title}', [ProductController::class, 'editCategory'])->name('products.category.edit');
    Route::put('/products/{product}/category-update', [ProductController::class, 'updateCategory'])->name('products.category.update');
});


//Home Route

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/categories/{category:slug}', [HomeCategoryController::class, 'show'])->name('home.categories.show');
Route::get('/products/{product:slug}/{brand:name}', [HomeProductController::class, 'show'])->name('home.products.show');

Route::post('/comments/{product}', [HomeCommentController::class, 'store'])->name('home.comments.store');
//for wishList
Route::get('/add-wish-list/{product}', [WishlistController::class, 'add'])->name('home.wishlist.add');
Route::get('/remove-wish-list/{product}', [WishlistController::class, 'remove'])->name('home.wishlist.remove');

Route::get('/compare', [CompareController::class, 'index'])->name('home.compare.index');
Route::get('/add-to-compare/{product}', [CompareController::class, 'add'])->name('home.compare.add');
Route::get('/remove-from-compare/{product}', [CompareController::class, 'remove'])->name('home.compare.remove');

//shopping cart
Route::get('/cart', [CartController::class, 'index'])->name('home.cart.index');
Route::post('/add-to-cart', [CartController::class, 'add'])->name('home.cart.add');
Route::get('/remove-from-cart/{rowId}', [CartController::class, 'remove'])->name('home.cart.remove');
Route::put('/cart', [CartController::class, 'update'])->name('home.cart.update');
Route::get('/clear-cart', [CartController::class, 'clear'])->name('home.cart.clear');
Route::post('/check-coupon', [CartController::class, 'checkCoupon'])->name('home.coupons.check');

Route::get('/checkout', [CartController::class, 'checkout'])->name('home.orders.checkout');

Route::post('/payment', [PaymentController::class, 'payment'])->name('home.payment');
Route::get('/payment-verify', [PaymentController::class, 'paymentVerify'])->name('home.payment_verify');


Route::get('/login/{provider}', [AuthController::class, 'redirectToProvider'])->name('provider.login');
Route::get('/login/{provider}/callback', [AuthController::class, 'handleProviderCallback']);

//Login CELLPHONE

Route::any('/logincellphone', [AuthController::class, 'loginCellphone'])->name('login.cellphone');
Route::post('/check-otp', [AuthController::class, 'checkOtp'])->name('user.check.otp');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('user.resend.otp');

//

Route::prefix('profile')->name('home.')->group(function () {

    Route::get('/', [UserProfileController::class, 'index'])->name('users_profile.index');

    Route::get('/comments', [HomeCommentController::class, 'usersProfileIndex'])->name('comments.users_profile.index');

    Route::get('/wishlist', [WishlistController::class, 'usersProfileIndex'])->name('wishlist.users_profile.index');

    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');

    Route::get('/orders', [CartController::class, 'usersProfileIndex'])->name('orders.users_profile.index');


});

Route::get('/get-province-cities-list', [AddressController::class, 'getProvinceCitiesList']);

Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('home.about-us');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('home.contact-us');
Route::post('/contact-us-form', [HomeController::class, 'contactUsForm'])->name('home.contact-us.form');


Route::get('/test', function () {
    $user = User::find(16);
    $user->notify(new OTPSms(13646764));
});

Route::get('/logout', function () {
    auth()->logout();
});

Route::get('/test1', function () {
//    \Cart::clear();
//    dd(\Cart::getContent());
//    dd(session()->get('coupon.id'));
});

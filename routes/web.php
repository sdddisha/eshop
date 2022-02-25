<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FrontendController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\PaymentController;


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


Route::get('/', function () {
    return view('welcome');
});
Route::get('/frontend1', [WebsiteController::class, 'index']); 
Route::get('/about-us', [WebsiteController::class, 'aboutus']); 
Route::get('/contact-us', [WebsiteController::class, 'contactus']); 
Route::post('/contact-us', [WebsiteController::class, 'submitcontactus']);
Route::get('buy-now/{id}', [WebsiteController::class, 'buyNow'])->name('buy.now');
Route::get('cart2', [WebsiteController::class, 'cart'])->name('cart2');
Route::patch('update-cart2', [WebsiteController::class, 'update'])->name('update.cart2');
Route::delete('remove-from-cart2', [WebsiteController::class, 'remove'])->name('remove.from.cart2');
Route::get('checkout1/{total}',[WebsiteController::class, 'checkout'])->name('checkout1');
Route::post('placeorder1/{id}/{total}/{ship}',[WebsiteController::class, 'storeCheckoutDetails'])->name('placeorder1');
Route::get('auth/google', [WebsiteController::class, 'redirectToGoogle']);
// Route::get('auth/google', [WebsiteController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [WebsiteController::class, 'handleGoogleCallback']);
Route::get('auth/facebook', [WebsiteController::class, 'facebookRedirect']);
Route::get('auth/facebook/callback', [WebsiteController::class, 'loginWithFacebook']);

Auth::routes();

//using ajax
Route::group(['middleware'=>'prevent_back_history'],function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']); 

});
Route::get('cart', [App\Http\Controllers\HomeController::class, 'cart'])->name('cart');
Route::get('add-to-cart/{id}', [App\Http\Controllers\HomeController::class, 'addToCart'])->name('add.to.cart');
Route::patch('update-cart', [App\Http\Controllers\HomeController::class, 'update'])->name('update.cart');
Route::delete('remove-from-cart', [App\Http\Controllers\HomeController::class, 'remove'])->name('remove.from.cart');
Route::get('/logout', [App\Http\Controllers\HomeController::class, 'perform'])->name('logout');
Route::get('checkout/{total}',[App\Http\Controllers\HomeController::class, 'checkout'])->name('checkout');
Route::post('placeorder/{id}/{total}/{ship}',[App\Http\Controllers\HomeController::class, 'storeCheckoutDetails'])->name('placeorder');
// Route::post('/paypal', [App\Http\Controllers\HomeController::class, 'payWithpaypal'])->name('paypal');
// Route::get('/status', [App\Http\Controllers\HomeController::class, 'getPaymentStatus'])->name('status');


//route for processing payment
Route::post('/paypal/{total}/{data}', [PaymentController::class, 'payWithpaypal'])->name('paypal');

// route for check status of the payment
Route::get('/status/{data}/{total}', [PaymentController::class, 'getPaymentStatus'])->name('status');



 
 //Route::middleware(['auth','isAdmin'])->group(function(){
    Route::group(['middleware'=>'prevent_back_history'],function() {
        Route::get('/dashboard', 'Admin\FrontendController@index'); 
          
    });
    Route::get('/add-pages', 'Admin\FrontendController@show_page');
    Route::post('/signout', [FrontendController::class, 'perform'])->name('signout');
    Route::get('/add-pages', 'Admin\FrontendController@show_page');
    Route::post('/add-pages', 'Admin\FrontendController@add_pages');
    Route::get('/show-pages', 'Admin\FrontendController@show_all_pages');
    Route::get('delete-page/{id}','Admin\FrontendController@delete_page');
    Route::get('add-details/{id}','Admin\FrontendController@add_details');
    Route::get('about','Admin\FrontendController@about');
    Route::post('insert-about', 'Admin\FrontendController@insert_about');
    Route::get('add-category', 'Admin\CategoryController@add');
    Route::post('insert-category', 'Admin\CategoryController@insert');
    Route::get('show-category', 'Admin\CategoryController@show');
    Route::get('add-coupon', 'Admin\CouponController@add');
    Route::post('insert-coupon', 'Admin\CouponController@insert');
    Route::get('show-coupon', 'Admin\CouponController@show');
    Route::get('/coupon-delete/{id}', 'Admin\CouponController@destroy')->name('coupon.destroy');
    Route::get('add-sub-category', 'Admin\CategoryController@addsub');
    Route::post('insert-sub_category', 'Admin\CategoryController@insert_subcategory');
    Route::get('delete-cat/{id}',[CategoryController::class, 'destroy']);
    Route::get('add-product',[ProductController::class, 'add']);
    Route::post('insert-product',[ProductController::class, 'insert']);
    Route::get('show-product',[ProductController::class, 'show']);
    Route::post('subcat',[ProductController::class, 'subcat'])->name('subcat');
    Route::get('/delete-product/{id}', [ProductController::class, 'delete'])->name('delete-product');
    Route::get('show-order', [OrderController::class, 'show']);
    Route::get('refund', [PaymentController::class, 'refund']); 
    Route::post('refund', [PaymentController::class, 'refund_payment']);     
    // });


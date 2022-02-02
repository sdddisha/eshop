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
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('addtocart/{pid}/{price}',[App\Http\Controllers\HomeController::class, 'addToCart'])->name('addtocart');
// Route::get('cartItem',[App\Http\Controllers\HomeController::class, 'cartItem'])->name('cartItem');
// Route::get('delete/{id}/{pid}',[App\Http\Controllers\HomeController::class, 'deletecartItem'])->name('delete');
// Route::get('checkout/{id}/{total}',[App\Http\Controllers\HomeController::class, 'checkout'])->name('checkout');
// Route::post('placeorder/{id}/{total}',[App\Http\Controllers\HomeController::class, 'storeCheckoutDetails'])->name('placeorder');

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
Route::post('/paypal', [App\Http\Controllers\HomeController::class, 'payWithpaypal'])->name('paypal');
Route::get('/status', [App\Http\Controllers\HomeController::class, 'getPaymentStatus'])->name('status');


// route for processing payment
// Route::post('/paypal', [PaymentController::class, 'payWithpaypal'])->name('paypal');

// // route for check status of the payment
// Route::get('/status', [PaymentController::class, 'getPaymentStatus'])->name('status');

 // Route::get('delete-cat/{id}', 'Admin\CategoryController@delete');

 
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
    Route::get('add-sub-category', 'Admin\CategoryController@addsub');
    Route::post('insert-sub_category', 'Admin\CategoryController@insert_subcategory');
    Route::get('delete-cat/{id}',[CategoryController::class, 'delete']);
    Route::get('add-product',[ProductController::class, 'add']);
    Route::post('insert-product',[ProductController::class, 'insert']);
    Route::get('show-product',[ProductController::class, 'show']);
    Route::post('subcat',[ProductController::class, 'subcat'])->name('subcat');
    Route::get('show-order', [OrderController::class, 'show']);
          
    // });


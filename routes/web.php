<?php

use App\Http\Controllers\Dashboard\NotificationsController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Auth\TowFactorAuthenticationController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group([
    'prefix'=>LaravelLocalization::setLocale()


] , function(){

    Route::get('/',[HomeController::class , 'home'])->name('front.home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth:web')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('products',[ProductsController::class , 'index'])->name('front.products.index');
Route::get('products/{product:slug}',[ProductsController::class , 'show'])->name('front.products.show');

Route::resource('/carts' , CartController::class) ;

Route::get('checkout' , [CheckoutController::class , 'create'])->name('checkout');
Route::post('checkout' , [CheckoutController::class , 'store']);

Route::get('/notification', [NotificationsController::class, 'index'])->name('notification.index');


Route::get('auth/user/2fa' , [TowFactorAuthenticationController::class , 'index'])
->name('front.2fa');

});

});


//e.x images/200x300/products/image.png
Route::get('images/{disk}/{width}x{height}/{image}' , [\App\Http\Controllers\ImagesController::class  ,'index'])
    ->name('image')
    ->where('image' ,'.*');



//require __DIR__.'/auth.php';

require __DIR__.'/dashboard.php';
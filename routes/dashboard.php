<?php

use App\Http\Controllers\Dashboard\BrandsController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RolesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin,web'])->prefix('admin/dashboard')->group(function () {
    Route::get('/',[DashboardController::class , 'index'])->middleware(['verified'])->name('admin.dashboard');
    Route::get('categories/trash' , [CategoriesController::class , 'trash'])->name('categories.trash');
    Route::put('categories/{category}/restore' , [CategoriesController::class , 'restore'])->name('categories.restore');
    Route::delete('categories/{category}/force_delete' , [CategoriesController::class , 'force_delete'])->name('categories.force_delete');
    Route::resource('/categories' , CategoriesController::class) ;
    Route::resource('/roles' , RolesController::class) ;
    Route::resource('/brands' , BrandsController::class) ;
    Route::get('brands/trash' , [BrandsController::class , 'trash'])->name('brands.trash');
    Route::put('brands/{brand}/restore' , [BrandsController::class , 'restore'])->name('brands.restore');
    Route::delete('brands/{brand}/force_delete' , [BrandsController::class , 'force_delete'])->name('brands.force_delete');
    Route::get('products/trash' , [ProductsController::class , 'trash'])->name('products.trash');
    Route::put('products/{product}/restore' , [ProductsController::class , 'restore'])->name('products.restore');
    Route::delete('products/{product}/force_delete' , [ProductsController::class , 'force_delete'])->name('products.force_delete');
    Route::resource('/products' , ProductsController::class) ;
    Route::get('profile' , [ProfileController::class , 'edit'])->name('profiles.edit');
    Route::patch('profile' , [ProfileController::class , 'update'])->name('profiles.update');
    Route::get('product/export' , [ProductsController::class , 'export'])->name('product.export');
    Route::get('product/import' , [ProductsController::class , 'importView'])->name('product.import');
    Route::post('product/import' , [ProductsController::class , 'import'])->name('import');
    Route::get('orders/{order}/print' , [\App\Http\Controllers\Dashboard\OrdersControllers::class , 'print'])->name('orders.print');
    Route::resource('/orders' , \App\Http\Controllers\Dashboard\OrdersControllers::class) ;
    Route::put('/orders/{order}/cancel', [\App\Http\Controllers\Dashboard\OrdersControllers::class , 'cancel'])->name('orders.cancel');
    Route::put('/orders/{order}/accept', [\App\Http\Controllers\Dashboard\OrdersControllers::class , 'accept'])->name('orders.accept');


    Route::get('charts/orders',[DashboardController::class , 'ordersChart'])->name('charts.orders');
    Route::get('news-letters',[DashboardController::class , 'newsLetters']);


});

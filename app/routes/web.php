<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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

Route::get('/home', 'HomeController@index')->name('home');

// ここから処理する

Auth::routes();

Route::middleware(['auth'])->group(function () {

    // マイページ（管理者）を表示する
    Route::get('/mypage', [UserController::class, 'index'])->name('mypage');
    //商品管理
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/confirm', [ProductController::class, 'confirm'])->name('products.confirm');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    //商品詳細ページ
    Route::get('/products/{product}', 'ProductController@show')->name('products.show');
    //編集機能
    Route::get('/products/{product}/edit', 'ProductController@edit')->name('products.edit');
    Route::post('/products/{product}/update', 'ProductController@update')->name('products.update');
    //削除機能
    Route::delete('/products/{product}', 'ProductController@destroy')->name('products.destroy');
});


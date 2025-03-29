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

//ダッシュボードページ作成
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    // 在庫一覧ページ（仮）
    Route::get('/inventory_list', 'InventoryController@index')->name('inventory_list');
    Route::get('/inventory/detail/{id}', 'InventoryController@show')->name('inventory.show');;
    Route::delete('/inventory/{product_id}/{user_id}', 'InventoryController@destroy')->name('inventory.destroy');
    Route::get('/product_list', 'ProductController@index')->name('product_list');
    Route::get('/inventory/{product_id}/{user_id}', 'InventoryController@show')->name('inventory.group_show');
    // 入荷予定一覧ページ（仮）
    Route::get('/incoming_list', 'IncomingController@index')->name('incoming_list');

      //入荷一覧
  Route::get('/incoming_list', 'IncomingController@index')->name('incoming_list');
  Route::get('/incoming_add', 'IncomingController@create')->name('incoming_add');
  Route::post('/incoming_store', 'IncomingController@store')->name('incoming_store');
  Route::get('/incoming_edit/{id}', 'IncomingController@edit')->name('incoming_edit');
  Route::post('/incoming_update/{id}', 'IncomingController@update')->name('incoming_update');
  Route::post('/incoming_delete/{id}', 'IncomingController@destroy')->name('incoming_delete');
  Route::get('/incoming_confirm/{id}', 'IncomingController@confirmPage')->name('incoming_confirm');
  Route::post('/incoming_confirm_process/{id}', 'IncomingController@confirm')->name('incoming_confirm_process');
  Route::get('/incoming_delete_conf/{id}', 'IncomingController@deleteConfirm')->name('incoming_delete_conf');

});

Route::middleware(['auth', 'admin'])->group(function () {

    // マイページ（管理者）を表示する
    Route::get('/mypage', [UserController::class, 'index'])->name('mypage');
    Route::get('/product_list', [ProductController::class, 'index'])->name('products.index');
    //商品管理
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/confirm', [ProductController::class, 'confirm'])->name('products.confirm');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    //商品詳細ページ
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    //編集機能
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/{product}/update', [ProductController::class, 'update'])->name('products.update');
    //削除機能
    Route::get('/products/delete/{id}', 'ProductController@deleteConfirm')->name('products.delete.confirm');
    Route::delete('/products/delete/{id}', 'ProductController@destroy')->name('products.delete');

  // ユーザー管理ページ（管理者のみアクセス可能）
  Route::get('/users', [UserController::class, 'userList'])->name('users.list'); //  ユーザー一覧ページ
  Route::get('/users/create', [UserController::class, 'create'])->name('users.create'); // ユーザー登録ページ
  Route::post('/users', [UserController::class, 'store'])->name('users.store'); // ユーザー登録処理
  Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit'); // ユーザー編集ページ
  Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update'); // ユーザー更新処理
  Route::get('/users/{id}/delete', [UserController::class, 'deleteConfirm'])->name('users.delete.confirm'); // 削除確認ページ
  Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy'); // ユーザー削除処理


});


<?php

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
Route::group(['prefix' => 'admin'], function() {
    Route::get('goods/create', 'Admin\GoodsController@add')->middleware('auth');
    Route::post('goods/create', 'Admin\GoodsController@create')->middleware('auth');
    Route::get('goods', 'Admin\GoodsController@index')->middleware('auth'); // 追記
    Route::get('goods/edit', 'Admin\GoodsController@edit')->middleware('auth'); // 追記
    Route::post('goods/edit', 'Admin\GoodsController@update')->middleware('auth'); // 追記
    Route::get('goods/delete', 'Admin\GoodsController@delete')->middleware('auth');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

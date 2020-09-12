<?php

use Illuminate\Support\Facades\Route;

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


Route::any('news/login','News\LoginController@login');
Route::any('news/logindo','News\LoginController@logindo');

Route::prefix('news')->middleware('checkuser')->group(function(){
    Route::any('create','News\NewsController@create');
    Route::any('store','News\NewsController@store');
    Route::any('list','News\NewsController@index');
    Route::any('product/{id}','News\NewsController@product');
});

Route::any('/brand','Admin\BrandController@index')->name('brand');
Route::get('/brand/create','Admin\BrandController@create')->name('brand.create');
Route::post('/brand/store','Admin\BrandController@store');
Route::post('/brand/upload','Admin\BrandController@upload');
Route::get('/brand/edit/{brand_id}','Admin\BrandController@edit');
Route::post('/brand/update/{brand_id}','Admin\BrandController@update');
Route::get('/brand/destroy/{brand_id?}','Admin\BrandController@destroy');
Route::post('/brand/check_name','Admin\BrandController@check_name');

//商品
Route::prefix('goods')->group(function(){
    Route::any('index','Admin\GoodsController@index')->name("goods");
    Route::any('create','Admin\GoodsController@create')->name("goods.create");
    Route::post('upload','Admin\GoodsController@upload');
    Route::any('store','Admin\GoodsController@store');
    Route::any('checkge','Admin\GoodsController@checkge');
    Route::any('ajaxji','Admin\GoodsController@ajaxji');
    Route::get('destroy/{brand_id?}','Admin\GoodsController@destroy');
    Route::get('edit/{goods_id?}','Admin\GoodsController@edit');
    Route::any('update/{goods_id}','Admin\GoodsController@update');
});

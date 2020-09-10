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
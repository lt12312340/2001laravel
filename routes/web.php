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


// Route::any('news/login','News\LoginController@login');
// Route::any('news/logindo','News\LoginController@logindo');

// Route::prefix('news')->middleware('checkuser')->group(function(){
//     Route::any('create','News\NewsController@create');
//     Route::any('store','News\NewsController@store');
//     Route::any('list','News\NewsController@index');
//     Route::any('product/{id}','News\NewsController@product');
// });

// 品牌管理
Route::any('/brand','Admin\BrandController@index')->name('brand');
Route::get('/brand/create','Admin\BrandController@create')->name('brand.create');
Route::post('/brand/store','Admin\BrandController@store');
Route::post('/brand/upload','Admin\BrandController@upload');
Route::get('/brand/edit/{brand_id}','Admin\BrandController@edit');
Route::post('/brand/update/{brand_id}','Admin\BrandController@update');
Route::get('/brand/destroy/{brand_id?}','Admin\BrandController@destroy');
Route::post('/brand/check_name','Admin\BrandController@check_name');

// 项目后台分类管理
Route::any('/category','Admin\CategoryController@index')->name('category');//分类列表
Route::any('/category/create','Admin\CategoryController@create')->name('category.create');//分类添加页面
Route::any('/category/store','Admin\CategoryController@store');//分类执行添加
Route::any('/category/destroy/{cate_id}','Admin\CategoryController@destroy');//删除
Route::any('/category/check_cateshows','Admin\CategoryController@check_cateshows');//对错号

//管理员
Route::get('/admin/create','Admin\AdminController@create')->name('admin.create');//表单展示
Route::post('/admin/store','Admin\AdminController@store');//执行添加
Route::post('/admin/upload','Admin\AdminController@upload');//文件上传拖拽
Route::any('/admin','Admin\AdminController@index')->name('admin');//列表展示
Route::get('/admin/edit/{admin_id}','Admin\AdminController@edit');//修改页面
Route::post('/admin/updata/{admin_id}','Admin\AdminController@updata');//执行修改
Route::get('/admin/destroy/{admin_id?}','Admin\AdminController@destroy');//删除
Route::get('/login','Admin\AdminController@login');//登录
Route::get('/logindo','Admin\AdminController@logindo');//执行登录

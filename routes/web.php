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


Route::middleware('checkuselogin')->group(function(){
//后台首页
Route::view('/main','admin.main')->name('main');

// 品牌管理
Route::any('/brand','Admin\BrandController@index')->name('brand');
Route::get('/brand/create','Admin\BrandController@create')->name('brand.create');
Route::post('/brand/store','Admin\BrandController@store')->name('brand.store');
Route::post('/brand/upload','Admin\BrandController@upload')->name('brand.upload');
Route::get('/brand/edit/{brand_id}','Admin\BrandController@edit')->name('brand.edit');
Route::post('/brand/update/{brand_id}','Admin\BrandController@update')->name('brand.update');
Route::get('/brand/destroy/{brand_id?}','Admin\BrandController@destroy')->name('brand.destory');
Route::post('/brand/check_name','Admin\BrandController@check_name')->name('brand.check_name');


//商品
Route::prefix('goods')->group(function(){
    Route::any('index','Admin\GoodsController@index')->name("goods");
    Route::any('create','Admin\GoodsController@create')->name("goods.create");
    Route::post('upload','Admin\GoodsController@upload')->name("goods.upload");
    Route::any('store','Admin\GoodsController@store')->name("goods.store");
    Route::any('checkge','Admin\GoodsController@checkge');
    Route::any('ajaxji','Admin\GoodsController@ajaxji');
    Route::get('destroy/{brand_id?}','Admin\GoodsController@destroy')->name("goods.destroy");
    Route::get('edit/{goods_id?}','Admin\GoodsController@edit')->name("goods.edit");
    Route::any('update/{goods_id}','Admin\GoodsController@update')->name("goods.update");
});

// 项目后台分类管理
Route::any('/category','Admin\CategoryController@index')->name('category');//分类列表
Route::any('/category/create','Admin\CategoryController@create')->name('category.create');//分类添加页面
Route::any('/category/store','Admin\CategoryController@store')->name('category.store');//分类执行添加
Route::any('/category/destroy/{cate_id}','Admin\CategoryController@destroy')->name('category.destroy');//删除
Route::any('/category/check_cateshows','Admin\CategoryController@check_cateshows')->name('category.check_cateshows');//对错号

//管理员
Route::get('/admin/create','Admin\AdminController@create')->name('admin.create');//表单展示
Route::post('/admin/store','Admin\AdminController@store')->name('admin.store');//执行添加
Route::post('/admin/upload','Admin\AdminController@upload')->name('admin.upload');//文件上传拖拽
Route::any('/admin','Admin\AdminController@index')->name('admin');//列表展示
Route::get('/admin/edit/{admin_id}','Admin\AdminController@edit')->name('admin.edit');//修改页面
Route::post('/admin/updata/{admin_id}','Admin\AdminController@updata')->name('admin.update');//执行修改
Route::get('/admin/destroy/{admin_id?}','Admin\AdminController@destroy')->name('admin.destroy');//删除


//角色
Route::prefix('/role')->group(function(){
    Route::get('/create','Admin\RoleController@create')->name('role.create');//表单展示
    Route::post('store','Admin\RoleController@store')->name('role.store');//执行添加
    Route::any('/','Admin\RoleController@index')->name('role');//列表展示
    Route::get('/destroy/{role_id?}','Admin\RoleController@destroy')->name('role.destroy');//单删  批删
    Route::post('/check_name','Admin\RoleController@check_name');//即点即改
    Route::get('/edit/{role_id}','Admin\RoleController@edit')->name('role.edit');//修改页面
    Route::post('/update/{role_id}','Admin\RoleController@update')->name('role.update');//执行修改
    Route::get('/addpriv/{id}','Admin\RoleController@addpriv')->name('role.addpriv');//角色添加权限
    Route::post('/addprivdo','Admin\RoleController@addprivdo')->name('role.addprivdo');//执行添加权限
});


//权限管理
Route::get('/menu/create','Admin\MenuController@create')->name('menu.create');
Route::post('/menu/store','Admin\MenuController@store')->name('menu.store');
Route::any('/menu','Admin\MenuController@index')->name('menu');
Route::post('/menu/check_name','Admin\MenuController@check_name')->name('menu.check_name');
Route::get('/menu/destroy/{id?}','Admin\MenuController@destroy')->name('menu.destroy');
Route::get('/menu/edit/{id}','Admin\MenuController@edit')->name('menu.edit');
Route::post('/menu/update/{id}','Admin\MenuController@update')->name('menu.update');

//商品属性
Route::prefix('/attribute')->group(function(){
    Route::get('/create','Admin\AttributeController@create')->name('attribute.create');//表单展示
    Route::post('store','Admin\AttributeController@store')->name('attribute.store');//执行添加
    Route::any('/','Admin\AttributeController@index')->name('attribute');//列表展示
    Route::post('/check_name','Admin\AttributeController@check_name')->name('attribute.check_name');//即点即改
    Route::get('/destroy/{attr_id?}','Admin\AttributeController@destroy')->name('attribute.destroy');//单删  批删
    Route::get('/edit/{attr_id}','Admin\AttributeController@edit')->name('attribute.edit');//修改页面
    Route::post('/update/{attr_id}','Admin\AttributeController@update')->name('attribute.update');//执行修改
});


});

Route::get('/loginout','Admin\AdminController@loginout');//退出登录
//登录
Route::get('/login','Admin\AdminController@login');//登录
Route::get('/logindo','Admin\AdminController@logindo');//执行登录
Route::get('/getCaptcha','Admin\AdminController@getCaptcha')->name('getCaptcha');//验证码

//403
Route::view('/403','admin.403');




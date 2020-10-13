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

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::any('news/login','News\LoginController@login');
// Route::any('news/logindo','News\LoginController@logindo');

// Route::prefix('news')->middleware('checkuser')->group(function(){
//     Route::any('create','News\NewsController@create');
//     Route::any('store','News\NewsController@store');
//     Route::any('list','News\NewsController@index');
//     Route::any('product/{id}','News\NewsController@product');
// });

Route::domain('www.laravel01.com')->group(function(){

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
    Route::any('/getattr','Admin\GoodsController@getattr');
    Route::any('create','Admin\GoodsController@create')->name("goods.create");
    Route::post('upload','Admin\GoodsController@upload')->name("goods.upload");
    Route::post('/product','Admin\GoodsController@product')->name("goods.product");//货品入库
    Route::any('store','Admin\GoodsController@store')->name("goods.store");
    Route::any('checkge','Admin\GoodsController@checkge');
    Route::any('ajaxji','Admin\GoodsController@ajaxji');
    Route::get('/show/{goods_id}','Admin\GoodsController@show')->name("goods.show");//商品预览
    Route::get('/getattrprice','Admin\GoodsController@getattrprice')->name("goods.getattrprice");//商品预览
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


// 商品类型
Route::prefix('/goods_type')->group(function(){
    Route::get('/create','Admin\GoodsTypeController@create')->name('goods_type.create');//添加页面
    Route::post('/store','Admin\GoodsTypeController@store')->name('goods_type.store');//执行添加
    Route::get('/index','Admin\GoodsTypeController@index')->name('goods_type.index');//列表展示
    Route::get('/destroy/{cat_id?}','Admin\GoodsTypeController@destroy')->name('goods_type.destroy');//单删  批删
    Route::post('/check_name','Admin\GoodsTypeController@check_name')->name('goods_type.check_name');//名称即点即改
    Route::any('/check_typeshows','Admin\GoodsTypeController@check_typeshows')->name('goods_type.check_typeshows');//对错号
    Route::get('/edit/{cat_id}','Admin\GoodsTypeController@edit')->name('goods_type.edit');//修改页面
    Route::post('/update/{cat_id}','Admin\GoodsTypeController@update')->name('goods_type.update');//执行修改
    Route::any('/attrshow/{cat_id}','Admin\GoodsTypeController@attrshow')->name('goods_type.attrshow');//商品属性列表
});

//商品属性
Route::prefix('/attribute')->group(function(){
    Route::get('/create/{cat_id}','Admin\AttributeController@create')->name('attribute.create');//表单展示
    Route::post('store','Admin\AttributeController@store')->name('attribute.store');//执行添加
    Route::any('/','Admin\AttributeController@index')->name('attribute');//列表展示
    Route::post('/check_name','Admin\AttributeController@check_name')->name('attribute.check_name');//即点即改
    Route::get('/destroy/{attr_id?}','Admin\AttributeController@destroy')->name('attribute.destroy');//单删  批删
    Route::get('/edit/{attr_id}','Admin\AttributeController@edit')->name('attribute.edit');//修改页面
    Route::post('/update/{attr_id}','Admin\AttributeController@update')->name('attribute.update');//执行修改
});

//广告管理
Route::prefix('/ad')->group(function(){
    Route::any('/create','Admin\AdController@create')->name('ad.create');//添加广告
    Route::any('/store','Admin\AdController@store')->name('ad.store');//执行添加广告
    Route::post('/upload','Admin\AdController@upload')->name('ad.upload');//图片
    Route::any('/','Admin\AdController@index')->name('ad');//广告展示
    Route::get('/position/{position_id}','Admin\AdController@showads')->name('ad.showad');//查看广告
    Route::get('/position/createhtml/{position_id}','Admin\AdController@createhtml')->name('ad.createhtml');//生成广告
});

//广告位置管理
Route::prefix('/position')->group(function(){
    Route::any('/create','Admin\PositionController@create')->name('position.create');//添加广告位
    Route::post('/store','Admin\PositionController@store')->name('position.store');//执行添加广告位
    Route::any('/','Admin\PositionController@index')->name('position');//广告位展示
    Route::get('/destroy/{position_id?}','Admin\PositionController@destroy')->name('position.destroy');//单删  批删
    Route::post('/check_name','Admin\PositionController@check_name')->name('position.check_name');//即点即改
    Route::get('/edit/{position_id}','Admin\PositionController@edit')->name('position.destroy');//修改视图
    Route::post('/update/{position_id}','Admin\PositionController@update')->name('position.update');//执行修改
});

});

Route::get('/loginout','Admin\AdminController@loginout');//退出登录
//登录
Route::get('/login','Admin\AdminController@login');//登录
Route::post('/logindo','Admin\AdminController@logindo');//执行登录
Route::get('/getCaptcha','Admin\AdminController@getCaptcha')->name('getCaptcha');//验证码

//403
Route::view('/403','admin.403');

});


//前台
Route::domain('index.laravel01.com')->group(function(){
    Route::any('/','Index\IndexController@index');//前台首页
    Route::get('/login','Index\LoginController@login');//前台登录视图
    Route::get('/register','Index\LoginController@register');//前台注册视图
    Route::get('/sendcode','Index\LoginController@sendcode');//前台注册发送验证码
    Route::post('/registerdo','Index\LoginController@registerdo');//注册
    Route::post('/logindo','Index\LoginController@logindo');//登录
    Route::get('/loginout','Index\LoginController@loginout');//退出登录
    
    Route::get('/goodslist/{cate_id}','Index\CatController@goodslist');//商品列表
    Route::get('/goodsinfo/{goods_id}','Index\IndexController@goodsinfo');//商品详情
    Route::get('/getattrprice','Index\IndexController@getattrprice');//获取商品sku价格
    Route::get('/addcart','Index\CartController@addcart');//添加商品购物车

    Route::middleware('checkuserlogin')->group(function(){
        Route::get('/cart','Index\CartController@cart');//购物车展示
        Route::get('/getcartprice','Index\CartController@getcartprice');//获取总价
        Route::get('/confirmorder','Index\OrderController@confirmorder');//点击结算 跳转收货地址
        Route::get('/getsonaddress','Index\OrderController@getsonaddress');//获取子地区
        Route::post('/useraddressadd','Index\OrderController@useraddressadd');//用户收货地址添加
        Route::post('/order','Index\OrderController@order');//用户收货地址添加
    });
});



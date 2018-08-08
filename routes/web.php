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
//测试
Route::get('/mail', function () {
    $order= \App\Models\Order::find(1);

    return new \App\Mail\Shipped($order);
});
Route::domain('admin.ele.com')->namespace('Admin')->group(function () {
    //管理商家
    Route::any('admin/user',"UserController@user")->name("admin.user");
    //添加商家
    Route::any('admin/user_add',"UserController@userAdd")->name("admin.user_add");
//    编辑商家
    Route::any('admin/user_edit/{id}',"UserController@userEdit")->name("admin.user_edit");
//    删除商家
    Route::any('admin/user_del/{id}',"UserController@userDel")->name("admin.user_del");
//    启用或禁用商家
    Route::any('admin/status/{id}',"UserController@status")->name("admin.status");
//    重置商家密码
    Route::any('admin/reset/{id}',"UserController@reset")->name("admin.reset");



//管理员列表
    Route::any('admin/index',"AdminController@index")->name("admin.index");
//添加管理员
    Route::any('admin/add',"AdminController@add")->name("admin.add");
//管理员登录
    Route::any('admin/login',"AdminController@login")->name("admin.login");
//管理员退出
    Route::any('admin/logout',"AdminController@logout")->name("admin.logout");
//编辑管理员
    Route::any('admin/edit/{id}',"AdminController@edit")->name("admin.edit");
//删除管理员
    Route::any('admin/del/{id}',"AdminController@del")->name("admin.del");



//    管理商铺
    Route::any('admin/shop',"ShopController@shop")->name("admin.shop");
//    编辑商铺
    Route::any('admin/shop_edit/{id}',"ShopController@shopEdit")->name("admin.shop_edit");
//    删除商铺
    Route::any('admin/shop_del/{id}',"ShopController@shopDel")->name("admin.shop_del");
//    修改状态
    Route::any('admin/shop_status/{id}',"ShopController@shopStatus")->name("admin.shop_status");


 //    活动管理
    Route::any('active/index',"ActiveController@index")->name("active.index");
//    编辑活动
    Route::any('active/edit/{id}',"ActiveController@edit")->name("active.edit");
//添加活动
    Route::any('active/add',"ActiveController@add")->name("active.add");
//    删除活动
    Route::any('active/del/{id}',"ActiveController@del")->name("active.del");
//    抽奖管理
    Route::any('event/index',"EventController@index")->name("event.index");
    Route::any('event/add',"EventController@add")->name("event.add");
    Route::any('event/edit/{id}',"EventController@edit")->name("event.edit");
    Route::any('event/del/{id}',"EventController@del")->name("event.del");
//    抽奖
    Route::any('event/draw/{id}',"EventController@draw")->name("event.draw");

    //报名管理

//    报名列表
    Route::any('join/index',"EventUserController@index")->name("join.index");

//    奖品管理
    Route::any('prize/index',"EventPrizeController@index")->name("prize.index");
    Route::any('prize/add',"EventPrizeController@add")->name("prize.add");
    Route::any('prize/edit/{id}',"EventPrizeController@edit")->name("prize.edit");
    Route::any('prize/del/{id}',"EventPrizeController@del")->name("prize.del");


    //    分类管理
    Route::any('admin/cate',"ShopCategoryController@cate")->name("admin.cate");
//    添加分类
    Route::any('admin/cate_add',"ShopCategoryController@cateAdd")->name("admin.cate_add");
//    编辑分类
    Route::any('admin/cate_edit/{id}',"ShopCategoryController@cateEdit")->name("admin.cate_edit");
//    删除分类
    Route::any('admin/cate_del/{id}',"ShopCategoryController@cateDel")->name("admin.cate_del");
//    修改分类状态
    Route::any('admin/cate_status/{id}',"ShopCategoryController@cateStatus")->name("admin.cateStatus");


//数据统计首页
    Route::any('orders/index',"OrderController@index")->name("orders.index");

//会员管理
    Route::any('vip/index',"VipController@index")->name("vip.index");
    Route::any('vip/status/{id}',"VipController@status")->name("vip.status");
    Route::any('vip/money/{id}',"VipController@money")->name("vip.money");

//    权限管理
Route::any("per/add","PermissionController@add")->name("per.add");
Route::any("per/index","PermissionController@index")->name("per.index");
Route::any("per/del/{id}","PermissionController@del")->name("per.del");


//    角色管理
    Route::any("role/add","RoleController@add")->name("role.add");
    Route::any("role/index","RoleController@index")->name("role.index");
    Route::any("role/del/{id}","RoleController@del")->name("role.del");
    Route::any("role/edit/{id}","RoleController@edit")->name("role.edit");

//导航管理
    Route::any("nav/add","NavController@add")->name("nav.add");
    Route::any("nav/edit/{id}","NavController@edit")->name("nav.edit");
    Route::any("nav/del/{id}","NavController@del")->name("nav.del");
    Route::any("nav/index","NavController@index")->name("nav.index");







});



Route::domain('shop.ele.com')->namespace('Shop')->group(function () {
    //商家注册
    Route::any('user/add2',"UserController@add2")->name("user.add2");

    //商家登录
    Route::any('user/login',"UserController@login")->name("user.login");
//    商家注销
    Route::any('user/logout',"UserController@logout")->name("user.logout");
//商家首页
    Route::any('user/index',"UserController@index")->name("user.index");
//编辑商家信息
    Route::any('user/edit/{id}',"UserController@edit")->name("user.edit");


 //编辑商铺信息
    Route::any('shop/edit/{id}',"ShopController@edit")->name("shop.edit");



//显示菜品分类表
Route::any('menu_category/index',"MenuCategoryController@index")->name("menu_category.index");
//    添加菜品分类
Route::any('menu_category/add/{id}',"MenuCategoryController@add")->name("menu_category.add");
//    编辑菜品分类
Route::any('menu_category/edit/{id}',"MenuCategoryController@edit")->name("menu_category.edit");
//    删除菜品分类
Route::any('menu_category/del/{id}',"MenuCategoryController@del")->name("menu_category.del");

//显示菜品表
Route::any('menu/index',"MenuController@index")->name("menu.index");
//    添加菜品
Route::any('menu/add/{id}',"MenuController@add")->name("menu.add");
//    编辑菜品
Route::any('menu/edit/{id}',"MenuController@edit")->name("menu.edit");
//    删除菜品
Route::any('menu/del/{id}',"MenuController@del")->name("menu.del");


//订单首页
//Route::any('order/edit/{id}',"OrderController@edit")->name("order.edit");
Route::any('order/index',"OrderController@index")->name("order.index");
Route::any('order/goods/{id}',"OrderController@goods")->name("order.goods");
Route::any('order/cancel/{id}',"OrderController@cancel")->name("order.cancel");
Route::any('order/send/{id}',"OrderController@send")->name("order.send");
Route::any('order/stat',"OrderController@stat")->name("order.stat");
Route::any('goods/stat',"OrderGoodController@stat")->name("goods.stat");

//    商家报名
    Route::any('user/join/{uid}/{eid}',"UserController@join")->name("user.join");
    Route::any('user/win/{id}',"UserController@win")->name("user.win");

    /*  //店铺
      Route::any('shop/index',"ShopController@index")->name("shop.index");
      Route::any('shop/add',"ShopController@add")->name("shop.add");
      Route::any('shop/edit/{id}',"ShopController@edit")->name("shop.edit");
      Route::any('shop/del/{id}',"ShopController@del")->name("shop.del");
      Route::any('shop/status/{id}',"ShopController@status")->name("shop.status");

      Route::any('user/list',"UserController@list")->name("user.list");
      Route::any('user/add',"UserController@add")->name("user.add");



      Route::any('user/edit/{id}',"UserController@edit")->name("user.edit");
      Route::any('user/reset/{id}',"UserController@reset")->name("user.reset");
      Route::any('user/del/{id}',"UserController@del")->name("user.del");
      Route::any('user/status/{id}',"UserController@status")->name("user.status");

      Route::any('shop_cate/index',"ShopCategoryController@index")->name("shop_cate.index");
      Route::any('shop_cate/add',"ShopCategoryController@add")->name("shop_cate.add");
      Route::any('shop_cate/del/{id}',"ShopCategoryController@del")->name("shop_cate.del");
      Route::any('shop_cate/edit/{id}',"ShopCategoryController@edit")->name("shop_cate.edit");
      Route::any('shop_cate/status/{id}',"ShopCategoryController@status")->name("shop_cate.status");
      */


});

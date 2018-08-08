<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::namespace('Api')->group(function () {
    // 在 "App\Http\Controllers\Admin" 命名空间下的控制器

Route::get("shop/list","ShopController@list");
Route::get("shop/index","ShopController@index");


Route::any("remember/regist","RememberController@regist");
Route::any("remember/login","RememberController@login");
Route::any("remember/sms","RememberController@sms");
Route::any("remember/edit","RememberController@edit");
Route::any("remember/forget","RememberController@forget");
Route::any("remember/detail","RememberController@detail");
Route::any("remember/pay","RememberController@pay");

Route::any("address/add","AddressController@add");
Route::any("address/edit","AddressController@edit");
Route::any("address/list","AddressController@list");
//地址详情
Route::any("address/detail","AddressController@detail");


Route::any("cart/add","CartController@add");
Route::any("cart/list","CartController@list");


Route::any("order/add","OrderController@add");
Route::any("order/detail","OrderController@detail");
Route::any("order/list","OrderController@list");



});
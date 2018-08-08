<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\Shop;
use App\Models\Vip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShopController extends BaseController
{
    //
    /**
     * 商铺列表
     * @return \Illuminate\Support\Collection
     */
    public function list(Request $request)
    {
        $shops=Shop::where("status",1)->get();
        if($request->keyword !==null){
            $shops=Shop::where("shop_name","like","%{$request->keyword}%")->where("status",1)->get();
        }
      foreach ( $shops as $shop){
          $shop->distance =rand(200,1000);
          $shop->estimate_time=$shop->distance/100;
      }
        return $shops;
    }

    /**
     * 指定的商铺
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function index(Request $request)
    {
        //获取id
        $id= $request->input("id");
        $shop=Shop::findOrFail($id);
        $shop->distance =rand(200,1000);
        $shop->estimate_time=$shop->distance/100;
        $shop->evaluate=[
            [ "user_id"=> 12344,
                "username"=> "w******k",
                "user_img"=> "http=>//www.homework.com/images/slider-pic4.jpeg",
                "time"=> "2017-2-22",
                "evaluate_code"=> 1,
                "send_time"=> 30,
                "evaluate_details"=> "不怎么好吃"],
            [ "user_id"=> 12344,
                "username"=> "w******k",
                "user_img"=> "http=>//www.homework.com/images/slider-pic4.jpeg",
                "time"=> "2017-2-22",
                "evaluate_code"=> 1,
                "send_time"=> 30,
                "evaluate_details"=> "不怎么好吃"],

        ];
//        得到分类
        $cates =  MenuCategory::where("shop_id",$id)->get();
//        $cates=MenuCategory::where("shop_id" ,$id)->get();
//        var_dump($cates);exit;
//        循环分类得到分类下的所有商品
        foreach ($cates as $cate){
            $cate->goods_list=Menu::where("category_id",$cate->id)->get();
        }
        $shop->commodity=$cates;
         return $shop;
    }



}

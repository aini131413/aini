<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends BaseController
{
    public function add()
    {
        $vip_id=\request()->user_id;
        $menus=\request()->goodsList;
        $counts=\request()->goodsCount;
        //传过来的商品 和数量 的下标相同
        Cart::where("vip_id",$vip_id)->delete();
        foreach ($menus as $k => $menu){
            $data=[
                "vip_id"=>$vip_id,
                "menu_id"=>$menu,
                "count"=>$counts[$k]
            ];
            Cart::create($data);
        }
//        $count=\request()->count;
        return[
            "status"=>"true",
            "message"=>"添加购物车成功"
        ];
    }


    public function list()
    {
        $data=[];
        $data["goods_list"]=[];
        $sum=0;
        $vip_id=\request()->user_id;
        $carts= Cart::where("vip_id",$vip_id)->get();
        foreach ($carts as  $cart){
        $menu_id=$cart->menu_id;
        $menu=Menu::find($menu_id);
        $amount=$cart->count;
        $menu->amount=$amount;
        $price=$menu->goods_price * $amount;
        $sum +=$price;
        array_push($data["goods_list"],$menu);
//            $data["goods_list"][]=$menu;
//        var_dump($menu);
    }

        $data["totalCost"]=$sum;
//                var_dump($data);
       return $data;
    }


}

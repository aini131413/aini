<?php

namespace App\Http\Controllers\Shop;

use App\Models\Order;
use App\Models\OrderGood;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderGoodController extends BaseController
{
    public function stat()
    {
        $order_id = [];
        //通过user_id 找到shopID
        $shop_id = Auth::user()->shop_id;
        //通过shopID找到所有的已付款的订单id
        $datas = Order::where("shop_id", $shop_id)
            ->where("status", ">=", 1)
            ->get();
//        var_dump($datas->toArray());exit;
        foreach ($datas as $data) {
            $order_id[] = $data->id;
        }
        $goods=  OrderGood::whereIn("order_id", $order_id)
            ->Select(DB::raw("goods_id,goods_name,sum(amount) as nums ,DATE_FORMAT(created_at, '%Y-%m-%d') as date"))
            ->groupBy("date","goods_id")
            ->orderBy("date","desc");
           if(\request()->start !== null){
               $goods->whereDate("created_at", ">=",\request()->start);
           }
             if(\request()->end !== null){
            $goods->whereDate("created_at", "<=",\request()->end);
        }
        $goods =$goods->get();

        $gs=  OrderGood::whereIn("order_id", $order_id)
            ->Select(DB::raw("goods_id as g_id,goods_name as name,sum(amount) as num ,DATE_FORMAT(created_at, '%Y-%m') as month"))
            ->groupBy("month","g_id")
            ->orderBy("month","desc")
            ->get();
       return view("shop.order.goodstat",compact("goods","gs"));
    }
}
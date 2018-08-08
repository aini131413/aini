<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderGood;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    public function index()
    {
//        每日订单统计
        $users=User::all();
        $orders=Order::Select(DB::raw("sum(total) as money,count(*) as count,shop_id ,DATE_FORMAT(created_at, '%Y-%m-%d') as date"))->groupBy("date")
            ->orderBy("date","desc");
//每月订单统计
        $os=Order::Select(DB::raw("sum(total) as m,count(*) as c,shop_id ,DATE_FORMAT(created_at, '%Y-%m') as d"))
            ->groupBy("d")
            ->orderBy("d","desc");

        if (\request()->start !== null){
        $orders->whereDate("created_at",">=",\request()->start);
    }
        if (\request()->end !== null){
            $orders->whereDate("created_at","<=",\request()->end);
        }
        if (\request()->user !== null){
            $orders->where("shop_id",\request()->user);
            $os->where("shop_id",\request()->user);
        }
        $orders=$orders->get();
        $os=$os->get();



//  每日商品销售统计

//        找出所有商家信息
        $us=User::all();
//        命名一个数组存放订单id
        $order_id = [];
//        找出所有订单状态大于等于1的订单，循环放入到命名的数组中
        $datas = Order::where("status", ">=", 1);
        if(\request()->u !==null){
            $datas->where("shop_id",\request()->u);
        }
           $datas=$datas ->get();
        foreach ($datas as $data) {
            $order_id[] = $data->id;
        }


        $goods=  OrderGood::whereIn("order_id", $order_id)
            ->Select(DB::raw("goods_id,goods_name,sum(amount) as nums ,DATE_FORMAT(created_at, '%Y-%m-%d') as da"))
            ->groupBy("da","goods_id")
            ->orderBy("da","desc");
        if(\request()->s !== null){
            $goods->whereDate("created_at", ">=",\request()->s);
        }
        if(\request()->e !== null){
            $goods->whereDate("created_at", "<=",\request()->e);
        }
        $goods =$goods->get();

        $gs=  OrderGood::whereIn("order_id", $order_id)
            ->Select(DB::raw("goods_id as g_id,goods_name as name,sum(amount) as num ,DATE_FORMAT(created_at, '%Y-%m') as month"))
            ->groupBy("month","g_id")
            ->orderBy("month","desc")
            ->get();
        return view("admin.order.index",compact("orders","users","os","us","goods","gs"));

   }














}

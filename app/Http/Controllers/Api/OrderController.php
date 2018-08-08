<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderGood;
use App\Models\Shop;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    /**
     * 添加订单
     * @return array
     */
    public function add()
    {

        $total = 0;
        $data2 = [];
        $data2["goods_id"] = [];
        $data2["amount"] = [];
        $data2["goods_name"] = [];
        $data2["goods_img"] = [];
        $data2["goods_price"] = [];
        $data = [];

        $vip_id = \request()->user_id;
//        dd($vip_id);
        $address_id = \request()->input("address_id");
//        dd(\request()->input("address_id"));
        $address = Address::find($address_id);
        $data["province"] = $address->provence;
        $data["city"] = $address->city;
        $data["county"] = $address->area;
        $data["address"] = $address->detail_address;
        $data["tel"] = $address->tel;
        $data["name"] = $address->name;
        $data["status"] = 0;
        $data["sn"] = date("YmdHis") . rand(1000, 9999);
        $data["vip_id"] = $vip_id;


        $carts = Cart::where("vip_id", $vip_id)->get();
        foreach ($carts as $cart) {
//            从购物车中获取商品的数量和商品的名称，从而求得各商品的价格
            $menu_count = $cart->count;
            $menu_id = $cart->menu_id;
//            通过menu_id 取查找商品的单价
            $price = Menu::find($menu_id)->goods_price;
            $shop_id = Menu::find($menu_id)->shop_id;
//            总价等于 商品的单价*数量 循环相加
            $total += $menu_count * $price;
        }
        $data["shop_id"] = $shop_id;
        $data["total"] = $total;
//        dd($data);
//    return $data;
        DB::beginTransaction();
        try {
            Order::create($data);
            $order_id = DB::getPdo()->lastInsertId();
            $data2["order_id"] = $order_id;
            foreach ($carts as $cart) {
                $data2["goods_id"] = $cart->menu_id;
                $data2["amount"] = $menu_count;
                $data2["goods_name"] = Menu::find($cart->menu_id)->goods_name;
                $data2["goods_img"] = Menu::find($cart->menu_id)->goods_img;
                $data2["goods_price"] = $price;
                OrderGood::create($data2);
            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            return ['status' => 'false', 'message' => $e->getMessage()];
        }
        return [
            "status" => "true",
            "message" => "添加成功",
            "order_id" => $order_id
        ];

    }

    /**
     * 订单详情
     * @return array
     */
    public function detail()
    {

        $data["goods_list"] = [];
        $data = [];
        $id = \request()->id;
        $order = Order::find($id);
        $data["id"] = $id;
        $data["order_code"] = $order->sn;
        $data["order_birth_time"] = date($order->created_at);
//        调用models 里面的getOrderStatusAttribute
        $data["order_status"] = $order->order_status;
        $data["shop_id"] = $order->shop_id;
        $data["shop_name"] = Shop::find($order->shop_id)->shop_name;
        $data["shop_img"] = Shop::find($order->shop_id)->shop_img;

        $data["goods_list"] = OrderGood::where("order_id", $id)->get();

        $data["order_price"] = $order->total;
        $data["order_address"] = $order->province . $order->city . $order->county . $order->address;
        return $data;


    }

    /**
     * 订单列表
     * @return array
     */
    public function list()
    {
        $vip_id = \request()->user_id;
        $data["goods_list"] = [];
        $data = [];
        $datas = [];
//        $id=\request()->id;
        $orders = Order::where("vip_id", $vip_id)->get();
        foreach ($orders as $order) {
            $id = $order->id;
            $data["id"] = $id;
            $data["order_code"] = $order->sn;
            $data["order_birth_time"] = date($order->created_at);
//        调用models 里面的getOrderStatusAttribute
            $data["order_status"] = $order->order_status;
            $data["shop_id"] = $order->shop_id;
            $data["shop_name"] = Shop::find($order->shop_id)->shop_name;
            $data["shop_img"] = Shop::find($order->shop_id)->shop_img;
            $data["goods_list"][] = OrderGood::where("id", $id)->get();
            $data["order_price"] = $order->total;
            $data["order_address"] = $order->province . $order->city . $order->county . $order->address;
            $datas[] = $data;
        }
        return $datas;
    }

}

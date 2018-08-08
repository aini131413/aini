<?php

namespace App\Http\Controllers\Shop;

use App\Models\Order;
use App\Models\OrderGood;
use App\Models\Vip;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    /**
     * 订单列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $orders=Order::where("shop_id",Auth::user()->shop_id)->paginate(7);
        return view("shop.order.index",compact("orders"));
    }

    /**
     * 商品详情
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function goods()
    {
        $order_id=\request()->id;
        $goods=OrderGood::where("order_id",$order_id)->get();

        return view("shop.order.goods",compact("goods"));
    }

    /**
     * 取消订单
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function cancel()
    {
        $id=\request()->id;
        $order=Order::findOrFail($id);
        if($order->status<=0){
            $order->update(["status"=>-1]);
//            \request()->session()->flash("success","已经取消成功");
            return back()->with("success","已经取消成功");
         }else{
            $vip_id=$order->vip_id;
            $total=$order->total;
            $cancel=Vip::findOrFail($vip_id);
            DB::beginTransaction();
            try{
        $cancel->update(["money"=>$cancel->money + $total ]);
        $order->update(["status"=>-1]);
                DB::commit();
            }catch (QueryException $e){

                DB::rollBack();
                return back()->with("danger",$e->getMessage());
            }
            \request()->session()->flash("success","已经取消成功");
            return redirect()->route("order.index");
        }



    }

    /**
     * 发货
     */
    public function send()
    {
        Order::findOrFail(\request()->id)->update(["status"=>2]);
        return back()->with("success","已发货");
    }

    public function stat()
    {
         $shop_id=Auth::user()->shop_id;
         $datas=  Order::where("shop_id",$shop_id)
          ->Select(DB::raw("sum(total) as money,count(*) as count,DATE_FORMAT(created_at, '%Y-%m-%d') as date"))->groupBy("date")
          ->orderBy("date","desc")
          ->limit(30);
        if(\request()->start !== null){
            $datas->whereDate("created_at",">=",\request()->start);
        }
        if(\request()->end !== null){
            $datas->whereDate("created_at","<=",\request()->end);
        }
        $datas=$datas->get();
        $ms=  Order::where("shop_id",$shop_id)
            ->Select(DB::raw("sum(total) as mon,count(*) as jilu,DATE_FORMAT(created_at, '%Y-%m') as month"))->groupBy("month")
            ->orderBy("month","desc")
            ->limit(30)
            ->get();


//      var_dump($data->toArray());exit;
    return view("shop.order.stat",compact("datas","ms"));
    }

}

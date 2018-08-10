<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderGood;
use App\Models\Shop;
use EasyWeChat\Foundation\Application;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
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
                $data2["goods_price"] = Menu::find($cart->menu_id)->goods_price;
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

        $data["goods_list"] = OrderGood::where("order_id", $order->id)->get();

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

    /**
     * 微信支付
     * @throws \Endroid\QrCode\Exception\InvalidPathException
     * @throws \Endroid\QrCode\Exception\InvalidWriterException
     */
    public function wxPay()
    {
        // 创建操作微信的对象 注意命名空间是Easy开头；
        $app = new Application(config("wechat"));
        //得到支付对象
        $payment=$app->payment;
        //得到订单
        $order=Order::find(\request()->id);
        $shop=Shop::where("id",$order->shop_id)->first();
        //生成微信订单配置
        $attributes = [
            'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP...交易类型
            'body'             => $shop->shop_name,//订单抬头
            'detail'           => '点餐详情',//订单内容一般不显示
            'out_trade_no'     => $order->sn,//订单编号
            'total_fee'        => $order->total*100, // 金额单位：分
            'notify_url'       => 'http://www.zhilipeng.com/api/order/ok', // 支付结果 通知返回的网址，如果不设置则会使用配置里的默认地址
            // 'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];
//生成微信订单 注意命名空间是微信的ORder
        $payOrder = new \EasyWeChat\Payment\Order($attributes);
// 统一给微信下单
        $result = $payment->prepare($payOrder);
//dd($result);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
//取出预支付链接
            $payUrl=  $result->code_url;
//把支付链接生成二维码
//        注意命名空间    Endroid\QrCode
            /*$qrCode = new QrCode($payUrl);
            header('Content-Type: '.$qrCode->getContentType());
            echo $qrCode->writeString();*/

            // Create a basic QR code

            $qrCode = new QrCode($payUrl);//地址
            $qrCode->setSize(200);//二维码大小

// Set advanced options

            $qrCode->setWriterByName('png');
            $qrCode->setMargin(10);
            $qrCode->setEncoding('UTF-8');
//           注意命名空间 Endroid\QrCode
            $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH);//容错级别
            $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
            $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);

    //  设置字体         注意命名空间 Endroid\QrCode

            $qrCode->setLabel('微信扫码支付', 16, public_path().'/assets/simli.ttf', LabelAlignment::CENTER);
//            设置图片
        //    dd(public_path().'/assets/ll.png');
$qrCode->setLogoPath(public_path().'/assets/12.jpg');

$qrCode->setLogoWidth(80);//logo大小



// Directly output the QR code
//            设置header头
            header('Content-Type: '.$qrCode->getContentType());
            echo $qrCode->writeString();
            exit;
        }




    }

    /**
     * 微信支付成功后的处理
     */
    public function ok()
    {
        //1.创建操作微信的对象
        $app = new Application(config('wechat'));
        //2.处理微信通知信息
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            //  $order = 查询订单($notify->out_trade_no);
            $order=Order::where("sn",$notify->out_trade_no)->first();

            if (!$order) { // 如果订单不存在
                return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->status!==0) { // 假设订单字段“支付时间”不为空代表已经支付
                return true; // 已经支付成功了就不再更新了
            }
            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                // $order->paid_at = time(); // 更新支付时间为当前时间
                $order->status = 1;//更新订单状态
            }

            $order->save(); // 保存订单

            return true; // 返回处理完成
        });

        return $response;
    }


}

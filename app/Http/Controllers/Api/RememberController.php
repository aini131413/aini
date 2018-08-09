<?php

namespace App\Http\Controllers\Api;

use App\Mail\OrderShipped;
use App\Mail\Shipped;
use App\Models\Order;
use App\Models\User;
use App\Models\Vip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Mrgoon\AliSms\AliSms;

class RememberController extends BaseController
{
    //
    /**
     * 获取手机验证码
     * @param Request $request
     * @return array
     */
    public function sms(Request $request)
    {

        $tel = $request->tel;
        $validator = Validator::make($request->all(), [
            'tel' => [
               "required",
//                "unique:vips",
                "regex:/^[1][3,4,5,7,8][0-9]{9}$/",
            ]
        ]);

        if ($validator->fails()) {
            return ["status" => "false",
                "message" => "手机号码错误"
            ];
        }


        //        生成验证码
        $m = rand(1000, 9999);
//        存验证码并设置过期时间 Redis::setex("tel_".$tel,300,$m);
//        Redis::setex(名字,过期时间秒,验证码);
//        Redis::setex("tel_$tel", 300, $m);
    cache(["tel_$tel"=>$m],5);
        return [
            "status" => "true",
            "message" => "获取短信验证码成功$m"
        ];
        $config = [
            'access_key' => 'LTAI9wKqh1AFaUA9',
            'access_secret' => 'Ksy8pW3RlZtsOwZctnOCt5sk4rBaCp',
            'sign_name' => '彭志立',
        ];
        $aliSms = new AliSms();
        $response = $aliSms->sendSms($tel, 'SMS_140670107', ['code' => $m], $config);
        if ($response->Message === "OK") {
            return [
                "status" => "true",
                "message" => "获取短信验证码成功"
            ];
        } else {
            return [
                "status" => "false",
                "message" => $response->Message
            ];
        }


    }

    /**
     * 注册
     * @param Request $request
     * @return array
     */
    public function regist(Request $request)
    {
//        var_dump($request->all());exit;

        $username = $request->input("username");
        $password = bcrypt($request->input("password"));

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:vips',
            'tel'=>'required|unique:vips'
        ]);
        if ($validator->fails()) {
            return [
                "status" => "false",
                "message" => "用户名或者手机号已被注册"
            ];
        }
        $tel = $request->input("tel");
        $sms = $request->input("sms");

//        dd($sms,cache("tel_".$tel));
        if ($sms != cache("tel_".$tel)) {
            return [
                "status" => "false",
                "message" => "验证码错误"
            ];
        }
//        var_dump($request->all());
        if (Vip::create([
            "username" => $username,
            "password" => $password,
            "tel" => $tel
        ])) {
            return ["status" => "true",
                "message" => "注册成功"];
        } else {
            return [
                "status" => "false",
                "message" => "注册失败"
            ];
        }


    }

    /**
     * 登录
     * @param Request $request
     */
    public function login(Request $request)
    {
        $username = $request->input("name");
        $password = $request->input("password");
        $vip= Vip::where("username",$username)->first();
        if ($vip) {
            if (Hash::check($password, $vip->password)) {
                return [
                    "status"=>"true",
                    "message"=>"登录成功",
                    "user_id"=>$vip->id,
                    "username"=>$username
                ];
            }else{
                return [
                    "status"=>"false",
                    "message"=>"用户名或密码错误"];
            }
        }
        return [
            "status"=>"false",
            "message"=>"用户名或密码错误",

        ];

    }

    /**
     * 忘记密码
     * @return array
     */
    public function forget()
    {
        $tel=\request()->tel;

        $sms=\request()->sms;
        $password=\request()->password;

       $vip= Vip::where("tel",$tel)->first();
//        var_dump($vip);exit;
        if($vip){
            if($sms != cache("tel_$tel")){
                return["status"=>"false","message"=>"验证码错误"];
            }
            if ($vip->update(["password"=>bcrypt($password)])) {
                return["status"=>"true","message"=>"修改密码成功"];
            }
        }else{
            return["status"=>"false","message"=>"手机号不存在"];
        }

    }

    /**
     * 修改密码
     * @return array
     */
    public function edit()
    {
        $oldPassword=\request()->oldPassword;
        $password=\request()->newPassword;
        $id=request()->id;
        $data=Vip::findOrFail($id);

        if (Hash::check($oldPassword,$data->password)) {
            if ($data->update(["password"=>bcrypt($password)])) {
                return[
                    "status"=>"true",
                    "message"=>"修改密码成功"
                ];
            }else{
                return[
                    "status"=>"false",
                    "message"=>"修改密码失败"
                ];
            }

        }else{
            return[
                "status"=>"false",
                "message"=>"原密码错误"
            ];

        }



    }

    /**
     * 用户详情
     * @return Vip|mixed
     */
    public function detail()
    {
        $id=\request()->user_id;
        return Vip::find($id);

    }

    /**
     * 支付
     */
    public function pay()
    {
        $order_id=\request()->id;
        $shop_id=Order::find($order_id)->shop_id;
        $total=Order::find($order_id)->total;
        $vip_id=Order::find($order_id)->vip_id;
        $money=Vip::find($vip_id)->money;
        $tel=Vip::find($vip_id)->tel;
        if($total>$money){
            return[
            "status"=>"false",
            "message"=>"余额不足，请充值"
            ];
        }else{
            $money=$money-$total;

//付款成功 生成订单发送邮件给商家
//            通过订单找到订单信息
            $order =Order::find($order_id);
//            通过shop_id找到商家的信息
            $user=User::where('shop_id',$shop_id)->first();
//            发邮件
            Mail::to($user)->send(new OrderShipped($order));
//            dd($tel);
//            发短信

            $config = [
                'access_key' => 'LTAI9wKqh1AFaUA9',
                'access_secret' => 'Ksy8pW3RlZtsOwZctnOCt5sk4rBaCp',
                'sign_name' => '彭志立',
            ];

            $aliSms = new AliSms();
            $response = $aliSms->sendSms($tel, 'SMS_141582658', ['code'=> $order->sn,'name'=>$order->name], $config);



            Vip::find($vip_id)->update(["money"=>$money]);
            Order::find($order_id)->update(["status"=>1]);

            return[
                "status"=>"true",
                "message"=>"支付成功"
            ];
        }

    }

}

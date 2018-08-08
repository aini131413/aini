<?php

namespace App\Http\Controllers\Admin;

use App\Mail\Shipped;
use App\Models\Order;
use App\Models\Shop;
use App\Models\ShopCategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class ShopController extends BaseController
{

    /**
     * 商铺列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shop()
    {
        $shops=Shop::paginate(3);
        return view("admin.admin.shop",compact("shops"));
    }

    /**
     * 修改商铺状态
     * @param Request $request
     * @param $id
     *
     */
    public function shopStatus(Request $request,$id)
    {
        $shop=Shop::findOrFail($id);
        if ($request->status==="1") {
            if ($shop->update(["status"=>"1"])) {

                $order =Order::where("shop_id",$id)->first();
                $order["message"]="您的信息已通过审核";

                $user=User::where('shop_id',$id)->first();
                //通过审核发送邮件

                Mail::to($user)->send(new Shipped($order));
                $request->session()->flash("success","通过审核");
                return redirect()->route("admin.shop");
            }
        }
        if ($request->status==="-1") {
            if ($shop->update(["status"=>"-1"])) {
                $request->session()->flash("danger","已禁用");
                return redirect()->route("admin.shop");
            }
        }
        if ($request->status==="0") {
            if ($shop->update(["status"=>"0"])) {
                $request->session()->flash("info","等待审核");
                return redirect()->route("admin.shop");
            }
        }

    }

    /**
     * 修改商铺信息
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function shopEdit(Request $request,$id)
    {
        $shop=Shop::findOrFail($id);
        if($request->isMethod("post")){
            $this->validate($request,[
                "shop_name"=>"required",
//                "shop_img"=>"required",
                "start_send"=>"required",
                "send_cost"=>"required",
//                "captcha"=>"captcha"
            ]);
            $data=$request->all();

            if($request->file("shop_img")){
                $data["shop_img"]="/Uploads/images/".$request->file("shop_img")->store("shop_img","images");
            }else{
                unset($data["shop_img"]);
            }
//            var_dump($data);exit;
            if ($shop->update($data)) {
                $request->session()->flash("success","编辑成功");
                return redirect()->route("admin.shop");
            }else{
                $request->session()->flash("warning","编辑失败");
                return redirect()->route("admin.shop");
            }
        }
        $cates=ShopCategory::all();
        return view("admin.admin.shop_edit",compact("cates","shop"));
    }

    /**
     * 删除商铺
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function shopDel(Request $request,$id)
    {

        // dd(Shop::findOrFail($id)->shop_img);

//        var_dump(File::delete(public_path()));exit;
        $shop=Shop::findOrFail($id);


        if (File::delete(public_path($shop->shop_img)) && $shop->delete() ) {
            $request->session()->flash("success","已删除");

        }
        return redirect()->route("admin.shop");
    }
}

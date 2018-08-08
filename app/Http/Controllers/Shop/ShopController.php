<?php

namespace App\Http\Controllers\Shop;

use App\Models\Shop;
use App\Models\ShopCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShopController extends BaseController
{
    //
    /**
     * 商铺列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $shops=Shop::paginate(3);
        return view("shop.shop.index",compact("shops"));
    }

    /**
     * 注册商铺
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if($request->isMethod("post")){
            $this->validate($request,[
                "shop_name"=>"required",
//                "shop_img"=>"required",
                "start_send"=>"required",
                "send_cost"=>"required",
            ]);
            $data=$request->all();
            $data["shop_img"]="";
            if($request->file("shop_img")){
 $data["shop_img"]="/Uploads/images/".$request->file("shop_img")->store("shop_img","images");
            }
            if (Shop::create($data)) {
                $request->session()->flash("success","添加成功");
                return redirect()->route("shop.index");
            }else{
                $request->session()->flash("warning","添加失败");
                return redirect()->route("shop.index");
            }



        }


        $cates=ShopCategory::all();
        return view("shop.shop.add",compact("cates"));
    }

    /**
     * 修改商铺信息
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request,$id)
    {
        $shop=Shop::findOrFail($id);
        if($request->isMethod("post")){
            $this->validate($request,[
                "shop_name"=>"required",
//                "shop_img"=>"required",
                "start_send"=>"required",
                "send_cost"=>"required",
                "captcha"=>"captcha"
            ]);
            $data=$request->all();

            if($request->file("shop_img")){
 $data["shop_img"]="/Uploads/images/".$request->file("shop_img")->store("shop_img","images");
            }else{
                unset($data["shop_img"]);
            }
            if ($shop->update($data)) {
                $request->session()->flash("success","编辑成功");
                return redirect()->route("user.index",$id);
            }else{
                $request->session()->flash("warning","编辑失败");
                return redirect()->route("user.index",$id);
            }



        }


        $cates=ShopCategory::all();

        return view("shop.shop.edit",compact("cates","shop"));
    }

    /**
     * 修改状态
     * @param Request $request
     * @param $id
     *
     */
    public function status(Request $request,$id)
    {
        $shop=Shop::findOrFail($id);
        $status=$request->status;
        if ($request->status==="1") {
            if ($shop->update(["status"=>"1"])) {
                $request->session()->flash("success","通过审核");
                return redirect()->route("shop.index");
            }
        }
        if ($request->status==="-1") {
            if ($shop->update(["status"=>"-1"])) {
                $request->session()->flash("danger","已禁用");
                return redirect()->route("shop.index");
            }
        }
        if ($request->status==="0") {
            if ($shop->update(["status"=>"0"])) {
                $request->session()->flash("info","正常使用");
                return redirect()->route("shop.index");
            }
        }




    }




}

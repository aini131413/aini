<?php

namespace App\Http\Controllers\Admin;

use App\Models\Vip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VipController extends BaseController
{
    /**
     * 会员管理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $vips = Vip::paginate(20);

        return view("admin.vip.index", compact("vips"));


    }

    /**
     * 禁用
     * @return \Illuminate\Http\RedirectResponse
     */
    public function status()
    {
        if (Vip::findOrFail(\request()->id)->status) {
            if (Vip::findOrFail(\request()->id)->update(["status" => 0])) {
                return back()->with("danger", "已禁用");
            }
        }else{
            if (Vip::findOrFail(\request()->id)->update(["status" => 1])) {
                return back()->with("success", "已启用");
            }

        }


    }

    /**
     * 充值
     * @return \Illuminate\Http\RedirectResponse
     */
    public function money()
    {
        $id = \request()->id;
        $vip = Vip::findOrFail($id);
        if (\request()->isMethod("post")) {
            $money = \request()->money;
            if ($vip->update(["money" => $vip->money + $money, "jifen" => $vip->jifen + $money])) {
                return redirect()->route("vip.index")->with("success","已充值成功：$money 元");
            }


        }

        return view("admin.vip.money",compact("vip"));
    }


}

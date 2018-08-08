<?php

namespace App\Http\Controllers\Admin;

use App\Models\MenuCategory;
use App\Models\Shop;
use App\Models\ShopCategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends BaseController
{
    /**
     * 显示商家列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function user()
    {
        $users=User::paginate(3);


        return view("admin.admin.user",compact("users"));

    }

    /**
     * 重置密码
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request,$id)
    {

        if (User::findOrFail($id)->update(["password"=>bcrypt($request->password)])) {
            $request->session()->flash("success","密码重置成功");
            return redirect()->route("admin.user");
        }
    }

    /**
     * 禁用或启用
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function status(Request $request,$id)
    {
        $status=User::findOrFail($id);
        if($status->status==0){
            $status->update(["status"=>1]);
            $request->session()->flash("success","已启用");
            return redirect()->route("admin.user");
        }else{
            $status->update(["status"=>0]);
            $request->session()->flash("success","已禁用");
            return redirect()->route("admin.user");
        }
    }

    /**
     * 编辑用户
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function userEdit(Request $request,$id)
    {
        $row=User::findOrFail($id);
        if($request->isMethod("post")){
            $this->validate($request,[
                'name' => 'required',
                'email' => 'required',
            ]);
            $data=$request->all();
            if ($row->update($data)) {
                $request->session()->flash("success","编辑成功");
                return redirect()->route("admin.user");
            }
        }
        return view("admin.admin.user_edit",compact("row"));
    }

    /**
     * 删除用户
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function userDel(Request $request,$id)
    {
        if (User::findOrFail($id)->delete()) {
            $request->session()->flash("success","删除成功");
            return redirect()->route("admin.user");
        }
    }

    /**
     * 添加用户
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function userAdd(Request $request)
    {
        if($request->isMethod("post")){
//            var_dump($request->all());exit;
            $this->validate($request,[
                'name' => 'required',
                'password' => 'required',
                'email' => 'required',
//                'captcha' => 'captcha',
                "shop_name"=>"required",
//                "shop_img"=>"required",
                "start_send"=>"required",
                "send_cost"=>"required",
            ]);
            DB::transaction(function() use ($request){
                $data=$request->all();
                $data["shop_img"]="";
                if($request->file("shop_img")){
                    $data["shop_img"]="/uploads/images/".$request->file("shop_img")->store("shop_img","images");
                }else{
                    unset($data["shop_img"]);
                }
//                var_dump($request->file("shop_img"));exit;
                $data["password"]=bcrypt($data["password"]);
                $shop=Shop::create($data);


                $data["shop_id"]=$shop->id;
                User::create($data);

            }
            );
            return redirect()->route("admin.user")->with("success","注册成功");

        }

        $cates=ShopCategory::all();
        return view("admin.admin.user_add",compact("cates"));
    }
}

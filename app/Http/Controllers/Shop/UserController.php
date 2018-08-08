<?php

namespace App\Http\Controllers\Shop;

use App\Models\Active;
use App\Models\Event;
use App\Models\EventPrize;
use App\Models\EventUser;
use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\Shop;
use App\Models\ShopCategory;
use App\Models\User;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{


    /**
     * 商家信息表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $time = date(now());
        $actives = Active::where("end_time", ">", $time)->get();
        $shop = Auth::user()->shop;
        $m = Menu::where("shop_id", Auth::user()->shop_id);
        $c = MenuCategory::where("shop_id", Auth::user()->shop_id);
        $user = Auth::user();
        $events=Event::all();

        $cate = $request->get("cate");
        $menu = $request->get("menu");
        $min_price = $request->get("min_price");
        $max_price = $request->get("max_price");

        if ($cate !== null) {
            $c->where("id", $cate);
            $m->where("category_id", $cate);
        }
        if ($menu !== null) {
            $m->where("goods_name", "like", "%{$menu}%");
        }
        if ($min_price !== null) {
            $m->where("goods_price", ">=", $min_price);
        }
        if ($max_price !== null) {
            $m->where("goods_price", "<=", $max_price);
        }


//        }

        $cates = $c->get();
        $menus = $m->get();

        return view("shop.user.index", compact("shop", "user", "cates", "menus", "actives","events"));
    }

    /**
     * 添加用户
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * /*     */
//    public function add(Request $request)
//    {
//
//        if($request->isMethod("post")){
////            var_dump($request->all());exit;
//            $this->validate($request,[
//                'name' => 'required',
//                'password' => 'required',
//                'email' => 'required',
//                'captcha' => 'captcha',
//            ]);
//            $data=$request->all();
//            $data["password"]=bcrypt($data["password"]);
//            if (User::create($data)) {
//                $request->session()->flash("success","添加成功");
//                return redirect()->route("user.index");
//            }
//        }
//            $cates=ShopCategory::all();
//        return view("shop.user.add",compact("cates"));
//    }*/

    /**
     * 编辑用户
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $row = User::findOrFail($id);
        if ($request->isMethod("post")) {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required',
            ]);

            $data = $request->all();
            if ($data["old_password"] !== null && $data["password"] !== null) {
//           var_dump($data);exit;
                if (Hash::check($data["old_password"], $row->password)) {
                    $data["password"] = bcrypt($data["password"]);
                    unset($data["old_password"]);
                    if ($row->update($data)) {
                        $request->session()->flash("success", "编辑成功");
                        return redirect()->route("user.index", $id);
                    }
                } else {
                    return redirect()->back()->with("danger", "原密码不正确");
                }

            } else {
                unset($data["old_password"]);
                unset($data["password"]);
                if ($row->update($data)) {
                    $request->session()->flash("success", "编辑成功");
                    return redirect()->route("user.index", $id);
                }
            }
        }
        return view("shop.user.edit", compact("row"));
    }

    /**
     * 删除用户
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function del(Request $request, $id)
    {

        if (User::findOrFail($id)->delete()) {
            $request->session()->flash("success", "删除成功");
            return redirect()->route("user.index");
        }
    }

    /**
     * 禁用或启用
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function status(Request $request, $id)
    {
        $status = User::findOrFail($id);
//        dd($status);
        if ($status->status == 0) {
            $status->update(["status" => 1]);
            $request->session()->flash("success", "已启用");
            return redirect()->route("user.index");
        } else {
            $status->update(["status" => 0]);
            $request->session()->flash("success", "已禁用");
            return redirect()->route("user.index");
        }


    }

    /**
     * 商家注册
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add2(Request $request)
    {

        if ($request->isMethod("post")) {
//            var_dump($request->all());exit;
            $this->validate($request, [
                'name' => 'required',
                'password' => 'required',
                'email' => 'required',
                'captcha' => 'captcha',
                "shop_name" => "required",
//                "shop_img"=>"required",
                "start_send" => "required",
                "send_cost" => "required",
            ]);
            DB::transaction(function () use ($request) {
                $data = $request->all();
//                $data["shop_img"]="";
                if ($request->file("shop_img")) {
                    $data["shop_img"] = "/uploads/images/" . $request->file("shop_img")->store("shop_img", "images");
                }
//                var_dump($request->file("shop_img"));exit;
                $data["password"] = bcrypt($data["password"]);
                $shop = Shop::create($data);


                $data["shop_id"] = $shop->id;
                User::create($data);

            }
            );
            session()->flash("success", "注册成功");
            return redirect()->route("user.login");

        }
        $cates = ShopCategory::all();
        return view("shop.user.add2", compact("cates"));
    }

    /**
     * 商家登录
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function login(Request $request)
    {
        if ($request->isMethod("post")) {
            $this->validate($request, [
                "name" => "required",
                "password" => "required",
                "captcha" => "captcha"
            ]);
            if (Auth::attempt([
                "name" => $request->name,
                "password" => $request->password
            ])) {
//                var_dump(Auth::user()->status);exit;
                if (Auth::user()->status === 0) {
                    Auth::logout();
                    return redirect()->back()->with("warning", "对不起你的账号正在审核中，暂时无法为您提供服务");
                }
                $request->session()->flash("success", "登录成功");
                return redirect()->route("user.index");
            } else {
                $request->session()->flash("danger", "用户名或密码错误，请重新输入");
                return redirect()->back()->withInput();


            }


        }


        return view("shop.user.login");
    }

    /**
     * 显示商家列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
//    public function list()
//    {
//        $users=User::paginate(3);
//
//        return view("shop.user.list",compact("users"));
//
//    }

    /**
     * 重置密码
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
//    public function reset(Request $request,$id)
//    {
//
//        if (User::findOrFail($id)->update(["password"=>bcrypt($request->password)])) {
//            $request->session()->flash("success","密码重置成功");
//            return redirect()->route("user.list");
//        }
//    }


    public function logout()
    {
        Auth::logout();
        return back()->with("success", "您已退出登陆");
    }


    /**
     * 商家报名
     * @param Request $request
     * @param $uid
     * @param $eid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function join(Request $request,$uid, $eid)
    {
//        dd(EventUser::where("event_id",$eid)->count());
        if (EventUser::where("event_id", $eid)->count() < Event::findOrFail($eid)->num) {
            if (EventUser::create(["user_id" => $uid, "event_id" => $eid])) {
                $request->session()->flash("success", "已报名");
                return back();
            }
        } else {
//            dd(111);
            $request->session()->flash("success", "报名人数已满，请关注下一次抽奖活动");

            return redirect()->route("user.index",compact(
                $uid));

        }


    }


    public function win()
    {
        $eps=EventPrize::where("event_id",\request()->id)->get();

        return view("shop.user.win",compact("eps"));
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mrgoon\AliSms\AliSms;
use Spatie\Permission\Models\Role;

class AdminController extends BaseController
{


    /**
     * 显示管理员列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $admins = Admin::paginate(3);
        $roles=Role::all();
        return view("admin.admin.index", compact("admins"));
    }

    /**
     * 添加管理员
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->isMethod("post")) {

//            var_dump($request->file);exit;
            $this->validate($request, [
                'name' => 'required',
                'password' => 'required',
                'email' => 'required|unique:admins',
//                'captcha' => 'captcha',
            'role'=>'required'
            ]);

            $data["password"]=bcrypt($request->password);
            $data["name"]=$request->name;
            $data["email"]=$request->email;
            $admin=Admin::create($data);

//            同步角色syncRoles
            $role=$admin->syncRoles($request->role);
            if ($admin && $role) {
                $request->session()->flash("success", "添加成功");
                return redirect()->route("admin.index");
            }


        }
        $roles= Role::all();
        return view("admin.admin.add",compact("roles"));
    }

    /**
     * 管理员登录
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

            if (Auth::guard("admin")->attempt(["name" => $request->name, "password" =>$request->password])) {
                    $request->session()->flash("success","登录成功");
                    return redirect()->intended(route("orders.index"));
            }else{
                $request->session()->flash("warning","账号或密码错误");
                return redirect()->back()->withInput();


            }
        }

        return view("admin.admin.login");

    }

    /**
     * 注销
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::guard("admin")->logout();
        return redirect()->route("admin.index");

    }

    /**
     * 修改管理员
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request,$id)
    {
        $admin=Admin::findOrFail($id);
        if ($request->isMethod("post")) {
            $this->validate($request, [
                'name' => 'required',
                'password' => 'required',
                'email' => 'required',
                'captcha' => 'captcha',
            ]);
            $data=$request->all();
            $data["password"]=bcrypt($data["password"]);
            $update=$admin->update($data);
            $role=$admin->syncRoles($request->role);
            if ($update && $role) {
                $request->session()->flash("success", "修改成功");
                return redirect()->route("admin.index");
            }
        }
        $roles=Role::all();
        return view("admin.admin.edit",compact("admin","roles"));
    }

    /**
     * 删除管理员
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function del(Request $request,$id)
    {
        if(Admin::findOrFail($id)->delete()){
            $request->session()->flash("success","已删除");
            return redirect()->route("admin.index");
        }
    }






}

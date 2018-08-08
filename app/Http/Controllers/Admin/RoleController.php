<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends BaseController
{


    public function add()
    {

        if (\request()->isMethod("post")) {
            //        接收参数
            $data["name"]=\request()->name;
//        给接收的数据中添加 guard_name = admin
            $data["guard_name"]="admin";
            //添加一个权限   权限名称必需是路由的名称  后面做权限判
            $role=Role::create($data);
//            将多个权限同步到同一角色
            $per=$role->syncPermissions(\request()->per);
            if($role && $per){
                return back()->with("success","添加成功");
            }
        }
        $pers=Permission::all();
        return view("admin.role.add",compact("pers"));
    }


    public function index()
    {

        $roles=Role::all();
        return view("admin.role.index",compact("roles"));
    }


    public function del()
    {
        $id=\request()->id;

        if (Role::findOrFail($id)->delete()) {
            return back()->with("success","删除成功");
        }

    }

    public function edit()
    {
        $role=Role::findOrFail(\request()->id);
        if (\request()->isMethod("post")) {
            //        接收参数
            $data["name"]=\request()->name;

            //添加一个权限   权限名称必需是路由的名称  后面做权限判
            $role->update($data);
//            将多个权限同步到同一角色
            $role->syncPermissions(\request()->per);

                return redirect()->route("role.index")->with("success","编辑成功");

        }

        $pers=Permission::all();

        return view("admin.role.edit",compact("pers","role"));
    }

}

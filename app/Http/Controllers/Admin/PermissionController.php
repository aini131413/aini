<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class PermissionController extends BaseController
{
    public function add()
    {
        $arr=[];
        if (\request()->isMethod("post")) {
            //        接收参数
            $datas=\request()->name;

            foreach ($datas as $data){
//        给接收的数据中添加 guard_name = admin
            $arr["guard_name"]="admin";
            $arr["name"]= $data;
            $per=Permission::create($arr);
        }


            if($per){
                return back()->with("success","添加成功");
            }
        }



        //获取所有的路径
        $routes = Route::getRoutes();
        $urls = [];
        foreach ($routes as $k => $route) {
            set_time_limit(0);
            if (isset($route->action["namespace"]) && $route->action["namespace"] == "App\Http\Controllers\Admin") {
//                dump($route->action);
                $urls[] = $route->action["as"];
            }
        }
//        Nav::create()
        $u=Permission::pluck("name")->toArray();
//        dump($u);
        $us=array_diff($urls,$u);
        return view("admin.per.add",compact("us") );
    }

    public function index()
    {

        $pers=Permission::all();
        return view("admin.per.index",compact("pers"));
    }

    public function del()
    {
        $id=\request()->id;

        if (Permission::findOrFail($id)->delete()) {
            return back()->with("success","删除成功");
        }

    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Nav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class NavController extends Controller
{

    public function index()
    {
        $navs=Nav::all();
        return view("admin.nav.index",compact("navs"));
    }

    public function add()
    {
        if (\request()->isMethod("post")) {
            $data=\request()->all();
            if (Nav::create($data)) {
                return back()->with("success","添加成功");
            }
        }
        //获取所有的路径
        $routes = Route::getRoutes();
        $urls = [];
        foreach ($routes as $k => $route) {
            set_time_limit(0);
//            dump($route);
            if (isset($route->action["namespace"]) && $route->action["namespace"] == "App\Http\Controllers\Admin") {
            $urls[] = $route->action["as"];
            }
        }

        $navs=Nav::where("pid",0)->orderBy("sort","desc")->get();
        return view("admin.nav.add",compact("urls","navs"));
    }

    public function edit()
    {
        $id=\request()->id;
        $n=Nav::findOrFail($id);
        $navs=Nav::all();
        $routes = Route::getRoutes();
        $urls = [];
        foreach ($routes as $k => $route) {
            set_time_limit(0);
//            dump($route);
            if (isset($route->action["namespace"]) && $route->action["namespace"] == "App\Http\Controllers\Admin") {
                $urls[] = $route->action["as"];
            }
        }
        if (\request()->isMethod("post")) {
            if ($n->update(\request()->all())) {

                return redirect()->route("nav.index")->with("success","编辑成功");
            }


        }





        return view("admin.nav.edit",compact("n","navs","urls"));
    }

    public function del()
    {
        $nav=Nav::findOrFail(\request()->id);

        if (Nav::where("pid",$nav->id)->first()) {
            return back()->with("danger","该项目下还有子项目存在，不能删除");
        }

        if (Nav::findOrFail(\request()->id)->delete()) {
            return back()->with("success","已删除");
        }
    }

}

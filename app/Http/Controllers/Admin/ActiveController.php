<?php

namespace App\Http\Controllers\Admin;

use Alpha\A;
use App\Models\Active;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class ActiveController extends BaseController
{
    /**
     * 活动列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $get = $request->query();
        $a=Active::orderBy("id");
                    $time=date(now());

            if($request->search=="start"){
               $a->where("start_time",">",$time);
            }
            if($request->search=="doing"){
                $a->where("start_time","<",$time)
                         ->where("end_time",">",$time);
            }
            if($request->search=="end"){
                $a ->where("end_time","<",$time);
            }




        $actives=$a->paginate(3);
        return view("admin.active.index",compact("actives","get"));
    }

    /**
     * 添加活动
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if($request->isMethod("post")){
            $this->validate($request,[
               "title"=>"required",
               "content"=>"required" ,
                "start_time"=>"required",
                "end_time"=>"required",
            ]);
            if($request->end_time < $request->start_time){

                return back()->with("danger","结束时间必须大于开始时间");
            }
            if (Active::create($request->all())) {

                $request->session()->flash("success","添加成功");
                return redirect()->route("active.index");
            }
        }
        return view("admin.active.add");
    }

    /**
     * 编辑活动
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request,$id)
    {
        $active= Active::findOrFail($id);

        if ($request->isMethod("post")) {
            $this->validate($request,[
                "title"=>"required",
                "content"=>"required" ,
                "start_time"=>"required",
                "end_time"=>"required",
            ]);
            if($request->end_time < $request->start_time){

                return back()->with("danger","结束时间必须大于开始时间");
            }
            if ($active->update($request->all())) {
                $request->session()->flash("success","编辑成功");
                return redirect()->route("active.index");
            }
        }
        return view("admin.active.edit",compact("active"));
     }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function del($id)
    {

        if (Active::findOrFail($id)->delete()) {

            return back()->with("success","删除成功");
        }

     }
}

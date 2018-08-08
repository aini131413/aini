<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\EventPrize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventPrizeController extends BaseController
{
    public function index()
    {
        $eps=EventPrize::paginate(10);

        return view("admin.ep.index",compact("eps"));
    }

    public function add()
    {
        $events=Event::all();
        if (\request()->isMethod("post")) {
            if (EventPrize::create(\request()->all())) {
                return back()->withInput()->with("success","添加成功");
            }
        }
        return view("admin.ep.add",compact("events"));
    }

    public function edit()
    {
        $events=Event::all();
        $prize=EventPrize::findOrFail(\request()->id);
        if (\request()->isMethod("post")) {
            if ($prize->update(\request()->all())) {
                return redirect()->route("prize.index")->with("success","编辑成功");
            }
        }
        return view("admin.ep.edit",compact("events","prize"));
    }

    public function del()
    {
        if (EventPrize::findOrFail(\request()->id)->delete()) {
            return back()->with("success","已删除");
        }
    }

}

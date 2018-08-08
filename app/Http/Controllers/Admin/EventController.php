<?php

namespace App\Http\Controllers\Admin;

use App\Mail\Shipped;
use App\Models\Event;
use App\Models\EventPrize;
use App\Models\EventUser;
use App\Models\Order;
use App\Models\User;
use function foo\func;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EventController extends BaseController
{

    public function add()
    {
        if (\request()->isMethod("post")) {
            $this->validate(\request(), [
                "title" => "required",
                "start_time" => "required",
                "end_time" => "required",
                "prize_time" => "required",
                "num" => "required",
                "is_prize" => "required",
                "content" => "required"
            ]);
            $data = \request()->all();
            if (Event::create($data)) {
                return redirect()->route("event.index")->with("success", "添加成功");
            }


        }


        return view("admin.event.add");
    }

    public function index()
    {
        $events = Event::all();
        return view("admin.event.index", compact("events"));
    }

    public function edit()
    {
        $id = \request()->id;
        $event = Event::findOrFail($id);

        if (\request()->isMethod("post")) {
            $this->validate(\request(), [
                "title" => "required",
                "start_time" => "required",
                "end_time" => "required",
                "prize_time" => "required",
                "num" => "required",
                "is_prize" => "required",
                "content" => "required"
            ]);
            if ($event->update(\request()->all())) {
                return redirect()->route("event.index")->with("success", "已编辑");
            }
        }
        return view("admin.event.edit", compact("event"));
    }

    public function del()
    {
        $id = \request()->id;
        if (Event::findOrFail($id)->delete()) {
            return back()->with("success", "已删除");
        }
    }

    /**
     * 抽奖
     */
    public function draw()
    {

//        $data=[];
//        $data["message"]="";
//        $data=json_encode($data);
        $event_id = \request()->id;

        $prize = EventPrize::where("event_id", $event_id)->pluck("id")->toArray();

        $count = EventPrize::where("event_id", $event_id)->count();
//        打乱奖品顺序
        if($count===0){
            return back()->with("danger","奖品都没有，抽什么奖");
        }
        shuffle($prize);
//        dump($prize);
        $users = EventUser::where("event_id", $event_id)->pluck("user_id")->toArray();
        //打乱报名者的顺序
        shuffle($users);
        //        截取根据奖品的数量 选出名中奖人员名单和数量
        $user = array_slice($users, -$count);
        $uc= EventUser::where("event_id", $event_id)->count();
//        如果报名人数小于奖品数时，按报名人数截取奖品的数量
        if($uc<$count){
            $prize=array_slice($prize, -$uc);
        }
//        如果没有人报名时不能抽奖
        if($uc===0){
            return back()->with("danger","都没人报名，抽什么奖");
        }
//      把奖品与中奖人员进行匹配
        $arr = array_combine($user, $prize);
//       匹配完成后分别写入数据库中 1、修改抽奖活动的状态为1；2、修改活动奖品表的获奖用户ID；3给中奖用户发送邮件
        DB::beginTransaction();
        try {
            Event::findOrFail($event_id)->update(["is_prize" => 1]);
            foreach ($arr as $uid => $pid) {
                EventPrize::findOrFail($pid)->update(["user_id" => $uid]);
//              发送邮件
//              $data =Order::find(1);
                $u = User::findOrFail($uid);
//             循环发送邮件
                $p = EventPrize::findOrFail($pid);
                $u["message"] = "恭喜你$u->name 中奖，奖品为：$p->name 请保持电话畅通，我司后续会有工作人员与您联系~";


                Mail::to($u)->send(new Shipped($u));


            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            return back()->with("danger", $e->getMessage());
        }
        return redirect()->route("prize.index")->with("success", "已完成抽奖");


    }

}

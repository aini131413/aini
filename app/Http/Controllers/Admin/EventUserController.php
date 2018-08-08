<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\EventUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventUserController extends BaseController
{


    /**
     * 报名管理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
       $eus= EventUser::paginate(30);
      return view("admin.eu.index",compact("eus"));





    }


}

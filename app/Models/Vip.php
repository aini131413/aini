<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Vip extends Model
{
    //
    public $fillable=[
      "username",
      "password",
      "tel",
      "remember_token",
        "money",
        "jifen",
        "status"
    ];


    public function getVipStatusAttribute()
    {
        $arr=[0=>"已禁用",1=>"正常"];

        return $arr[$this->status];

    }
}

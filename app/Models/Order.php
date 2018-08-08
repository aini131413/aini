<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $fillable=[
            "vip_id",
            "shop_id",
            "sn",
            "province",
            "city",
            "county",
            "address",
            "tel",
            "name",
            "total",
            "status",
            "out_trade_no",
    ];

    public function getOrderStatusAttribute()
    {
        $arr=[0=>"代付款",-1=>"已取消",1=>"待发货",2=>"待确认",3=>"完成"];
        return $arr[$this->status];
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class,"shop_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class,"shop_id");
    }
}

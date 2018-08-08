<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $fillable=[
        "vip_id",
        "name",
        "tel",
        "provence",
        "city",
        "area",
        "detail_address"
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $fillable=[

        "vip_id",
        "menu_id",
        "count"

    ];
}

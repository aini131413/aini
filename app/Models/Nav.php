<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    public $fillable=[
        "name",
        "url",
        "pid",
        "sort"
    ];
}

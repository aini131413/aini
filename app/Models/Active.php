<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Active extends Model
{
    public $fillable = [
        "title",
        "content",
        "start_time",
        "end_time"
    ];

}

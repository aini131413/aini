<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
   public $fillable=[
  "title" ,
  "start_time",
  "end_time",
  "prize_time",
  "num" ,
  "is_prize" ,
  "content"
   ];


}

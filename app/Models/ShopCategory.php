<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ShopCategory
 *
 * @mixin \Eloquent
 */
class ShopCategory extends Model
{
    //
public $fillable=["name","img","status"];
public $timestamps=false;
}

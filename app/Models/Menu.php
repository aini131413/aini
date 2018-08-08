<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
public $fillable=[
                  "goods_name",
                "rating",
                "shop_id",
                "category_id",
                "goods_price",
                "description",
                "month_sales",
                "rating_count",
                "tips",
                "satisfy_count",
                "satisfy_rate",
                "goods_img",
"status"



];

    public function cate()
    {
         return $this->belongsTo(MenuCategory::class,"menu_category");

    }
    public function shop()
    {

        return $this->belongsTo(ShopCategory::class,"shop_id");

    }
}

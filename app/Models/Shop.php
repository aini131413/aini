<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Shop extends Model
{
    public $fillable=[
        "shop_category_id",
        "shop_name",
        "shop_img",
        "shop_rating",
        "brand",
        "on_time",
        "fengniao",
        "bao",
        "piao",
        "zhun",
        "start_send",
        "send_cost",
        "notice",
        "discount",
        "status"

    ];
    public function category()
    {
        return $this->belongsTo(ShopCategory::class,"shop_category_id");
    }
    use Searchable;
    public $asYouType = true;
    /**
     * 全文搜索
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->only("id","shop_name");
        // Customize array...
        return $array;
    }


}

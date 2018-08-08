<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("vip_id");
            $table->integer("shop_id");
            $table->string("sn");
            $table->string("province")->comment("省");
            $table->string("city")->comment("市");
            $table->string("county")->comment("区/县");
            $table->string("address")->comment("详细地址");
            $table->string("tel")->comment("收货电话");
            $table->string("name")->comment("收货人");
            $table->string("out_trade_no")->comment("第三方交易号");
            $table->decimal("total")->comment("价格");
            $table->integer("status")->comment("状态(-1:已取消,0:待支付,1:待发货,2:待确认,3:完成)");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

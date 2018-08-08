<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("vip_id");
            $table->string("name")->comment("收货人姓名");
            $table->string("tel")->comment("联系电话");
            $table->string("provence")->comment("省");
            $table->string("city")->comment("市");
            $table->string("area")->comment("区/县");
            $table->string("detail_address")->comment("详细地址");
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
        Schema::dropIfExists('addresses');
    }
}

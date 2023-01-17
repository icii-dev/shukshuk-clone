<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_shippings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id', 30);
            $table->string('shipping_referrer_id', 100)->nullable();
//            $table->string('shipping_option', 20)->nullable();
//            $table->string('shipper_name');
//            $table->string('shipper_phone');
//            $table->string('shipper_district_id');
//            $table->string('shipper_address');
            $table->integer('cost')->nullable();
            $table->dateTime('expect_start')->nullable();
            $table->dateTime('expect_finish')->nullable();
            $table->smallInteger('retry_count')->nullable()->default(0);
            $table->string('status', 30)->nullable();
            $table->timestamps();

            $table->index('order_id');
            $table->index('shipping_referrer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_shippings');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderShippingHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_shipping_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_shipping_id');
            $table->string('order_id', 30);
            $table->text('message')->nullable();
            $table->string('tracking_code', 20)->nullable();
            $table->dateTime('action_at')->nullable();
            $table->timestamps();

            $table->index('order_shipping_id');
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_shipping_histories');
    }
}

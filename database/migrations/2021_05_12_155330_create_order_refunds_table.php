<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_refunds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id', 30);
            $table->foreign('order_id')->references('id')->on('orders');
            $table->integer('admin_id')->unsigned()->nullable()->default(null);
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');;
            $table->integer('billing_tax');
            $table->integer('billing_refund');
            $table->tinyInteger('action')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('order_refunds');
    }
}

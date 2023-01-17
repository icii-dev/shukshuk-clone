<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorePaymentMethodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_payment_method', function (Blueprint $table) {
            $table->integer('store_id')->unsigned();
            $table->integer('payment_method_id')->unsigned();

            $table->primary(['store_id', 'payment_method_id']);

            /* Foreign key */
            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_payment_method');
    }
}

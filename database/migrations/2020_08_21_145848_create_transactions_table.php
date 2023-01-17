<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('store_id')->unsigned();
            $table->bigInteger('amount');
            $table->string('type',100);
            $table->tinyInteger('status');
            $table->string('description')->nullable();
            $table->timestamps();

            //
            $table->foreign('store_id')->references('store_id')->on('store_balances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
        });
        Schema::dropIfExists('transactions');
    }
}

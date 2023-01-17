<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('delivery_unit_id')->unsigned()->nullable();

            /* Store info */
            $table->string('name', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->integer('industry_id')->unsigned()->nullable();
            $table->text('description')->nullable();
            $table->string('proof_image', 1000)->nullable();

            /* Seller info */
            $table->integer('user_id')->unsigned();
            $table->string('seller_first_name', 255)->nullable();
            $table->string('seller_last_name', 255)->nullable();
            $table->integer('seller_nationality_id')->nullable();
            $table->integer('seller_residence_id')->nullable();
            $table->string('seller_id_number', 100)->nullable();
            $table->string('seller_proof_image', 100)->nullable();

            /* Store address */
            $table->string('address', 500)->nullable();
            $table->float('lat')->nullable();
            $table->float('lng')->nullable();

            /* Store status */
            $table->tinyInteger('status')->nullable()->default(0);

            $table->timestamps();

            /* Foreign key */
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('delivery_unit_id')->references('id')->on('delivery_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}

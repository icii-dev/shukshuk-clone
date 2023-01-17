<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->unsigned();
            $table->text('description')->nullable();
            $table->text('options')->nullable();
            $table->bigInteger('option_1')->unsigned()->nullable();
            $table->bigInteger('option_2')->unsigned()->nullable();
            $table->integer('price')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('image')->nullable();
            $table->text('images')->nullable();
            $table->integer('discount_value')->nullable();
            $table->string('discount_type', 50)->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->text('first_name', 255)->nullable();
            $table->text('last_name', 255)->nullable();
            $table->text('email', 255)->nullable();
            $table->date('dob')->nullable();
            $table->text('phone', 20)->nullable();
            $table->integer('nationality_id')->nullable();
            $table->integer('residence_id')->nullable();
            $table->text('id_number', 100)->nullable();
            $table->text('proof_image', 100)->nullable();

            $table->smallInteger('status')->nullable();

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
        Schema::dropIfExists('sellers');
    }
}

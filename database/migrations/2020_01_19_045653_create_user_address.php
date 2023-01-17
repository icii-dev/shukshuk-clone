<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_provinces_indo', function (Blueprint $table) {
            $table->char('id', 2)->primary();
            $table->string('name', 255);
        });

        Schema::create('address_regencies_indo', function (Blueprint $table) {
            $table->char('id', 4)->primary();
            $table->char('province_id', 2);
            $table->string('name', 255);
        });

        Schema::create('address_districts_indo', function (Blueprint $table) {
            $table->char('id', 7)->primary();
            $table->char('regency_id', 4);
            $table->string('name', 255);
        });

        Schema::create('user_address', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->char('province_id',2)->nullable();
            $table->char('regency_id',4)->nullable();
            $table->char('district_id',7)->nullable();
            $table->string('recipient_name', 100)->nullable();
            $table->text('addresses')->nullable();
            $table->string('phone', 50)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->timestamps();

            /* Foreign key */
//            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
//            $table->foreign('province_id')->references('id')->on('address_provinces_indo');
//            $table->foreign('regency_id')->references('id')->on('address_regencies_indo');
//            $table->foreign('district_id')->references('id')->on('address_districts_indo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_address');
        Schema::dropIfExists('address_districts_indo');
        Schema::dropIfExists('address_provinces_indo');
        Schema::dropIfExists('address_regencies_indo');
    }
}

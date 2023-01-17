<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dcs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_id', 10);
            $table->string('name', 50)->unique();
            $table->tinyInteger('status');
            $table->string('phone', 15);
            $table->tinyInteger('type')->nullable();
            $table->time('time_open')->nullable();
            $table->time('time_closed')->nullable();
            $table->char('province_id',2);
            $table->char('regency_id', 4);
            $table->char('district_id', 7);
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
        Schema::dropIfExists('dcs');
    }
}

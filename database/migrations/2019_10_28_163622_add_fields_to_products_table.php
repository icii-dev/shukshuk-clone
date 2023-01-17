<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku', 64)->nullable();
            $table->integer('discount')->nullable()->default(0);
            $table->tinyInteger('discount_type')->nullable()->default(1);
            $table->tinyInteger('status')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('sku');
            $table->dropColumn('discount');
            $table->dropColumn('discount_type');
            $table->dropColumn('status');
        });
    }
}

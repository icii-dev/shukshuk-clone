<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToOrderShippingsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_shippings', function (Blueprint $table) {
            $table->string('shipper_name')->nullable()->after('expect_finish');
            $table->string('shipper_phone')->nullable()->after('shipper_name');
            $table->string('shipper_district')->nullable()->after('shipper_phone');
            $table->string('shipper_district_id')->nullable()->after('shipper_district');
            $table->string('shipper_address')->nullable()->after('shipper_district_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_shippings', function (Blueprint $table) {
            $table->dropColumn('shipper_name');
            $table->dropColumn('shipper_phone');
            $table->dropColumn('shipper_district');
            $table->dropColumn('shipper_district_id');
            $table->dropColumn('shipper_address');
        });
    }
}

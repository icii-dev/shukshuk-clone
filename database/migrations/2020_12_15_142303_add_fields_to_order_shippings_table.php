<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToOrderShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_shippings', function (Blueprint $table) {
            if(!Schema::hasColumn('order_shippings','shipping_option')){
                $table->string('shipping_option', 20)->nullable()->after('order_id');
            }
            if(!Schema::hasColumn('order_shippings','shipper_name')){
                $table->string('shipper_name')->nullable()->after('shipping_option');
            }
            if(!Schema::hasColumn('order_shippings','shipper_phone')){
                $table->string('shipper_phone')->nullable()->after('shipping_option');
            }
            if(!Schema::hasColumn('order_shippings','shipper_district')){
                $table->string('shipper_district')->nullable()->after('shipping_option');
            }
            if(!Schema::hasColumn('order_shippings','shipper_district_id')){
                $table->string('shipper_district_id')->nullable()->after('shipping_option');
            }
            if(!Schema::hasColumn('order_shippings','shipper_address')){
                $table->string('shipper_address')->nullable()->after('shipping_option');
            }
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
            $table->dropColumn('shipping_option');
            $table->dropColumn('shipper_name');
            $table->dropColumn('shipper_phone');
            $table->dropColumn('shipper_district_id');
            $table->dropColumn('shipper_address');
        });
    }
}

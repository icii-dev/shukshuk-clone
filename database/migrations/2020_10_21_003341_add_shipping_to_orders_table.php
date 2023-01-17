<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShippingToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('billing_shipping_fee')->nullable()->default(0)->after('billing_discount_code');
            $table->integer('billing_insurance_fee')->nullable()->default(0)->after('billing_shipping_fee');

            $table->string('shipping_option', 100)->nullable()->default(0)->after('billing_total');
            $table->integer('total_weight')->nullable()->comment('Gram')->after('shipping_option');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('billing_shipping_fee');
            $table->dropColumn('billing_insurance_fee');
            $table->dropColumn('shipping_option');
            $table->dropColumn('total_weight');
        });
    }
}

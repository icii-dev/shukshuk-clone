<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStoreIdToBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->integer('store_id')->unsigned()->default(1)->after('account_number');
            $table->foreign('store_id')->references('id')->on('stores');
        });

        if(Schema::hasTable('store_bank')){
            $storeBanks = DB::table('store_bank')->get();
            foreach ($storeBanks as $storeBank){
                $bank = \App\Model\Bank::where('id', $storeBank->bank_id)->first();
                if($bank){
                    $bank->store_id=$storeBank->store_id;
                    $bank->save();
                }
            }
            Schema::dropIfExists('store_bank');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->dropForeign('banks_store_id_foreign');
            $table->dropColumn('store_id');
        });
    }
}

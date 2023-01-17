<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvatarCoverToStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->text('cover_image', 100)->nullable();
            $table->text('avatar_image', 100)->nullable();
            $table->integer('seller_id')->unsigned();

            $table->dropColumn('seller_first_name');
            $table->dropColumn('seller_last_name');
            $table->dropColumn('seller_nationality_id');
            $table->dropColumn('seller_residence_id');
            $table->dropColumn('seller_id_number');
            $table->dropColumn('seller_proof_image');
            $table->dropColumn('proof_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('cover_image');
            $table->dropColumn('avatar_image');
            $table->dropColumn('seller_id');

            $table->string('seller_first_name', 255)->nullable();
            $table->string('seller_last_name', 255)->nullable();
            $table->integer('seller_nationality_id')->nullable();
            $table->integer('seller_residence_id')->nullable();
            $table->string('seller_id_number', 100)->nullable();
            $table->string('seller_proof_image', 100)->nullable();
            $table->string('proof_image', 100)->nullable();
        });
    }
}

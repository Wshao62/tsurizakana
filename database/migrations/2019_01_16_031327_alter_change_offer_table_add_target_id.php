<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangeOfferTableAddTargetId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fish_offers', function (Blueprint $table) {
            $table->renameColumn('user_id', 'offer_user_id');
            $table->integer('request_user_id')->unsigned()->after('fish_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fish_offers', function (Blueprint $table) {
            $table->renameColumn('offer_user_id', 'user_id');
            $table->dropColumn('request_user_id');
        });
    }
}

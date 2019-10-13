<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToFishsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fish', function (Blueprint $table) {
            $table->string('how_to_tighten')->after('status');
            $table->string('delivery_method')->after('status');
            $table->string('size_kg')->after('status');
            $table->string('size_cm')->after('status');
            $table->string('amount')->after('status');
            $table->string('prefecture')->after('location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fish', function (Blueprint $table) {
            $table->dropColumn('how_to_tighten');
            $table->dropColumn('delivery_method');
            $table->dropColumn('size_kg');
            $table->dropColumn('size_cm');
            $table->dropColumn('amount');
            $table->dropColumn('prefecture');
        });
    }
}

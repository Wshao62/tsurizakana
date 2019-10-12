<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('day_of_week_fishing')->nullable()->after('tel');
            $table->string('fishing_history')->nullable()->after('tel');
            $table->string('good_fishing_fish')->nullable()->after('tel');
            $table->string('fishing_area')->nullable()->after('tel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('day_of_week_fishing');
            $table->dropColumn('fishing_history');
            $table->dropColumn('good_fishing_fish');
            $table->dropColumn('fishing_area');
        });
    }
}

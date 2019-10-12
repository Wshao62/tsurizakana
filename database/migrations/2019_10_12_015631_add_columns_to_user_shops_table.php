<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUserShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_shops', function (Blueprint $table) {
            $table->string('home_page_url')->nullable()->after('full_address');
            $table->string('shop_type')->nullable()->after('full_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_shops', function (Blueprint $table) {
            $table->dropColumn('home_page_url');
            $table->dropColumn('shop_type');
        });
    }
}

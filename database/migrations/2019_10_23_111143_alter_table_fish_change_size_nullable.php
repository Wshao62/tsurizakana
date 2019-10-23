<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableFishChangeSizeNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fish', function (Blueprint $table) {
            $table->string('size_cm')->nullable()->change();
            $table->string('size_kg')->nullable()->change();
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
            $table->string('size_cm')->nullable(false)->change();
            $table->string('size_kg')->nullable(false)->change();
        });
    }
}

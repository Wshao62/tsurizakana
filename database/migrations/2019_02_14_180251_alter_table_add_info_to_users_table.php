<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAddInfoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('bank_user_name')->nullable()->after('identificated_at');
            $table->integer('bank_number')->nullable()->after('identificated_at');
            $table->integer('bank_branch_code')->nullable()->after('identificated_at');
            $table->string('bank_name')->nullable()->after('identificated_at');
            $table->tinyInteger('bank_type')->nullable()->after('identificated_at');
            $table->text('introduction')->nullable()->after('identificated_at');
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
            $table->dropColumn('introduction');
            $table->dropColumn('bank_name');
            $table->dropColumn('bank_branch_code');
            $table->dropColumn('bank_type');
            $table->dropColumn('bank_number');
            $table->dropColumn('bank_user_name');
        });
    }
}

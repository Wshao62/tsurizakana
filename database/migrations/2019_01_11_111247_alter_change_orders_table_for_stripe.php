<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangeOrdersTableForStripe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('user_name');
            $table->dropColumn('item_name');
            $table->dropColumn('process_code');
            $table->dropColumn('trans_code');
            $table->renameColumn('completed_at', 'billed_at');
            $table->string('stripe_charge_id')->after('price');
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
            $table->dropColumn('stripe_charge_id');
            $table->string('user_name')->default('dummy')->after('user_id');
            $table->string('item_name')->default('dummy')->after('item_id');
            $table->tinyInteger('process_code')->default(1)->after('price');
            $table->integer('trans_code')->nullable()->after('process_code');
            $table->renameColumn('billed_at', 'completed_at');
        });
    }
}

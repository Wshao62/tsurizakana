<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->integer('price')->comment('振込申請額');
            $table->integer('fee')->comment('手数料');
            $table->integer('transfer_price')->comment('実際の振込額');
            $table->dateTime('requested_at')->comment('申請日時');
            $table->date('transfer_at')->comment('振込予定日');
            $table->tinyInteger('status')->comment('ステータス');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfer_requests');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFishTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fish', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('fish_category_id')->unsigned();
            $table->string('fish_category_name');
            $table->integer('seller_id')->unsigned();
            $table->integer('buyer_id')->unsigned()->nullable();
            $table->string('location');
            $table->string('destination');
            $table->integer('price');
            $table->text('description');
            $table->tinyInteger('status');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('CREATE FULLTEXT INDEX `destination_fulltext_idx` ON `fish` (`destination`) WITH PARSER ngram;');
        DB::statement('CREATE FULLTEXT INDEX `description_fulltext_idx` ON `fish` (`description`) WITH PARSER ngram;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fish');
    }
}

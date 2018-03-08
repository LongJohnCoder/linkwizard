<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlTagMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('url_tag_maps', function (Blueprint $table) {
          $table->increments('id');
          $table->bigInteger('url_tag_id')->unsigned()->index();
          $table->integer('url_id')->unsigned()->index();
          $table->timestamps();

          /* Foreign key definitions */
          $table->foreign('url_id')
                ->references('id')
                ->on('urls')
                ->onDelete('cascade');
          $table->foreign('url_tag_id')
                ->references('id')
                ->on('url_tags')
                ->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('url_tag_maps');
    }
}

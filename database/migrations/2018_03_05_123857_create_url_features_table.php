<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('url_features', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('url_id')->unsigned()->index();
          $table->string('fb_pixel_id',25)->index()->nullable();
          $table->timestamps();

          /* Foreign key definitions */
          $table->foreign('url_id')
                ->references('id')
                ->on('urls')
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
        Schema::drop('url_features');
    }
}

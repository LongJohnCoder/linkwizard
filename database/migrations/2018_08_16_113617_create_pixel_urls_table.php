<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePixelUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pixel_urls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('url_id')->unsigned()->index();
            $table->foreign('url_id')->references('id')->on('urls')->onDelete('cascade');
            $table->integer('pixel_id')->unsigned()->index();
            $table->foreign('pixel_id')->references('id')->on('user_pixels')->onDelete('cascade');
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
        Schema::drop('pixel_urls');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPixelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_pixels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('pixel_provider_id')->unsigned()->index();
            $table->foreign('pixel_provider_id')->references('id')->on('pixel_providers')->onDelete('cascade');
            $table->string('pixel_id')->nullable();
            $table->text('pixel_script')->nullable();
            $table->tinyInteger('is_custom')->default('0')->comment('0=>Not Custom ; 1=> Custom');
            $table->string('pixel_name');
            $table->tinyInteger('script_position')->default('0')->comment('0=>Header ; 1=> Footer');
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
        Schema::drop('user_pixels');
    }
}

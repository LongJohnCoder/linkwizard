<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('url_id')->unsigned()->index();
            $table->string('ip_address');
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('platform')->nullable();
            $table->string('browser')->nullable();
            $table->string('referer')->nullable();
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
        Schema::drop('ip_locations');
    }
}

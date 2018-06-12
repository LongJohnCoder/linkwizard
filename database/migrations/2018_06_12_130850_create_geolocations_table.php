<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeolocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geolocations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('url_id');
            $table->string('country_name');
            $table->string('country_code');
            $table->integer('allow');
            $table->integer('deny');
            $table->string('redirection');
            $table->string('url');
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
        Schema::drop('geolocations');
    }
}

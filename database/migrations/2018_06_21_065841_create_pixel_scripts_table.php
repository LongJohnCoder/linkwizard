<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePixelScriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pixel_scripts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('network_type')->comment('type of the network eg: facebook, google etc');
            $table->text('network_script')->comment('script for the network for pixel');
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
        Schema::drop('pixel_scripts');
    }
}

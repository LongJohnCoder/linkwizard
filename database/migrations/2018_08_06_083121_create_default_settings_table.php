<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaultSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('page_color')->default('#005C96');
            $table->string('default_redirection_time')->default('5000');
            $table->string('default_image')->default('public/images/Tier5.jpg');
            $table->string('default_redirecting_text')->default('Redirecting...');
            $table->string('default_fav_icon')->default('https://tier5.us/images/favicon.ico');
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
        Schema::drop('default_settings');
    }
}

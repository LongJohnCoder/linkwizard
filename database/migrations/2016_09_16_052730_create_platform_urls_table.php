<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_url', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('url_id')
                    ->unsigned()
                    ->index();
            $table->integer('platform_id')
                    ->unsigned()
                    ->index();
            $table->timestamps();

            /* Foreign key definitions */
            $table->foreign('url_id')
                    ->references('id')
                    ->on('urls')
                    ->onDelete('cascade');
            $table->foreign('platform_id')
                    ->references('id')
                    ->on('platforms')
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
        Schema::drop('platform_url');
    }
}

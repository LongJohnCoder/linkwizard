<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrowserUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('browser_url', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('url_id')
                    ->unsigned()
                    ->index();
            $table->integer('browser_id')
                    ->unsigned()
                    ->index();
            $table->timestamps();

            /* Foreign key definitions */
            $table->foreign('url_id')
                    ->references('id')
                    ->on('urls')
                    ->onDelete('cascade');
            $table->foreign('browser_id')
                    ->references('id')
                    ->on('browsers')
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
        Schema::drop('browser_url');
    }
}

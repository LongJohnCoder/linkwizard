<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefererUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referer_url', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('url_id')
                    ->unsigned()
                    ->index();
            $table->integer('referer_id')
                    ->unsigned()
                    ->index();
            $table->timestamps();

            /* Foreign key definitions */
            $table->foreign('url_id')
                    ->references('id')
                    ->on('urls')
                    ->onDelete('cascade');
            $table->foreign('referer_id')
                    ->references('id')
                    ->on('referers')
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
        Schema::drop('referer_url');
    }
}

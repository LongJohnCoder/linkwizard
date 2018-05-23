<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCircularLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circular_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('url_id')
                ->unsigned()
                ->index();
            $table->text('actual_link');
            $table->timestamps();

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
        Schema::drop('circular_links');
    }
}

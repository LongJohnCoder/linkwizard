<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlLinkSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('url_link_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('url_id')->unsigned()->index();
            $table->text('url');
            $table->string('protocol', 20);
            $table->tinyInteger('day')->comment('1=monday, 2=tuesday 3=wednesday and so on');
            $table->timestamps();

            /* Foreign key */

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
        Schema::drop('url_link_schedules');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_limits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')
                    ->unsigned()
                    ->index();
            $table->integer('limit_of_links')
                    ->nullable();
            $table->integer('number_of_links');
            $table->timestamps();

            /* Foreign Key Constraint */
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
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
        Schema::drop('link_limits');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_url', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('url_id')
                    ->unsigned()
                    ->index();
            $table->integer('country_id')
                    ->unsigned()
                    ->index();
            $table->timestamps();

            /* Foreign key definitions */
            $table->foreign('url_id')
                ->references('id')
                ->on('urls')
                ->onDelete('cascade');
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
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
        Schema::drop('country_url');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProtocalToCircularLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::table('circular_links', function (Blueprint $table) {
            $table->enum('protocol', ['http', 'https', 'ftp'])
                    ->default('http')
                    ->nullable()
                    ->after('url_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('circular_links', function (Blueprint $table) {
            //
        });
    }
}

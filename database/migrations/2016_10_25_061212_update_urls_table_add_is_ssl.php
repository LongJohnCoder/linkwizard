<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUrlsTableAddIsSsl extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('urls', function (Blueprint $table) {
            $table->enum('protocol', ['http', 'https', 'ftp'])
                    ->default('http')
                    ->nullable()
                    ->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('urls', function (BLueprint $table) {
            $table->dropColumn('protocol');
        });
    }
}

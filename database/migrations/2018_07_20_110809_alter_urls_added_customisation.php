<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUrlsAddedCustomisation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('urls', function (Blueprint $table) {
            /* Columns for customize setting for urls */
            $table->string('customColour')->default('#005C96')->after('geolocation');
            $table->tinyInteger('usedCustomised')->default('0')->comment('0 => using default settings; 1 => using custom settings')->after('customColour');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('urls', function (Blueprint $table) {
            //
        });
    }
}

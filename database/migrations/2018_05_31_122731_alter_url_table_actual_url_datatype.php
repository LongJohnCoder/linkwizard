<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUrlTableActualUrlDatatype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE `urls` CHANGE `actual_url` `actual_url` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE `urls` CHANGE `actual_url` `actual_url` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;');
    }
}

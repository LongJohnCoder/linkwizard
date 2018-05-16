<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUrlsAddExpiration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('urls', function (Blueprint $table) {
            $table->dateTime('date_time')
                ->nullable()
                ->after('twitter_image');
            $table->string('timezone')
                ->nullable()
                ->after('date_time');
            $table->text('redirect_url')
                ->nullable()
                ->after('timezone');
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
            $table->dropColumn('date_time');
            $table->dropColumn('timezone');
            $table->dropColumn('redirect_url');
        });
    }
}

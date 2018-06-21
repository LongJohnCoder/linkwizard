<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableUrlFeaturesAddNewNetworkColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('url_features', function (Blueprint $table) {
            $table->string('twt_pixel_id')
                ->index()
                ->nullable()
                ->after('gl_pixel_id');
            $table->string('li_pixel_id')
                ->index()
                ->nullable()
                ->after('twt_pixel_id');
            $table->string('pinterest_pixel_id')
                ->index()
                ->nullable()
                ->after('li_pixel_id');
            $table->string('quora_pixel_id')
                ->index()
                ->nullable()
                ->after('pinterest_pixel_id');
            $table->text('custom_pixel_id')
                ->comment('script for custom pixel')
                ->nullable()
                ->after('quora_pixel_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('url_features', function (Blueprint $table) {
            $table->dropColumn('twt_pixel_id');
            $table->dropColumn('li_pixel_id');
            $table->dropColumn('pinterest_pixel_id');
            $table->dropColumn('quora_pixel_id');
            $table->dropColumn('custom_pixel_id');
        });
    }
}

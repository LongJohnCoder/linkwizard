<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGooglePixelIdToUrlFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('url_features', function (Blueprint $table) {
          $table->string('gl_pixel_id',35)->index()->nullable()->after('fb_pixel_id');
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
          $table->dropColumn('gl_pixel_id');
      });
    }
}

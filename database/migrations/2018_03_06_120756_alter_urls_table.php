<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('urls', function (Blueprint $table) {

          $table->string('meta_description')->nullable();
          /* Columns for customize setting for urls */
          $table->string('customColour')->default('#005C96');
          $table->tinyInteger('usedCustomised')->default('0')->comment('0 => using default settings; 1 => using custom settings');

          //columns required for facebook open graph
          $table->string('og_title')->nullable();
          $table->string('og_description')->nullable();
          $table->string('og_url')->nullable();
          $table->string('og_image')->nullable();

          //columns required for twitter
          $table->string('twitter_title')->nullable();
          $table->string('twitter_description')->nullable();
          $table->string('twitter_url')->nullable();
          $table->string('twitter_image')->nullable();
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

          //columns required for meta description
          $table->dropColumn('meta_description');

          //columns required for facebook open graph
          $table->dropColumn(['og_title','og_description','og_url','og_image']);

          //columns required for twitter
          $table->dropColumn(['twitter_title','twitter_description','twitter_url','twitter_image']);
      });
    }
}

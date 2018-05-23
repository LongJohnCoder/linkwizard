<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUrlsTableAddColumnHasCircularLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('urls', function ($table) {
           $table->integer('no_of_circular_links')
                ->default(1);
           $table->integer('link_hits_count')
               ->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('urls', function ($table) {
            $table->dropColumn(['no_of_circular_links', 'link_hits_count']);
        });
    }
}

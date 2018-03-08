<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlSearchInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('url_search_info', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('url_id')->unsigned()->index();
          $table->text('description');
          $table->timestamps();

          /* Foreign key definitions */
          $table->foreign('url_id')
                ->references('id')
                ->on('urls')
                ->onDelete('cascade');
      });
      //this is written as raw query as laravel does not support FULLTEXT search field and it is only a feature for mysql 6+ and vendor specific
      DB::statement('ALTER TABLE url_search_info ADD FULLTEXT fulltext_index (description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

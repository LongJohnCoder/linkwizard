<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('url_tags', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('tag',150)->index()->unique();
          $table->timestamps();
      });

      //this is written as raw query as laravel does not support FULLTEXT search field and it is only a feature for mysql 6+ and vendor specific
      DB::statement('ALTER TABLE url_tags ADD FULLTEXT fulltext_index (tag)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('url_tags');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubdomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subdomains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')
                    ->unique();
            $table->integer('user_id')
                    ->unsigned()
                    ->index();
            $table->integer('url_id')
                    ->unsigned()
                    ->index()
                    ->nullable();
            $table->enum('type', ['subdomain', 'subdirectory'])
                    ->nullable();
            $table->timestamps();

            /* Foreign key definitions */
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            $table->foreign('url_id')
                    ->references('id')
                    ->on('urls')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('subdomains');
    }
}

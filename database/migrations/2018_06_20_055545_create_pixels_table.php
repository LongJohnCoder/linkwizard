<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePixelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pixels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->string('network');
            $table->string('pixel_name');
            $table->string('pixel_id')->nullable();
            $table->text('custom_pixel_script')->nullable();
            $table->integer('script_position')->default(0)->comment('0 = default header position, 1 = footer position');
            $table->timestamps();

            /* Foreign key definitions */
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::drop('pixels');
    }
}

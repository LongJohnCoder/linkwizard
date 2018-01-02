<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')
            ->insert([
                'name' => 'No user',
                'email' => 'nouser@gmail.com',
                'password' => '$2y$10$mCQo5bVIBlLb8Ebv2BWOJuyeza77K8LuCjjUUVql4eYR6siRcgll6'
            ]);
        DB::table('users')
            ->where('email','=','nouser@gmail.com')
            ->update([
                'id' => 0,
            ]);
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

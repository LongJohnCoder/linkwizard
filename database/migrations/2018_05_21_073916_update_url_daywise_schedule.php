<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUrlDaywiseSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('urls', function (Blueprint $table) {
            $table->enum('is_scheduled', ['y', 'n'])
                ->default('n')
                ->comment('y means scheduled n means not scheduled')
                ->after('redirect_url');
            $table->text('day_one')
                ->nullable()
                ->comment('link for monday')
                ->after('is_scheduled');
            $table->text('day_two')
                ->nullable()
                ->comment('link for tuesday')
                ->after('day_one');
            $table->text('day_three')
                ->nullable()
                ->comment('link for wednesday')
                ->after('day_two');
            $table->text('day_four')
                ->nullable()
                ->comment('link for thursday')
                ->after('day_three');
            $table->text('day_five')
                ->nullable()
                ->comment('link for friday')
                ->after('day_four');
            $table->text('day_six')
                ->nullable()
                ->comment('link for saturday')
                ->after('day_five');
            $table->text('day_seven')
                ->nullable()
                ->comment('link for sunday')
                ->after('day_six');
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
            $table->dropColumn('is_scheduled');
            $table->dropColumn('day_one');
            $table->dropColumn('day_two');
            $table->dropColumn('day_three');
            $table->dropColumn('day_four');
            $table->dropColumn('day_five');
            $table->dropColumn('day_six');
            $table->dropColumn('day_seven');
        });
    }
}

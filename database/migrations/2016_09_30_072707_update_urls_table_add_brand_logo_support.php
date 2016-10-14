<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUrlsTableAddBrandLogoSupport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('urls', function (Blueprint $table) {
            $table->boolean('is_custom')
                ->default('0')
                ->after('is_archived');
            $table->string('uploaded_path')
                ->nullable()
                ->after('is_custom');
            $table->integer('redirecting_time')
                ->default('5000')
                ->after('uploaded_path');
            $table->string('redirecting_text_template')
                ->default('Redirecting...')
                ->after('uploaded_path');
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
            $table->dropColumn('is_custom');
            $table->dropColumn('uploaded_path');
            $table->dropColumn('redirecting_time');
        });
    }
}

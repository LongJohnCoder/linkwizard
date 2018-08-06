<?php

use Illuminate\Database\Seeder;

class DefaultSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('default_settings')->insert([
            'page_color' => '#005C96',
            'default_redirection_time' => '5000',
            'default_image' => 'public/images/Tier5.jpg',
            'default_redirecting_text' => 'Redirecting...',
            'default_fav_icon'  =>  'https://tier5.us/images/favicon.ico',
        ]);
    }
}

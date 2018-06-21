<?php

use Illuminate\Database\Seeder;
use App\PixelScript;

class PixelScrptsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-s H:i:s');

        PixelScript::unguard();
        /**
         * Seeding multiple rows at once
         */
        PixelScript::insert([
            [
                'network_type' => 'fb_pixel_id',
                'network_script' => '',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'network_type' => 'gl_pixel_id',
                'network_script' => '',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'network_type' => 'li_pixel_id',
                'network_script' => '',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'network_type' => 'twt_pixel_id',
                'network_script' => '',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(StripeTableSeeder::class);
        $this->call(LimitSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(PixelScrptsTableSeeder::class);
        $this->call(TimezonesTableSeeder::class);
        $this->call(ProfileTableSeeder::class);
    }
}

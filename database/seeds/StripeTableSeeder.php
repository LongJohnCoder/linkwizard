<?php

use Illuminate\Database\Seeder;

class StripeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stripe_keys')->insert([
            'p_key' => 'pk_test_NeErELVu7Qbv59BWm0c7HQT1',
            's_key' => 'sk_test_BHTf6x3tSwf9Zf53ZvFaCA95',
        ]);
    }
}

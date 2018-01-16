<?php

use Illuminate\Database\Seeder;
use \Carbon\Carbon;
class LimitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      DB::table('limits')->insert([
          [
          'plan_code' => 'tr5free',
          'plan_name' => 'free',
          'limits'    => 10,
          'created_at'=> Carbon::now(),
          'updated_at'=> Carbon::now()
          ],
          [
              'plan_code' => 'tr5Basic',
              'plan_name' => 'basic',
              'limits'    => 100,
              'created_at'=> Carbon::now(),
              'updated_at'=> Carbon::now()
          ],
          [
              'plan_code' => 'tr5Advanced',
              'plan_name' => 'advanced',
              'limits'    => null,
              'created_at'=> Carbon::now(),
              'updated_at'=> Carbon::now()
          ]]);
    }
}

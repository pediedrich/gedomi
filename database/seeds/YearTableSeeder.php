<?php

use Illuminate\Database\Seeder;
use App\Year;

class YearTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Year::truncate();

        for ($i=2000; $i < 2021; $i++) {
          // code...
          Year::firstOrCreate([
              'number' => $i
          ]);
        }
          //$user->roles()->attach($role_admin);
     }
}

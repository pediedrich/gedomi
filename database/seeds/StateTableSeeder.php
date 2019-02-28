<?php

use Illuminate\Database\Seeder;
use App\State;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::firstOrCreate([
          'name' => 'Creado',
        ]);

        State::firstOrCreate([
          'name' => 'Ingreso',
        ]);

        State::firstOrCreate([
          'name' => 'Egreso',
        ]);
    }
}

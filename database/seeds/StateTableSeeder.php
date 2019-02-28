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
        State::create([
          'name' => 'Creado',
        ]);

        State::create([
          'name' => 'Ingreso',
        ]);

        State::create([
          'name' => 'Egreso',
        ]);
    }
}

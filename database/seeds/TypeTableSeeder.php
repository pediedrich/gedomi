<?php

use Illuminate\Database\Seeder;
use App\Type;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      Type::firstOrCreate([
        'name' => 'Laboral'
      ]);

      Type::firstOrCreate([
        'name' => 'Familia'
      ]);

      Type::firstOrCreate([
        'name' => 'Civil y Comercial'
      ]);

      Type::firstOrCreate([
        'name' => 'Penal'
      ]);

      Type::firstOrCreate([
        'name' => 'Administrativo'
      ]);

      Type::firstOrCreate([
        'name' => 'Contensioso Administativo'
      ]);

      Type::firstOrCreate([
        'name' => 'Competencia Originaria'
      ]);

    }
}

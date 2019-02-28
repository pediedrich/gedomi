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

      $type = new Type();
      $type->name = 'Administrativo';
      $type->save();

      $type = new Type();
      $type->name = 'Laboral';
      $type->save();

      $type = new Type();
      $type->name = 'Civil y Comercial';
      $type->save();

      $type = new Type();
      $type->name = 'Contensioso Administativo';
      $type->save();

      $type = new Type();
      $type->name = 'Penal';
      $type->save();

      $type = new Type();
      $type->name = 'Competencia Originaria';
      $type->save();



    }
}

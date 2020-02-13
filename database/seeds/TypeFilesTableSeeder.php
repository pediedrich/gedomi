<?php

use Illuminate\Database\Seeder;
use App\TypeFile;

class TypeFilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeFile::firstOrCreate([
          'name' => 'Resolución'
        ]);

        TypeFile::firstOrCreate([
          'name' => 'Inhibicion'
        ]);

        TypeFile::firstOrCreate([
          'name' => 'Sentencia'
        ]);

        TypeFile::firstOrCreate([
          'name' => 'Medida Mejor Proveer'
        ]);

        TypeFile::firstOrCreate([
          'name' => 'Administrativo'
        ]);
    }
}

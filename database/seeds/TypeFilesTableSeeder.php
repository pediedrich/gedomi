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
        TypeFile::create([
          'name' => 'Resolución'
        ]);
    }
}

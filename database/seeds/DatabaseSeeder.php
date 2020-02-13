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
         // La creación de datos de roles debe ejecutarse primero
         //$this->call(RoleTableSeeder::class);

         // Los usuarios necesitarán los roles previamente generados
         //s
         //$this->call(UserTableSeeder::class);
         $this->call(YearTableSeeder::class);
         $this->call(TypeTableSeeder::class);
         $this->call(RolesSeeder::class);
         $this->call(TypeFilesTableSeeder::class);
         $this->call(StateTableSeeder::class);
     }
}

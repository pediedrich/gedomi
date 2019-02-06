<?php

use Illuminate\Database\Seeder;
use App\User;
//use App\Role;

class UserTableSeeder extends Seeder
{
    public function run()
    {

        $user = new User();
        $user->name = 'draacosta';
        $user->email = 'draacosta@sistema.com';
        $user->password = bcrypt('1234');
        $user->save();


        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('1234');
        $user->save();
        //$user->roles()->attach($role_admin);
     }
}

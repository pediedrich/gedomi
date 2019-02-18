<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Permission;

class RolesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //configure permissions
        $permissions = [

            /*
             * expedient's permissions
             */
            'expedient_list' => 'Listar Expedientes',
            'expedient_show' => 'Ver detalles de expediente',
            'expedient_create' => 'Crear un expediente',
            'expedient_edit' => 'Editar un expediente',
            'expedient_destroy' => 'Eliminar un expediente',

            /*
             * file's permissions
             */
            'files_list' => 'Listar Documentos',
            'files_upload' => 'Subir un documento',
            'files_destroy' => 'Eliminar un documento',
            'files_download' => 'Descargar un documento',

            /*
             * user's permissions
             */
            'user_list' => 'Listar usuarios',
            'user_show' => 'Ver detalles de usuario',
            'user_create' => 'Crear un usuario',
            'user_edit' => 'Editar un usuario',
            'user_destroy' => 'Eliminar un usuario',
            'user_reset_password' => 'Restablecer contraseña de usuario',

            /*
             * role's permissions
             */
            'role_list' => 'Listar roles',
            'role_show' => 'Ver detalles de rol',
            'role_create' => 'Crear un rol',
            'role_edit' => 'Editar un rol',
            'role_destroy' => 'Eliminar un rol',


        ];

        $ministroPermissions = [
          /*
           * expedient's permissions
           */
          'expedient_list' => 'Listar Expedientes',
          'expedient_show' => 'Ver detalles de expediente',
          'expedient_destroy' => 'Eliminar un expediente',

          /*
           * file's permissions
           */
          'files_list' => 'Listar Documentos',
          'files_download' => 'Descargar un documentos',
          //'files_upload' => 'Subir documentos',

          /*
           * user's permissions
           */
          'user_list' => 'Listar usuarios',
          'user_show' => 'Ver detalles de usuario',
          'user_create' => 'Crear un usuario',
          'user_edit' => 'Editar un usuario',
          'user_destroy' => 'Eliminar un usuario',
          'user_reset_password' => 'Restablecer contraseña de usuario',
        ];


        $coordinadorPermissions = [
          /*
           * expedient's permissions
           */
          'expedient_list' => 'Listar Expedientes',
          'expedient_create' => 'Crear un expediente',
          'expedient_edit' => 'Editar un expediente',
  //        'expedient_destroy' => 'Eliminar un expediente',
        ];


        $proveyentePermissions = [
          /*
           * expedient's permissions
           */
          'expedient_list' => 'Listar Expedientes',
          'expedient_show' => 'Ver detalles de expediente',

          /*
           * file's permissions
           */
          'files_list' => 'Listar Documentos',
          'files_upload' => 'Subir un documento',
          'files_destroy' => 'Eliminar un documento',
          'files_download' => 'Descargar un documento',
        ];

        //delete all roles
        $roles = Role::all();
        foreach ($roles as $role) {
            $role->delete();
        }

        DB::statement("SET foreign_key_checks=0");
        Permission::truncate();
        DB::statement("SET foreign_key_checks=1");

        //create new permissions
        foreach ($permissions as $key => $value) {
            $permission = new Permission();
            $permission->name = $key;
            $permission->display_name = $value;
            $permission->save();
        }

        //create admin role
        $role = new Role();
        $role->name = 'administrador';
        $role->display_name = 'Administrador del sistema';
        $role->save();

        //attach all permissions to the admin role
        $role->attachPermissions(Permission::all());


        //create user admin (if not exist)
        $user = new User();
        $user->name = 'admin';
        $user->display_name = 'Usuario administrador';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('1234');
        $user->save();

        //attach role to the admin user
        $user->attachRole($role);

        //create ministro role
        $roleM = new Role();
        $roleM->name = 'ministro';
        $roleM->display_name = 'Ministro';
        $roleM->save();

        //attach permissions to the coordinator role
        foreach ($ministroPermissions as $key => $value) {
            $permission = Permission::where('name', '=', $key)->first();
            $roleM->attachPermission($permission);
        }

        //create user ministro (if not exist)
        $userM = new User();
        $userM->name = 'ministro';
        $userM->display_name = 'Usuario Ministro';
        $userM->email = 'ministro@ministro.com';
        $userM->password = bcrypt('1234');
        $userM->save();

        //attach role to the ministro user
        $userM->attachRole($roleM);

        //create coordinator role
        $roleC = new Role();
        $roleC->name = 'coordinator';
        $roleC->display_name = 'Coordinador';
        $roleC->save();

        //attach permissions to the coordinator role
        foreach ($coordinadorPermissions as $key => $value) {
            $permission = Permission::where('name', '=', $key)->first();
            $roleC->attachPermission($permission);
        }

        //create user ministro (if not exist)
        $userC = new User();
        $userC->name = 'coordinador';
        $userC->display_name = 'Usuario Coordinador';
        $userC->email = 'coordinador@coordinador.com';
        $userC->password = bcrypt('1234');
        $userC->save();

        //attach role to the ministro user
        $userC->attachRole($roleC);

        //create proveyente role
        $roleE = new Role();
        $roleE->name = 'proveyente';
        $roleE->display_name = 'Proveyente';
        $roleE->save();

        //attach permissions to the proveyente role
        foreach ($proveyentePermissions as $key => $value) {
            $permissionE = Permission::where('name', '=', $key)->first();
            $roleE->attachPermission($permissionE);
        }


        //create user ministro (if not exist)
        $userE = new User();
        $userE->name = 'proveyente';
        $userE->display_name = 'Usuario Proveyente';
        $userE->email = 'proveyente@proveyente.com';
        $userE->password = bcrypt('1234');
        $userE->save();

        //attach role to the ministro user
        $userE->attachRole($roleE);

    }

}

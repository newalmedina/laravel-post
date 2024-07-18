<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RolesSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();


        $roles = array();
        $adminRole = new Role();
        $adminRole->display_name = 'Administrador';
        $adminRole->name = Str::slug('admin');
        $adminRole->description = 'Administradores';

        $adminRole->active = true;
        $adminRole->can_delete = false;
        $adminRole->can_show = true;
        $adminRole->save();
        $rolAdmin = $adminRole->id;



        // $userRole = new Role;
        // $userRole->display_name = 'Doctor';
        // $userRole->name = Str::slug('doctor');
        // $userRole->description = 'Doctor';
        // $userRole->can_delete = false;

        // $userRole->can_show = true;
        // $userRole->active = true;
        // $userRole->save();

        // $userRole = new Role;
        // $userRole->display_name = 'Paciente';
        // $userRole->name = Str::slug('patient');
        // $userRole->description = 'Paciente';
        // $userRole->can_delete = false;

        // $userRole->can_show = true;
        // $userRole->active = true;
        // $userRole->save();

        // $userRole = new Role;
        // $userRole->display_name = 'Usuario front';
        // $userRole->name = Str::slug('usuario-front');
        // $userRole->description = 'Usuario de front-End';

        // $userRole->active = true;
        // $userRole->save();

        // $apiRole = new Role;
        // $apiRole->display_name = 'Usuario Api';
        // $apiRole->name = Str::slug('usuario-api');
        // $apiRole->description = 'Usuario de Api';

        // $apiRole->active = true;
        // $apiRole->save();

        // Asignamos a cada usuario un role de manera aleatoria
        $users = User::get();
        $i = 0;
        foreach ($users as $user) {
            switch ($i) {
                case 0:
                    $user->attachRole($rolAdmin);
                    break;
                default:
                    $user->attachRole($userRole->id);
                    break;
            }
            $i = ($i + 1) % 3;
        }
    }
}

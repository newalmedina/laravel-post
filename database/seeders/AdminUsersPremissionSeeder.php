<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Str;

class AdminUsersPremissionSeeder  extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->init();

        // Si los permisos los hemos creados volvemos
        $permExists = Permission::where('name', Str::slug('admin-users'))->first();
        if (!empty($permExists)) {
            return;
        }

        // Módulo de users
        $permissions = [
            [
                'display_name' => 'Usuarios',
                'name' => Str::slug('admin-users'),
                'description' => 'Usuarios - Módulo'
            ],
            [
                'display_name' => 'Usuarios - listado',
                'name' => Str::slug('admin-users-list'),
                'description' => 'Usuarios - lista'
            ],
            [
                'display_name' => 'Usuarios - crear',
                'name' => Str::slug('admin-users-create'),
                'description' => 'Usuarios - crear'
            ],
            [
                'display_name' => 'Usuarios - actualizar',
                'name' => Str::slug('admin-users-update'),
                'description' => 'Usuarios - actualizar'
            ],
            [
                'display_name' => 'Usuarios - borrar',
                'name' => Str::slug('admin-users-delete'),
                'description' => 'Usuarios - borrar'
            ],
            [
                'display_name' => 'Usuarios - ver',
                'name' => Str::slug('admin-users-read'),
                'description' => 'Usuarios - ver'
            ],
            [
                'display_name' => 'Usuarios - Suplantar Identidad',
                'name' => Str::slug('admin-users-suplant-identity'),
                'description' => 'Usuarios - Suplantar Identidad'
            ],
            [
                'display_name' => 'Usuarios - Recibir notificaciones de usuarios creados',
                'name' => Str::slug('admin-users-mail-user-created'),
                'description' => 'Usuarios - Recibir notificaciones de usuarios creados'
            ]
        ];

        $MenuChild = $this->insertPermissions($permissions, $this->childAdmin, $this->a_permission_admin);

        // Rol de administrador
        $roleAdmin = Role::where("name", "=", Str::slug('admin'))->first();
        if (!empty($this->a_permission_admin)) {
            $roleAdmin->attachPermissions($this->a_permission_admin);
        }
        $roleUser = Role::where("name", "=", Str::slug('usuario-front'))->first();
        if (!empty($this->a_permission_front)) {
            $roleUser->attachPermissions($this->a_permission_front);
        }
    }
}

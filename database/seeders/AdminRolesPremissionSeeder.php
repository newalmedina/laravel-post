<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Str;

class AdminRolesPremissionSeeder  extends BaseSeeder
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
        $permExists = Permission::where('name', Str::slug('admin-roles'))->first();
        if (!empty($permExists)) {
            return;
        }

        // Módulo de roles
        $permissions = [
            [
                'display_name' => 'Roles',
                'name' => Str::slug('admin-roles'),
                'description' => 'Roles - Módulo'
            ],
            [
                'display_name' => 'Roles - listado',
                'name' => Str::slug('admin-roles-list'),
                'description' => 'Roles - lista'
            ],

            [
                'display_name' => 'Roles - crear',
                'name' => Str::slug('admin-roles-create'),
                'description' => 'Roles - crear'
            ],
            [
                'display_name' => 'Roles - actualizar',
                'name' => Str::slug('admin-roles-update'),
                'description' => 'Roles - actualizar'
            ],
            [
                'display_name' => 'Roles - eliminar',
                'name' => Str::slug('admin-roles-delete'),
                'description' => 'Roles - eliminar'
            ],

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

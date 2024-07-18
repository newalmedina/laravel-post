<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Str;

class AdminProvincesPremissionSeeder  extends BaseSeeder
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
        $permExists = Permission::where('name', Str::slug('admin-provinces'))->first();
        if (!empty($permExists)) {
            return;
        }

        // Módulo de provinces
        $permissions = [
            [
                'display_name' => 'Provincias',
                'name' => Str::slug('admin-provinces'),
                'description' => 'Provincias - Módulo'
            ],
            [
                'display_name' => 'Provincias - listado',
                'name' => Str::slug('admin-provinces-list'),
                'description' => 'Provincias - lista'
            ],
            [
                'display_name' => 'Provincias - crear',
                'name' => Str::slug('admin-provinces-create'),
                'description' => 'Provincias - crear'
            ],
            [
                'display_name' => 'Provincias - actualizar',
                'name' => Str::slug('admin-provinces-update'),
                'description' => 'Provincias - actualizar'
            ],
            [
                'display_name' => 'Provincias - borrar',
                'name' => Str::slug('admin-provinces-delete'),
                'description' => 'Provincias - borrar'
            ],
            [
                'display_name' => 'Provincias - ver',
                'name' => Str::slug('admin-provinces-read'),
                'description' => 'Provincias - ver'
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

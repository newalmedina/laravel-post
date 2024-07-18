<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Str;

class AdminMunicipiosPremissionSeeder  extends BaseSeeder
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
        $permExists = Permission::where('name', Str::slug('admin-municipios'))->first();
        if (!empty($permExists)) {
            return;
        }

        // Módulo de municipios
        $permissions = [
            [
                'display_name' => 'Municipios',
                'name' => Str::slug('admin-municipios'),
                'description' => 'Municipios - Módulo'
            ],
            [
                'display_name' => 'Municipios - listado',
                'name' => Str::slug('admin-municipios-list'),
                'description' => 'Municipios - lista'
            ],
            [
                'display_name' => 'Municipios - crear',
                'name' => Str::slug('admin-municipios-create'),
                'description' => 'Municipios - crear'
            ],
            [
                'display_name' => 'Municipios - actualizar',
                'name' => Str::slug('admin-municipios-update'),
                'description' => 'Municipios - actualizar'
            ],
            [
                'display_name' => 'Municipios - borrar',
                'name' => Str::slug('admin-municipios-delete'),
                'description' => 'Municipios - borrar'
            ],
            [
                'display_name' => 'Municipios - ver',
                'name' => Str::slug('admin-municipios-read'),
                'description' => 'Municipios - ver'
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

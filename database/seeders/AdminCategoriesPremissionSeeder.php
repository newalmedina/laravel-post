<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Str;

class AdmincategoriesPremissionSeeder  extends BaseSeeder
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
        $permExists = Permission::where('name', Str::slug('admin-categories'))->first();
        if (!empty($permExists)) {
            return;
        }

        // Módulo de categories
        $permissions = [
            [
                'display_name' => 'categories',
                'name' => Str::slug('admin-categories'),
                'description' => 'Categorías - Módulo'
            ],
            [
                'display_name' => 'Categorías - listado',
                'name' => Str::slug('admin-categories-list'),
                'description' => 'Categorías - lista'
            ],
            [
                'display_name' => 'Categorías - crear',
                'name' => Str::slug('admin-categories-create'),
                'description' => 'Categorías - crear'
            ],
            [
                'display_name' => 'Categorías - actualizar',
                'name' => Str::slug('admin-categories-update'),
                'description' => 'Categorías - actualizar'
            ],
            [
                'display_name' => 'Categorías - borrar',
                'name' => Str::slug('admin-categories-delete'),
                'description' => 'Categorías - borrar'
            ],
            [
                'display_name' => 'Categorías - ver',
                'name' => Str::slug('admin-categories-read'),
                'description' => 'Categorías - ver'
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

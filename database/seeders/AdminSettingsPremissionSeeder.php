<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Str;

class AdminSettingsPremissionSeeder  extends BaseSeeder
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
        $permExists = Permission::where('name', Str::slug('admin-settings'))->first();
        if (!empty($permExists)) {
            return;
        }

        // Módulo de settings
        $permissions = [
            [
                'display_name' => 'Configuración',
                'name' => Str::slug('admin-settings'),
                'description' => 'Configuración - Módulo'
            ],

            [
                'display_name' => 'Configuración sitio web - ver',
                'name' => Str::slug('admin-settings-show'),
                'description' => 'Configuración sitio web - ver'
            ],
            [
                'display_name' => 'Configuración sitio web - actualizar',
                'name' => Str::slug('admin-settings-update'),
                'description' => 'Configuración sitio web - actualizar'
            ],
            [
                'display_name' => 'Configuración (Email - SMTP) - actualizar',
                'name' => Str::slug('admin-settings-smtp-update'),
                'description' => 'Configuración (Email - SMTP) - actualizar'
            ],
            [
                'display_name' => 'Configuración (Email - SMTP) - ver',
                'name' => Str::slug('admin-settings-smtp-show'),
                'description' => 'Configuración (Email - SMTP) - ver'
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

<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionsTree;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();
        DB::table('permissions_tree')->delete();

        $this->root = PermissionsTree::create(['permissions_id' => null]);
        $this->a_permission_admin = array();
        $this->a_permission_front = array();

        // Permisos generales
        $adminRole = new Permission();
        $adminRole->display_name = 'Administración';
        $adminRole->name = Str::slug('admin');
        $adminRole->description = 'Acceso a Administración';
        $adminRole->save();
        $this->childAdmin = $this->root->children()->create(['permissions_id' => $adminRole->id]);
        $this->a_permission_admin[] = $adminRole->id;

        $adminRole = new Permission();
        $adminRole->display_name = 'Web';
        $adminRole->name = Str::slug('frontend');
        $adminRole->description = 'Acceso a  Front End Web';
        $adminRole->save();
        $this->childWeb = $this->root->children()->create(['permissions_id' => $adminRole->id]);
        $this->a_permission_admin[] = $adminRole->id;

        $adminRole = new Permission();
        $adminRole->display_name = 'API';
        $adminRole->name = Str::slug('api');
        $adminRole->description = 'Acceso a llamadas a web services y Api';
        $adminRole->save();
        $this->childApi = $this->root->children()->create(['permissions_id' => $adminRole->id]);
        $this->a_permission_admin[] = $adminRole->id;

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

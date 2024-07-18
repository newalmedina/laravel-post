<?php

namespace Database\Seeders;

use App\Models\PatientMedicine;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(UserSeeder::class);
        $this->call(RolesSeeders::class);
        $this->call(PermissionSeeder::class);
        $this->call(AdminDashboardPremissionSeeder::class);
        $this->call(AdminSettingsPremissionSeeder::class);
        $this->call(AdminUsersPremissionSeeder::class);
        $this->call(AdminRolesPremissionSeeder::class);
        $this->call(AdminMunicipiosPremissionSeeder::class);
        $this->call(AdminProvincesPremissionSeeder::class);
        $this->call(GeneralSettingSeeders::class);
        $this->call(InsertProvinceMunicipDataSeeder::class);
        $this->call(AdmincategoriesPremissionSeeder::class);
      
    }
}

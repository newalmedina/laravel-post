<?php

namespace Database\Seeders;

use App\Models\Center;
use App\Models\Municipio;
use App\Models\Province;
use App\Models\User;
use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InsertCenterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $center = new  Center();
        $center->name = "Mi Centro";
        $center->active = 1;
        $center->default = 1;
        $center->save();

        $user = User::find(1);
        $user->userProfile->selected_center = 1;
        $user->userProfile->save();
        $user->centers()->sync([$center->id]);

        //segundo centro 
        $center = new  Center();
        $center->name = "Segundo centro";
        $center->active = 1;
        $center->default = 0;
        $center->save();
    }
}

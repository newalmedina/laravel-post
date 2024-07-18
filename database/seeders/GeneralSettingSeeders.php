<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GeneralSettingSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $generalSettings = [
            "site_name" => "Medical System",
            "image" => null,
            "phone" => "674987708",
            "email" => "medical@correo.com",
            "address" => "Invivienda 6",
            "province_id" => null,
            "municipio_id" => null,
            "active" => 1,

        ];

        foreach ($generalSettings as  $key => $value) {


            $setting = new Setting();
            $setting->key = $key;
            $setting->value = $value;
            $setting->group_slug = "general-settings";
            $setting->save();
        }

        $smtpSettings = [
            "MAIL_SEND_ACTIVE" => 1,
            "MAIL_MAILER" => "smtp",
            "MAIL_HOST" => "sandbox.smtp.mailtrap.io",
            "MAIL_PORT" => 2525,
            "MAIL_USERNAME" => "13f5d54d0beaee",
            "MAIL_PASSWORD" => "279c6344154db8",
            "MAIL_ENCRYPTION" => "tls",
            "MAIL_FROM_ADDRESS" => "medical@correo.com",
            "MAIL_FROM_NAME" => "Medical System",
        ];

        foreach ($smtpSettings as  $key => $value) {

            $setting = new Setting();
            $setting->key = $key;
            $setting->value = $value;
            $setting->group_slug = "smtp-settings";
            $setting->save();
        }
    }
}

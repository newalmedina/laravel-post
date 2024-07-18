<?php

/**
 * Created by PhpStorm.
 * User: toni
 * Date: 28/10/2015
 * Time: 10:03
 */

namespace App\Services;

use App\Models\Municipio;
use App\Models\Province;
use App\Models\Setting;

use Illuminate\Support\Facades\Config;

class SettingsServices
{
    public static function getGeneral()
    {
        $settings = Setting::general()->get();

        $data = [];
        foreach ($settings as $array) {
            $data[$array->key] = $array->value;
        }

        $data["complete_address"] = SettingsServices::getFullAddress($data);

        return $setting = (object)$data;
    }

    public static function getSmtp()
    {
        $settings = Setting::smtp()->get();

        $data = [];
        foreach ($settings as $array) {
            $data[$array->key] = $array->value;
        }


        return  (object)$data;
    }

    public static function setSmtpConfiguration()
    {
        $settingsSmtp = SettingsServices::getSmtp();

        // Establecer dinámicamente la configuración del correo SMTP
        Config::set('mail.mailers.smtp.transport', $settingsSmtp->MAIL_MAILER);
        Config::set('mail.mailers.smtp.host', $settingsSmtp->MAIL_HOST);
        Config::set('mail.mailers.smtp.port', $settingsSmtp->MAIL_PORT);
        Config::set('mail.mailers.smtp.username', $settingsSmtp->MAIL_USERNAME);
        Config::set('mail.mailers.smtp.password', $settingsSmtp->MAIL_PASSWORD);
        Config::set('mail.mailers.smtp.encryption', $settingsSmtp->MAIL_ENCRYPTION);
        Config::set('mail.from.address', $settingsSmtp->MAIL_FROM_ADDRESS);
        Config::set('mail.from.name', $settingsSmtp->MAIL_FROM_NAME);
    }

    public static function allowEmails()
    {
        $setting = Setting::smtp()->where("key", "MAIL_SEND_ACTIVE")->first();
        return (int) $setting->value;
    }

    public static function getFullAddress($data)
    {
        $province = Province::find($data["province_id"]);
        $municipio = Municipio::find($data["municipio_id"]);

        $addressArray = [
            $data["address"],
            !empty($province) ? $province->name : null,
            !empty($municipio) ? $municipio->name : null
        ];

        return implode(", ", $addressArray);
    }
}

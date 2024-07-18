<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminSettingRequest;
use App\Models\Municipio;
use App\Models\Province;
use App\Models\Setting;
use App\Services\SettingsServices;
use App\Services\StoragePathWork;

class FrontSettingsController extends Controller
{
    public function getImage($image)
    {
        $myServiceSPW = new StoragePathWork("settings");
        return $myServiceSPW->showFile($image, '/settings');
    }
}

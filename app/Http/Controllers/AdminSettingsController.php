<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminSettingRequest;
use App\Http\Requests\AdminSettingSmtpRequest;
use App\Models\Municipio;
use App\Models\Province;
use App\Models\Setting;
use App\Services\SettingsServices;
use App\Services\StoragePathWork;
use Illuminate\Support\Facades\File;

class AdminSettingsController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAbleTo('admin-settings-show') && !auth()->user()->isAbleTo('admin-settings-update')) {

            if (auth()->user()->isAbleTo('admin-settings-smtp-update') && auth()->user()->isAbleTo('admin-settings-smtp-show')) {
                return redirect()->to('/admin/settings-smtp');
            }

            app()->abort(403);
        }
        $disabledForm = false;

        if (!auth()->user()->isAbleTo('admin-settings-update')) {
            $disabledForm = true;
        }

        $setting = SettingsServices::getGeneral();

        $provincesList = Province::active()->get();
        $municipiosList = Municipio::active()->where("province_id", $setting->province_id)->get();

        $pageTitle = trans('settings/admin_lang.settings');
        $title = trans('settings/admin_lang.settings');
        $tab = 'tab_1';
        $generalSetting = true;
        return view('settings.admin_index', compact('pageTitle', "generalSetting", 'title', 'setting', 'provincesList', 'municipiosList', 'disabledForm', 'tab'));
    }

    public function update(AdminSettingRequest $request)
    {
        if (!auth()->user()->isAbleTo('admin-settings-update')) {
            app()->abort(403);
        }
        $data = $request->except(['_token', '_method', 'proengsoft_jsvalidation']);

        foreach ($data as $key => $value) {
            $setting = Setting::general()->where("key", $key)->first();
            if (!empty($setting)) {
                if ($key == "image") {
                    $image = $value;

                    if (!is_null($image)) {
                        $myServiceSPW = new StoragePathWork("settings");

                        if (!empty($setting->value)) {
                            $myServiceSPW->deleteFile($setting->value, '');
                            $setting->value = "";
                        }

                        $filename = $myServiceSPW->saveFile($image, '');
                        $setting->value = $filename;
                        //guardando en la carpeta public para luego sacarla en los pdf
                        // $image->storeAs('settings', $filename, 'public');


                        // Ruta de la carpeta "settings"
                        $rutaCarpeta = public_path('settings');

                        // Eliminar todos los archivos y directorios dentro de la carpeta
                        File::cleanDirectory($rutaCarpeta);
                        $image->move(public_path('settings'), $filename);
                    }
                } else {
                    $setting->value = $value;
                }
                $setting->save();
            }
        }

        return redirect()->to('/admin/settings/')->with('success', trans('general/admin_lang.save_ok'));
    }

    public function getImage($image)
    {
        $myServiceSPW = new StoragePathWork("settings");
        return $myServiceSPW->showFile($image, '/settings');
    }
    public function deleteImage($image)
    {
        $myServiceSPW = new StoragePathWork("settings");
        $setting = Setting::general()->where("value", $image)->first();


        if (!empty($setting->value)) {
            $myServiceSPW->deleteFile($setting->value, '');
            $setting->value = "";
        }
        $setting->save();

        return response()->json(array(
            'success' => true,
            'msg' => trans("general/admin_lang.delete_ok"),
        ));
    }

    public function indexSmtp()
    {
        if (!auth()->user()->isAbleTo('admin-settings-smtp-update') && !auth()->user()->isAbleTo('admin-settings-smtp-show')) {
            app()->abort(403);
        }
        $disabledForm = false;

        if (!auth()->user()->isAbleTo('admin-settings-smtp-update')) {
            $disabledForm = true;
        }

        $settingSmtp = SettingsServices::getSmtp();
        $setting = SettingsServices::getGeneral();

        $pageTitle = trans('settings/admin_lang.settings');
        $title = trans('settings/admin_lang.settings');
        $tab = 'tab_2';

        return view('settings.admin_smtp', compact('pageTitle', 'title', 'settingSmtp', 'setting', 'disabledForm', 'tab'));
    }

    public function updateSmtp(AdminSettingSmtpRequest $request)
    {
        if (!auth()->user()->isAbleTo('admin-settings-smtp-update')) {
            app()->abort(403);
        }

        $data = $request->except(['_token', '_method', 'proengsoft_jsvalidation']);

        $active_mails = 0;

        if (isset($request->MAIL_SEND_ACTIVE)) {
            $active_mails = $request->MAIL_SEND_ACTIVE;
        }
        $setting = Setting::smtp()->where("key", "MAIL_SEND_ACTIVE")->first();
        $setting->value = $active_mails;
        $setting->save();

        foreach ($data as $key => $value) {
            $setting = Setting::smtp()->where("key", $key)->first();

            if (!empty($setting)) {
                $setting->value = $value;
                $setting->save();
            }
        }

        return redirect()->to('/admin/settings-smtp')->with('success', trans('general/admin_lang.save_ok'));
    }
}

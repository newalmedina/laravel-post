<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSettingRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!auth()->user()->isAbleTo('admin-settings-update')) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'site_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'province_id' => 'required',
            'municipio_id' => 'required',
            'address' => 'required',
            'image' => 'nullable|image',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'site_name.required' => trans('settings/admin_lang.general_info_fields.site_name_required'),
            'email.required' => trans('settings/admin_lang.general_info_fields.email_required'),
            'email.email' => trans('settings/admin_lang.general_info_fields.email_invalid_format'),
            'province_id.required' => trans('settings/admin_lang.general_info_fields.province_id_required'),
            'municipio_id.required' => trans('settings/admin_lang.general_info_fields.municipio_id_required'),
            'address.required' => trans('settings/admin_lang.general_info_fields.address_required'),
            'image.image' => trans('settings/admin_lang.general_info_fields.image_format'),
            'image.mimes' => trans('settings/admin_lang.general_info_fields.image_mimes'),

        ];
    }
}

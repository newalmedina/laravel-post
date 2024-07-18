<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSettingSmtpRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!auth()->user()->isAbleTo('admin-settings-smtp-update')) {
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
            'MAIL_MAILER' => 'required',
            'MAIL_HOST' => 'required',
            'MAIL_FROM_ADDRESS' => 'required|email',
            'MAIL_PORT' => 'required',
            'MAIL_USERNAME' => 'required',
            'MAIL_ENCRYPTION' => 'required',
            'MAIL_FROM_NAME' => 'required',
            'MAIL_PASSWORD' => 'required',
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
            'MAIL_MAILER.required' => trans('settings/admin_smtp_lang.fields.MAIL_MAILER_required'),
            'MAIL_HOST.required' => trans('settings/admin_smtp_lang.fields.MAIL_HOST_required'),
            'MAIL_FROM_ADDRESS.required' => trans('settings/admin_smtp_lang.fields.MAIL_FROM_ADDRESS_required'),
            'MAIL_PORT.required' => trans('settings/admin_smtp_lang.fields.MAIL_PORT_required'),
            'MAIL_USERNAME.required' => trans('settings/admin_smtp_lang.fields.MAIL_USERNAME_required'),
            'MAIL_ENCRYPTION.required' => trans('settings/admin_smtp_lang.fields.MAIL_ENCRYPTION_required'),
            'MAIL_FROM_NAME.required' => trans('settings/admin_smtp_lang.fields.MAIL_FROM_NAME_required'),
            'MAIL_PASSWORD.required' => trans('settings/admin_smtp_lang.fields.MAIL_FROM_NAME_required'),


        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminProfilePersonalInfoRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user_id = auth()->user()->id;

        return [

            'user_profile.birthday' => 'required',
            'user_profile.identification' => 'required',
            'user_profile.phone' => 'required',
            'user_profile.gender' => 'required',
            'user_profile.province_id' => 'required',
            'user_profile.municipio_id' => 'required',
            'user_profile.address' => 'required',
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
            'user_profile.birthday.required' => trans('profile/admin_lang.fields.birthday_required'),
            'user_profile.identification.required' => trans('profile/admin_lang.fields.identification_required'),
            'user_profile.phone.required' => trans('profile/admin_lang.fields.phone_required'),
            'user_profile.gender.required' => trans('profile/admin_lang.fields.gender_required'),
            'user_profile.province_id.required' => trans('profile/admin_lang.fields.province_id_required'),
            'user_profile.municipio_id.required' => trans('profile/admin_lang.fields.municipio_id_required'),
            'user_profile.address.required' => trans('profile/admin_lang.fields.address_required'),
        ];
    }
}

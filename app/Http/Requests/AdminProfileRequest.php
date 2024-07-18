<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminProfileRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,' . $user_id,
            //'active' => 'required',
            'user_profile.first_name' => 'required',
            'user_profile.last_name' => 'required',
            // 'profile_image' => 'nullable|image',
            'password' => 'nullable|same:password_confirm|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
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
            'user_profile.first_name.required' => trans('profile/admin_lang.fields.first_name_required'),
            'user_profile.last_name.required' => trans('profile/admin_lang.fields.last_name_required'),
            'active.required' => trans('profile/admin_lang.fields.active_required'),
            'email.required' => trans('profile/admin_lang.fields.email_required'),
            'email.email' => trans('profile/admin_lang.fields.email_incorrect_format'),
            'email.unique' => trans('profile/admin_lang.fields.email_unique'),
            'password.required' => trans('profile/admin_lang.fields.password_required'),
            'password.same' => trans('profile/admin_lang.fields.password_confirmed'),
            'password.min' => trans('profile/admin_lang.fields.password_min'),
            'profile_image.image' => trans('profile/admin_lang.fields.photo_format'),
            'profile_image.mimes' => trans('profile/admin_lang.fields.photo_mimes'),
            
            'password.regex' => trans('profile/admin_lang.fields.password_regex'),
        ];
    }
}

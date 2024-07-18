<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FrontRegisterRequest extends FormRequest
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
        return [
            'user_profile.first_name' => 'required',
            'user_profile.last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
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
            'user_profile.first_name.required' => trans('auth/register/front_lang.fields.first_name_required'),
            'user_profile.last_name.required' => trans('auth/register/front_lang.fields.last_name_required'),
            'email.required' => trans('auth/register/front_lang.fields.email_required'),
            'email.email' => trans('auth/register/front_lang.fields.email_incorrect_format'),
            'email.unique' => trans('auth/register/front_lang.fields.email_unique'),
            'password.required' => trans('auth/register/front_lang.fields.password_required'),
            'password.confirmed' => trans('auth/register/front_lang.fields.password_confirmed'),
            'password.min' => trans('auth/register/front_lang.fields.password_min'),


        ];
    }
}

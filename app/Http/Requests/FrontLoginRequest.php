<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FrontLoginRequest extends FormRequest
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
            'password' => 'required',
            'email' => 'required|email',
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
            'email.required' => trans('auth/register/front_lang.fields.email_required'),
            'email.email' => trans('auth/register/front_lang.fields.email_incorrect_format'),

            'password.required' => trans('auth/register/front_lang.fields.password_required'),



        ];
    }
}

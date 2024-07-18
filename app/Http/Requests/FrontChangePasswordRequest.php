<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FrontChangePasswordRequest extends FormRequest
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
            
            'password' => 'required|same:password_confirm|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'password_old' => 'required',
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
           
            'password_old.required' => trans('auth/change_password/front_lang.password_old_required'),
            'password.required' => trans('auth/change_password/front_lang.password_required'),
            'password.same' => trans('auth/change_password/front_lang.password_confirmed'),
            'password.min' => trans('auth/change_password/front_lang.password_min'),          
            
            'password.regex' => trans('auth/change_password/front_lang.password_regex'),
        ];
    }
}

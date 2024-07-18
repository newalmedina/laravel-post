<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!auth()->user()->isAbleTo('admin-users-create') && !auth()->user()->isAbleTo('admin-users-update')) {
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
        $user_id = $this->route()->id ? $this->route()->id : null;
        return [
            'email' => 'required|email|unique:users,email,' . $user_id,
            'user_profile.first_name' => 'required',
            'user_profile.last_name' => 'required',

            'password' => 'nullable|same:password_confirm|min:8',
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
            'user_profile.first_name.required' => trans('users/admin_lang.fields.first_name_required'),
            'user_profile.last_name.required' => trans('users/admin_lang.fields.last_name_required'),
            'email.required' => trans('users/admin_lang.fields.email_required'),
            'password.same' => trans('users/admin_lang.fields.password_confirmed'),
            'password.regex' => trans('users/admin_lang.fields.password_regex'),

        ];
    }
}

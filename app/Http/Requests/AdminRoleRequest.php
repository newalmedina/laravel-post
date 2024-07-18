<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRoleRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!auth()->user()->isAbleTo('admin-roles-create') && !auth()->user()->isAbleTo('admin-roles-update')) {
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
        $role_id = $this->route()->id ? $this->route()->id : null;

        return [
            'slug' => 'nullable|unique:roles,slug,' . $role_id,
            'display_name' => 'required',
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
            'display_name.required' => trans('roles/admin_lang.fields.display_name_required'),
            'slug.unique' => trans('roles/admin_lang.fields.slug_unique'),

        ];
    }
}

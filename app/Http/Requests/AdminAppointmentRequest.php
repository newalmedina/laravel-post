<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminAppointmentRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (
            !auth()->user()->isAbleTo('admin-appointments-create')
            && !auth()->user()->isAbleTo('admin-appointments-update')

        ) {
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
            'start_at' => 'required',
            'hour' => 'required',
            'user_id' => 'required',
            'doctor_id' => 'required',
            'service_id' => 'required',
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
            'user_id.required' => trans('appointments/admin_lang.fields.user_id_required'),
            'doctor_id.required' => trans('appointments/admin_lang.fields.doctor_id_required'),
            'service_id.required' => trans('appointments/admin_lang.fields.service_id_required'),
            'start_at.required' => trans('appointments/admin_lang.fields.start_at_required'),
            'hour.required' => trans('appointments/admin_lang.fields.hour_required'),


        ];
    }
}

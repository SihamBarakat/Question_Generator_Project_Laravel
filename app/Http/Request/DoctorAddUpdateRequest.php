<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorAddUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'doctor_name' => 'required|max:30',
            'doctor_email' => 'required|email|unique:doctors,email',
            //'classroom' => ['required',Rule::exists('classrooms', 'id')],
            'doctor_phone'=> 'required|regex:/(0)[0-9]{10}/',
            'doctor_password' => 'required',
            
        
        ];
    }
}

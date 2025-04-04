<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentCreatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // เปลี่ยนเป็น false หากต้องการจำกัดสิทธิ์การเข้าถึง
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'student_number' => 'required|string|max:20|unique:students,student_number',
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'กรุณากรอกชื่อ',
            'name.string' => 'ชื่อต้องเป็นตัวอักษร',
            'name.max' => 'ชื่อต้องไม่เกิน 255 ตัวอักษร',

            'student_number.required' => 'กรุณากรอกรหัสนักศึกษา',
            'student_number.string' => 'รหัสนักศึกษาต้องเป็นตัวอักษร',
            'student_number.max' => 'รหัสนักศึกษาต้องไม่เกิน 20 ตัวอักษร',
            'student_number.unique' => 'รหัสนักศึกษานี้ถูกใช้งานแล้ว กรุณาใช้รหัสอื่น',
        ];
    }
}

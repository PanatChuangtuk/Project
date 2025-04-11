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
        $id = $this->route('id');
        return [
            'email' => 'required|string|email|max:255|unique:student,email,' . $id,
            'student_number' => 'required|string|max:20|unique:student,student_number,' . $id,
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
            'email.required' => 'กรุณากรอกอีเมล',
            'email.email' => 'กรุณากรอกอีเมลที่ถูกต้อง',
            'email.unique' => 'อีเมลนี้มีผู้ใช้งานแล้ว',
            'student_number.required' => 'กรุณากรอกรหัสนักศึกษา',
            'student_number.string' => 'รหัสนักศึกษาต้องเป็นตัวอักษร',
            'student_number.max' => 'รหัสนักศึกษาต้องไม่เกิน 20 ตัวอักษร',
            'student_number.unique' => 'รหัสนักศึกษานี้ถูกใช้งานแล้ว กรุณาใช้รหัสอื่น',
        ];
    }
}

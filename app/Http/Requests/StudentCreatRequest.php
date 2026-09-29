<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_phone' => 'nullable|digits_between:9,10',
            'status' => 'nullable|boolean',
            'adviser_id' => [
                'nullable',
                'integer',
                Rule::exists('adviser', 'id')->whereNull('deleted_at'),
            ],
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
            'first_name.required' => 'กรุณากรอกชื่อ',
            'first_name.max' => 'ชื่อต้องไม่เกิน 255 ตัวอักษร',
            'last_name.required' => 'กรุณากรอกนามสกุล',
            'last_name.max' => 'นามสกุลต้องไม่เกิน 255 ตัวอักษร',
            'mobile_phone.digits_between' => 'เบอร์โทรศัพท์ต้องเป็นตัวเลข 9-10 หลัก',
            'adviser_id.exists' => 'ไม่พบอาจารย์ที่ปรึกษานี้ในระบบ',
        ];
    }
}

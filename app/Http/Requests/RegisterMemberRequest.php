<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $id = $this->route('id');
        return [
            // 'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:member' .
                $id,
            'password' => 'required|string|min:8|confirmed',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'imageData' => 'required',
            'student_id' => 'required|integer',
            'adviser_id' => 'required|integer',
            'mobile_phone' => 'required|string|min:10|max:15|regex:/^[0-9]+$/',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            // 'username.required' => 'กรุณากรอกชื่อผู้ใช้',
            // 'username.max' => 'ชื่อผู้ใช้ต้องไม่เกิน 255 ตัวอักษร',
            'email.required' => 'กรุณากรอกอีเมล',
            'email.email' => 'กรุณากรอกอีเมลที่ถูกต้อง',
            'email.unique' => 'อีเมลนี้มีผู้ใช้งานแล้ว',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร',
            'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
            'first_name.required' => 'กรุณากรอกชื่อจริง',
            'last_name.required' => 'กรุณากรอกนามสกุล',
            'student_id.required' => 'กรุณาเลือกรหัสนักศึกษา',
            'adviser_id.required' => 'กรุณาเลือกอาจารย์ที่ปรึกษา',
            'mobile_phone.required' => 'กรุณากรอกเบอร์โทรศัพท์',
            'mobile_phone.min' => 'เบอร์โทรศัพท์ต้องมีอย่างน้อย 10 หลัก',
            'mobile_phone.max' => 'เบอร์โทรศัพท์ต้องไม่เกิน 15 หลัก',
            'mobile_phone.regex' => 'เบอร์โทรศัพท์ต้องเป็นตัวเลขเท่านั้น',
            'imageData.required' => '*กรุณาถ่ายภาพ*',
        ];
    }
}

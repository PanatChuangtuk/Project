<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class MemberCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // คุณสามารถปรับเปลี่ยนให้เหมาะสมกับความต้องการของโปรเจ็กต์
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        dd($request->all());
        return [
            'email' => 'required|string|email|max:255|unique:member,email',
            'mobile_phone' => 'required',
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
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
            'email.required' => 'กรุณากรอกอีเมล์',
            'email.email' => 'กรุณากรอกอีเมล์ให้ถูกต้อง',
            'email.max' => 'อีเมล์ต้องไม่เกิน 255 ตัวอักษร',
            'email.unique' => 'อีเมล์นี้ถูกใช้งานแล้ว',
            'mobile_phone' => 'กรุณากรอกเบอร์โทรศัพท์มือถือ',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.string' => 'รหัสผ่านต้องเป็นตัวอักษร',
            'password.min' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร',
            'password.confirmed' => 'การยืนยันรหัสผ่านไม่ตรงกัน',
            'image.required' => 'กรุณาอัพโหลดภาพ',
            'image.mimes' => 'ภาพที่อัพโหลดต้องเป็นไฟล์ประเภท jpeg, png, jpg',
            'image.max' => 'ขนาดไฟล์ภาพต้องไม่เกิน 2MB',
        ];
    }
}

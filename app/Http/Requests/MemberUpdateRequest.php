<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberUpdateRequest extends FormRequest
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
    public function rules()
    {
        $id = $this->route('id');
        return [
            'email' => 'required|string|email|max:255|unique:member,email,' . $id,
            'mobile_phone' => 'required|digits_between:9,10',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            // เว้นว่างได้ = ไม่เปลี่ยนรหัสผ่าน แต่ถ้ากรอกต้องผ่านเงื่อนไขเดียวกับตอนสร้าง
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'student_id' => [
                'nullable',
                'integer',
                Rule::exists('student', 'id')->whereNull('deleted_at'),
                Rule::unique('member_infomation', 'student_id')->ignore($id, 'member_id')->whereNull('deleted_at'),
            ],
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
            'email.required' => 'กรุณากรอกอีเมล์',
            'email.email' => 'กรุณากรอกอีเมล์ให้ถูกต้อง',
            'email.max' => 'อีเมล์ต้องไม่เกิน 255 ตัวอักษร',
            'email.unique' => 'อีเมล์นี้ถูกใช้งานแล้ว',
            'mobile_phone.required' => 'กรุณากรอกเบอร์โทรศัพท์มือถือ',
            'mobile_phone.digits_between' => 'เบอร์โทรศัพท์ต้องเป็นตัวเลข 9-10 หลัก',
            'first_name.required' => 'กรุณากรอกชื่อ',
            'first_name.max' => 'ชื่อต้องไม่เกิน 255 ตัวอักษร',
            'last_name.required' => 'กรุณากรอกนามสกุล',
            'last_name.max' => 'นามสกุลต้องไม่เกิน 255 ตัวอักษร',
            'password.string' => 'รหัสผ่านต้องเป็นตัวอักษร',
            'password.min' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร',
            'password.confirmed' => 'การยืนยันรหัสผ่านไม่ตรงกัน',
            'student_id.exists' => 'ไม่พบรหัสนักศึกษานี้ในระบบ',
            'student_id.unique' => 'รหัสนักศึกษานี้ถูกผูกกับบัญชีผู้ใช้อื่นแล้ว',
            'adviser_id.exists' => 'ไม่พบอาจารย์ที่ปรึกษานี้ในระบบ',
            'image.image' => 'ไฟล์ที่อัพโหลดต้องเป็นรูปภาพ',
            'image.mimes' => 'ภาพที่อัพโหลดต้องเป็นไฟล์ประเภท jpeg, png, jpg',
            'image.max' => 'ขนาดไฟล์ภาพต้องไม่เกิน 2MB',
        ];
    }
}

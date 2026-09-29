<?php

namespace App\Http\Requests;

use App\Models\{Member, Student};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\{Rule, Validator};

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
        return [
            'password' => 'required|string|min:8|confirmed',
            'imageData' => 'required|file|image|mimes:jpeg,png,jpg,webp|max:10240',
            'student_id' => [
                'required',
                'integer',
                // ต้องเป็นนักศึกษาที่เปิดใช้งาน ตรงกับที่ /api/get-user แสดงให้เลือก
                Rule::exists('student', 'id')->whereNull('deleted_at')->where('status', 1),
                Rule::unique('member_infomation', 'student_id')->whereNull('deleted_at'),
            ],
        ];
    }

    /**
     * อีเมลของบัญชีมาจากข้อมูลนักศึกษา จึงต้องตรวจว่ามีอีเมลและยังไม่ถูกใช้
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->has('student_id')) {
                    return;
                }

                $email = Student::whereKey($this->input('student_id'))->value('email');

                if (!$email) {
                    $validator->errors()->add('student_id', 'นักศึกษานี้ยังไม่มีอีเมลในระบบ กรุณาติดต่อเจ้าหน้าที่');
                } elseif (Member::where('email', $email)->exists()) {
                    $validator->errors()->add('student_id', 'อีเมลของนักศึกษานี้ถูกใช้สมัครสมาชิกแล้ว');
                }
            },
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร',
            'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
            'student_id.required' => 'กรุณาเลือกรหัสนักศึกษา',
            'student_id.integer' => 'รหัสนักศึกษาไม่ถูกต้อง',
            'student_id.exists' => 'ไม่พบรหัสนักศึกษานี้ หรือยังไม่เปิดใช้งาน',
            'student_id.unique' => 'รหัสนักศึกษานี้ได้สมัครสมาชิกแล้ว',
            'imageData.required' => '*กรุณาถ่ายภาพ หรือ อัปโหลดรูปภาพ*',
            'imageData.file' => '*กรุณาถ่ายภาพ หรือ อัปโหลดรูปภาพ*',
            'imageData.image' => 'ไฟล์ที่อัปโหลดต้องเป็นรูปภาพ',
            'imageData.mimes' => 'รูปภาพต้องเป็นไฟล์ประเภท jpeg, png, jpg, webp',
            'imageData.max' => 'ขนาดไฟล์รูปภาพต้องไม่เกิน 10MB',
        ];
    }
}

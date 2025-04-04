<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // ให้สิทธิ์ในการเข้าถึงการอัปเดต
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // หาค่าของ $id จาก URL (ถ้าใช้ใน Controller เช่น {id} สำหรับอัปเดต)
        $id = $this->route('id');

        return [
            'name' => 'required|string|max:255',
            'student_number' => 'required|string|max:20|unique:student,student_number,' . $id, // ยกเว้นตรวจสอบตัวเอง
        ];
    }

    /**
     * Get the validation error messages that apply to the request.
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

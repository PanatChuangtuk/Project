<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

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
    public function rules(Request $request)
    {
        // หาค่าของ $id จาก URL (ถ้าใช้ใน Controller เช่น {id} สำหรับอัปเดต)
        $id = $this->route('id');
        // dd($request->all());
        return [
            'email' => 'required|string|email|max:255|unique:student,email,' . $id,
            'student_number' => 'required|string|max:20|unique:student,student_number,' . $id,
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

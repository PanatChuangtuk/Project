<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdviserCreateRequest extends FormRequest
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
        return [
            'titles_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
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
            'titles_name.required' => 'กรุณาเลือกคำนำหน้าชื่ออาจารย์ที่ปรึกษา',
            'first_name.required' => 'กรุณากรอกชื่อ',
            'last_name.required' => 'กรุณากรอกนามสกุล',
            'titles_name.max' => 'คำนำหน้าชื่อต้องไม่เกิน 255 ตัวอักษร',
            'first_name.max' => 'ชื่อต้องไม่เกิน 255 ตัวอักษร',
            'last_name.max' => 'นามสกุลต้องไม่เกิน 255 ตัวอักษร',
            'image.image' => 'ไฟล์ที่อัพโหลดต้องเป็นรูปภาพ',
            'image.mimes' => 'ภาพที่อัพโหลดต้องเป็นไฟล์ประเภท jpeg, png, jpg, gif, webp',
            'image.max' => 'ขนาดไฟล์ภาพต้องไม่เกิน 2MB',
        ];
    }
}

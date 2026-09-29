<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EquipmentItemUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            // ไม่ส่งมา = ใช้หมวดหมู่เดิม
            'category_id' => [
                'nullable',
                'integer',
                Rule::exists('equipment_category', 'id')->whereNull('deleted_at'),
            ],
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
            'name.required' => 'กรุณากรอกชื่ออุปกรณ์',
            'name.max' => 'ชื่ออุปกรณ์ต้องไม่เกิน 255 ตัวอักษร',
            'category_id.required' => 'กรุณาเลือกหมวดหมู่อุปกรณ์',
            'category_id.exists' => 'ไม่พบหมวดหมู่อุปกรณ์นี้ในระบบ',
            'image.image' => 'ไฟล์ที่อัพโหลดต้องเป็นรูปภาพ',
            'image.mimes' => 'ภาพที่อัพโหลดต้องเป็นไฟล์ประเภท jpeg, png, jpg, gif, webp',
            'image.max' => 'ขนาดไฟล์ภาพต้องไม่เกิน 2MB',
        ];
    }
}

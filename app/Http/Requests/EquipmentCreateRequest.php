<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EquipmentCreateRequest extends FormRequest
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
            'item_id' => [
                'required',
                'integer',
                Rule::exists('equipment_item', 'id')->whereNull('deleted_at'),
            ],
            'equipment_number' => 'nullable|string|max:255',
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
            'item_id.required' => 'กรุณาเลือกรายการอุปกรณ์',
            'item_id.exists' => 'ไม่พบรายการอุปกรณ์นี้ในระบบ',
            'equipment_number.max' => 'เลขครุภัณฑ์ต้องไม่เกิน 255 ตัวอักษร',
            'image.image' => 'ไฟล์ที่อัพโหลดต้องเป็นรูปภาพ',
            'image.mimes' => 'ภาพที่อัพโหลดต้องเป็นไฟล์ประเภท jpeg, png, jpg, gif, webp',
            'image.max' => 'ขนาดไฟล์ภาพต้องไม่เกิน 2MB',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
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
    public function rules(Request $request)
    {
        return [
            'titles_name' => 'nullable|string|max:255',
            'first_name' => 'required',
            'last_name' => 'required'
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return ['titles_name.required' => 'กรุณาเลือกคำนำหน้าชื่ออาจารย์ที่ปรึกษา', 'first_name.required' => 'กรุณากรอกชื่อ', 'last_name.required' => 'กรุณากรอกนามสกุล'];
    }
}

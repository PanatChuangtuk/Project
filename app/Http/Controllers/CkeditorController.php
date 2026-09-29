<?php

namespace App\Http\Controllers;

use Illuminate\Http\{Request, JsonResponse};
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class CkeditorController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(): View
    {
        return view('ckeditor');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function upload(Request $request): JsonResponse
    {
        // ไฟล์ถูกเก็บในโฟลเดอร์ public จึงต้องรับเฉพาะรูปภาพ ห้ามรับไฟล์ประเภทอื่น (เช่น .php, .svg)
        $validator = Validator::make($request->all(), [
            'upload' => 'required|file|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'uploaded' => 0,
                'error' => ['message' => 'รองรับเฉพาะไฟล์รูปภาพ jpeg, png, jpg, gif, webp ขนาดไม่เกิน 5MB'],
            ], 422);
        }

        $originName = $request->file('upload');
        $fileName = pathinfo($originName->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = preg_replace('/[^A-Za-z0-9_-]/', '', $fileName) ?: 'image';
        $newFileName  = $fileName . '_' . time() . '.' . $originName->extension();

        $originName->storeAs('ckupload/', $newFileName, 'public');

        $url = asset('upload/ckupload/' . $newFileName);

        return response()->json(['fileName' => $newFileName, 'uploaded' => 1, 'url' => $url]);
    }
}

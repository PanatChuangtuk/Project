<?php

// app/Http/Controllers/ImageController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    // แสดงฟอร์มจับภาพ
    public function showCaptureForm()
    {
        return view('capture');
    }

    // บันทึกภาพที่ถ่ายจากกล้อง
    public function saveImage(Request $request)
    {
        if ($request->has('imageData')) {
            $imageData = $request->input('imageData');
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = base64_decode($imageData);
            $fileName = 'captured_' . time() . '.png';
            Storage::disk('public')->put('images/' . $fileName, $imageData);
            return back()->with('message', 'Image saved successfully!');
        }

        return back()->with('error', 'No image captured!');
    }
}

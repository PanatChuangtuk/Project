<?php

// app/Http/Controllers/ImageController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function showCaptureForm()
    {
        return view('capture');
    }

    public function saveImage(Request $request)
    {
        $imageData = $request->input('imageData');

        if (!is_string($imageData) || !str_starts_with($imageData, 'data:image/png;base64,')) {
            return back()->with('error', 'No image captured!');
        }

        // ตรวจว่า decode ได้จริง ขนาดไม่เกิน 5MB และเป็นไฟล์ PNG จริง ก่อนบันทึก
        $imageData = base64_decode(substr($imageData, strlen('data:image/png;base64,')), true);
        if (
            $imageData === false ||
            strlen($imageData) > 5 * 1024 * 1024 ||
            (@getimagesizefromstring($imageData)['mime'] ?? null) !== 'image/png'
        ) {
            return back()->with('error', 'Invalid image!');
        }

        $fileName = 'captured_' . time() . '.png';
        Storage::disk('public')->put('images/' . $fileName, $imageData);
        return back()->with('message', 'Image saved successfully!');
    }
}

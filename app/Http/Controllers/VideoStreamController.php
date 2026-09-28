<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoStreamController extends Controller
{
    private const CHUNK_SIZE = 1024 * 1024;

    public function stream(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | หา Guide และไฟล์จริง
        |--------------------------------------------------------------------------
        */

        $guide = Guide::findOrFail($id);

        if (!$guide->link_video) {
            abort(404, 'ไม่พบวิดีโอ');
        }

        $disk = Storage::disk('public');

        if (!$disk->exists($guide->link_video)) {
            abort(404, 'ไม่พบไฟล์วิดีโอ');
        }

        $path = $disk->path($guide->link_video);
        $size = is_file($path) ? filesize($path) : false;

        if (!$size) {
            abort(404, 'ไฟล์วิดีโอไม่ถูกต้อง');
        }

        $mime = mime_content_type($path) ?: 'video/mp4';

        /*
        |--------------------------------------------------------------------------
        | คำนวณช่วง byte (ไม่มี Range = ส่งทั้งไฟล์)
        |--------------------------------------------------------------------------
        */

        $range = $request->header('Range');
        $start = 0;
        $end = $size - 1;

        if ($range) {
            if (!preg_match('/bytes=(\d*)-(\d*)/', $range, $matches) || ($matches[1] === '' && $matches[2] === '')) {
                return $this->rangeNotSatisfiable($size);
            }

            [, $rangeStart, $rangeEnd] = $matches;

            if ($rangeStart === '') {
                // bytes=-500000 (suffix)
                $suffixLength = min((int) $rangeEnd, $size);

                if ($suffixLength <= 0) {
                    return $this->rangeNotSatisfiable($size);
                }

                $start = $size - $suffixLength;
            } else {
                // bytes=500000- หรือ bytes=500000-1000000
                $start = (int) $rangeStart;

                if ($rangeEnd !== '') {
                    $end = min((int) $rangeEnd, $size - 1);
                }
            }

            if ($start >= $size || $start > $end) {
                return $this->rangeNotSatisfiable($size);
            }
        }

        $length = $end - $start + 1;

        $stream = fopen($path, 'rb');

        if (!$stream) {
            abort(500, 'ไม่สามารถเปิดไฟล์วิดีโอได้');
        }

        fseek($stream, $start);

        $headers = [
            'Content-Type' => $mime,
            'Content-Length' => $length,
            'Accept-Ranges' => 'bytes',
            'Content-Disposition' => 'inline',
            'Cache-Control' => 'private, max-age=3600',
            'X-Content-Type-Options' => 'nosniff',
            'X-Accel-Buffering' => 'no',
        ];

        if ($range) {
            $headers['Content-Range'] = "bytes {$start}-{$end}/{$size}";
        }

        return response()->stream(function () use ($stream, $length) {
            $remaining = $length;

            while ($remaining > 0 && !feof($stream)) {
                $buffer = fread($stream, min(self::CHUNK_SIZE, $remaining));

                if ($buffer === false || $buffer === '') {
                    break;
                }

                echo $buffer;
                flush();

                $remaining -= strlen($buffer);
            }

            fclose($stream);
        }, $range ? 206 : 200, $headers);
    }

    private function rangeNotSatisfiable(int $size)
    {
        return response('', 416, [
            'Content-Range' => "bytes */{$size}",
            'Accept-Ranges' => 'bytes',
        ]);
    }
}

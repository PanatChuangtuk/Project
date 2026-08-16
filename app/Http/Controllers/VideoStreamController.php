<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Contrclsoller;
use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoStreamController extends Controller
{
    public function stream(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | หา Guide
        |--------------------------------------------------------------------------
        */

        $guide = Guide::findOrFail($id);

        if (!$guide->link_video) {
            abort(404, 'ไม่พบวิดีโอ');
        }

        /*
        |--------------------------------------------------------------------------
        | หาไฟล์จริง
        |--------------------------------------------------------------------------
        */

        $disk = Storage::disk('public');

        if (!$disk->exists($guide->link_video)) {
            abort(404, 'ไม่พบไฟล์วิดีโอ');
        }

        $path = $disk->path($guide->link_video);

        if (!is_file($path)) {
            abort(404, 'ไม่พบไฟล์วิดีโอ');
        }

        /*
        |--------------------------------------------------------------------------
        | File information
        |--------------------------------------------------------------------------
        */

        $size = filesize($path);

        if ($size === false || $size <= 0) {
            abort(404, 'ไฟล์วิดีโอไม่ถูกต้อง');
        }

        $mime = mime_content_type($path);

        if (!$mime) {
            $mime = 'video/mp4';
        }

        /*
        |--------------------------------------------------------------------------
        | Range Request
        |--------------------------------------------------------------------------
        */

        $range = $request->header('Range');

        /*
        |--------------------------------------------------------------------------
        | ไม่มี Range
        |--------------------------------------------------------------------------
        */

        if (!$range) {

            $stream = fopen($path, 'rb');

            if (!$stream) {
                abort(500, 'ไม่สามารถเปิดไฟล์วิดีโอได้');
            }

            return response()->stream(
                function () use ($stream) {

                    while (!feof($stream)) {

                        $buffer = fread(
                            $stream,
                            1024 * 1024
                        );

                        if ($buffer === false) {
                            break;
                        }

                        echo $buffer;

                        flush();
                    }

                    fclose($stream);
                },
                200,
                [
                    'Content-Type' => $mime,

                    'Content-Length' => $size,

                    'Accept-Ranges' => 'bytes',

                    'Content-Disposition' => 'inline',

                    'Cache-Control' => 'public, max-age=3600',

                    'X-Content-Type-Options' => 'nosniff',

                    'X-Accel-Buffering' => 'no',
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | ตรวจสอบ Range
        |--------------------------------------------------------------------------
        */

        if (!preg_match(
            '/bytes=(\d*)-(\d*)/',
            $range,
            $matches
        )) {

            return response('', 416, [
                'Content-Range' => "bytes */{$size}",
                'Accept-Ranges' => 'bytes',
            ]);
        }

        $rangeStart = $matches[1];
        $rangeEnd   = $matches[2];

        /*
        |--------------------------------------------------------------------------
        | bytes=-500000
        |--------------------------------------------------------------------------
        */

        if ($rangeStart === '' && $rangeEnd !== '') {

            $suffixLength = (int) $rangeEnd;

            if ($suffixLength <= 0) {

                return response('', 416, [
                    'Content-Range' => "bytes */{$size}",
                    'Accept-Ranges' => 'bytes',
                ]);
            }

            if ($suffixLength > $size) {
                $suffixLength = $size;
            }

            $start = $size - $suffixLength;
            $end = $size - 1;
        }

        /*
        |--------------------------------------------------------------------------
        | bytes=500000-
        |--------------------------------------------------------------------------
        */

        elseif ($rangeStart !== '' && $rangeEnd === '') {

            $start = (int) $rangeStart;
            $end = $size - 1;
        }

        /*
        |--------------------------------------------------------------------------
        | bytes=500000-1000000
        |--------------------------------------------------------------------------
        */

        elseif (
            $rangeStart !== '' &&
            $rangeEnd !== ''
        ) {

            $start = (int) $rangeStart;
            $end = (int) $rangeEnd;
        }

        else {

            return response('', 416, [
                'Content-Range' => "bytes */{$size}",
                'Accept-Ranges' => 'bytes',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ป้องกัน Range ผิด
        |--------------------------------------------------------------------------
        */

        if (
            $start < 0 ||
            $start >= $size ||
            $start > $end
        ) {

            return response('', 416, [
                'Content-Range' => "bytes */{$size}",
                'Accept-Ranges' => 'bytes',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ป้องกัน End เกินไฟล์
        |--------------------------------------------------------------------------
        */

        if ($end >= $size) {
            $end = $size - 1;
        }

        /*
        |--------------------------------------------------------------------------
        | จำนวน Byte
        |--------------------------------------------------------------------------
        */

        $length = $end - $start + 1;

        /*
        |--------------------------------------------------------------------------
        | เปิดไฟล์
        |--------------------------------------------------------------------------
        */

        $stream = fopen($path, 'rb');

        if (!$stream) {
            abort(
                500,
                'ไม่สามารถเปิดไฟล์วิดีโอได้'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | กระโดดไปยังตำแหน่งที่ Browser ขอ
        |--------------------------------------------------------------------------
        */

        fseek($stream, $start);

        /*
        |--------------------------------------------------------------------------
        | HTTP 206 Partial Content
        |--------------------------------------------------------------------------
        */

        return response()->stream(
            function () use (
                $stream,
                $length
            ) {

                $remaining = $length;

                while (
                    $remaining > 0 &&
                    !feof($stream)
                ) {

                    $chunkSize = min(
                        1024 * 1024,
                        $remaining
                    );

                    $buffer = fread(
                        $stream,
                        $chunkSize
                    );

                    if ($buffer === false) {
                        break;
                    }

                    $bufferLength = strlen($buffer);

                    if ($bufferLength === 0) {
                        break;
                    }

                    echo $buffer;

                    flush();

                    $remaining -= $bufferLength;
                }

                fclose($stream);
            },
            206,
            [
                'Content-Type' => $mime,

                'Content-Length' => $length,

                'Content-Range' =>
                    "bytes {$start}-{$end}/{$size}",

                'Accept-Ranges' => 'bytes',

                'Content-Disposition' => 'inline',

                'Cache-Control' => 'public, max-age=3600',

                'X-Content-Type-Options' => 'nosniff',

                'X-Accel-Buffering' => 'no',
            ]
        );
    }
}
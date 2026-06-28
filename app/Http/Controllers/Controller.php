<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;

abstract class Controller
{
    public function uploadsImage($file, $path)
    {
        $filename = substr(Str::uuid(), 0, 5) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('file/' . $path . '/', $filename, 'public');
        return $filename;
    }
    public function uploadsImageUser($file)
    {
        // dd($file);
        $filename = substr(Str::uuid(), 0, 5) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('images/', $filename, 'public');
        return $filename;
    }
    protected function formatThaiDate($date)
    {
        $date = Carbon::parse($date);
        $months = [
            "",
            "มกราคม",
            "กุมภาพันธ์",
            "มีนาคม",
            "เมษายน",
            "พฤษภาคม",
            "มิถุนายน",
            "กรกฎาคม",
            "สิงหาคม",
            "กันยายน",
            "ตุลาคม",
            "พฤศจิกายน",
            "ธันวาคม"
        ];

        return $date->day . ' ' . $months[$date->month] . ' ' . ($date->year + 543);
    }
}

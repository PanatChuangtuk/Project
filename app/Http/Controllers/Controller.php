<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

abstract class Controller
{
    public function uploadsImage($file, $path)
    {
        $filename = substr(Str::uuid(), 0, 5) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('file/' . $path . '/', $filename, 'public');
        return $filename;
    }
}

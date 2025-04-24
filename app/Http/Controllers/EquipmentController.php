<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\{Auth, DB, Validator, Hash};
use Illuminate\Http\Request;
use App\Models\{EquipmentCategory, EquipmentItem};

class EquipmentController extends MainController
{
    public function index()
    {
        $equipment = EquipmentCategory::where('status', 1)->get();

        return view('equipment', compact('equipment'));
    }
}

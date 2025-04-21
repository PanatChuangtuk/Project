<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\{Auth, DB, Validator, Hash};
use Illuminate\Http\Request;
use App\Models\{Member, MemberInfo};

class EquipmentController extends MainController
{
    private $main_menu = 'equipment';
    public function index()
    {
        $main_menu = $this->main_menu;
        return view('equipment', compact('main_menu'));
    }
}

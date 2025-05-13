<?php

namespace App\Http\Controllers\Administrator;

use App\Models\{RecommendEquipment};
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    private $main_menu = 'dashboard';
    public function index()
    {
        $recommendations = RecommendEquipment::with('member.info')->latest()->paginate(10);
        $main_menu = $this->main_menu;
        return view('administrator.dashboard', compact('main_menu', 'recommendations'));
    }
}

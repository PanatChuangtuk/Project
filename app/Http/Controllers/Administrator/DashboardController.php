<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    private $main_menu = 'dashboard';
    public function index()
    {
        $main_menu = $this->main_menu;
        return view('administrator.dashboard', compact('main_menu'));
    }
}

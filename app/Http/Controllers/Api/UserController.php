<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;

class UserController extends Controller
{
    public function getUser()
    {
        $user = Member::find(1);
        // dd($user);
        return response()->json(['results' => $user]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\{Social, Contact, Language, Member};
use Illuminate\Support\Facades\{View, Auth};

class MainController extends Controller
{
    function __construct()
    {
        $userId = Auth::guard('member')->user()->id ?? null;
        $profileUser = Member::join('member_infomation', 'member_infomation.member_id', '=', 'member.id')
            ->select('member.*', 'member_infomation.*')
            ->where('member.id', $userId)
            ->first();
        // View::share('cart',  $cart);
        // View::share('social', $social);
        // View::share('contact', $contact);
        View::share('profileUser', $profileUser);
    }
}

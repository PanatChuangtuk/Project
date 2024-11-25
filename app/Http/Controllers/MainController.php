<?php

namespace App\Http\Controllers;

use App\Models\{Social, Contact, Language, Member};
use Illuminate\Support\Facades\{View, Auth};

class MainController extends Controller
{
    function __construct()
    {
        // $locale = app()->getLocale();
        // $language = Language::where('code', $locale)->first();
        // $contact = Contact::select(
        //     'contact.*',
        //     'contact_content.*',
        //     'contact_content.name as content_name',
        // )
        //     ->where('contact.id', 1)
        //     ->join('contact_content', 'contact_content.contact_id', '=', 'contact.id')
        //     ->where('contact_content.language_id', $language->id)->first();
        // $social = Social::select('social.*')->where('status', true)->get();
        // $userId = Auth::guard('member')->user()->id ?? null;
        // $profileUser = Member::join('member_infomation', 'member_infomation.member_id', '=', 'member.id')
        //     ->select('member.*', 'member_infomation.*')
        //     ->where('member.id', $userId)
        //     ->first();
        // $cart = session()->get('cart', []);
        // View::share('cart',  $cart);
        // View::share('social', $social);
        // View::share('contact', $contact);
        // View::share('profileUser', $profileUser);
    }
}

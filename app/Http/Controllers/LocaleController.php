<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\{Session, App};

class LocaleController extends Controller
{
    public function setLocale($lang)
    {
        if (in_array($lang, ['en', 'th'])) {
            App::setLocale($lang);
            Session::put('locale', $lang);
        }
        $currentUrl = url()->previous();
        $newUrl = preg_replace('/\/(en|th)\//', "/{$lang}/", $currentUrl);
        return redirect()->to($newUrl);
    }
}

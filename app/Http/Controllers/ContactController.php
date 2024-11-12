<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Language;


class ContactController extends MainController
{
    function contactIndex()
    {
        $locale = app()->getLocale();

        $language = Language::where('code', $locale)->first();

        $contact = Contact::select(
            'contact.*',
            'contact_content.*',
            'contact_content.name as content_name',
        )
            ->where('contact.id', 1)
            ->join('contact_content', 'contact_content.contact_id', '=', 'contact.id')
            ->where('contact_content.language_id', $language->id)->first();

        // dd($contact);
        return view('contact', compact('contact'));
    }
}

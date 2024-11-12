<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;

class NotificationController extends MainController
{
    public function notificationIndex()
    {
        return view('notification');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;

class CouponController extends MainController
{
    public function couponIndex()
    {
        return view('my-coupon');
    }

    public function pointIndex()
    {
        return view('my-point');
    }
}

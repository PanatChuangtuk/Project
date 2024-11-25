<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use App\Models\{Order, OrdersProduct};
use Illuminate\Support\Facades\Auth;

class ReviewsController extends MainController
{
    public function reviewsIndex()
    {
        return view('reviews');
    }
    public function myReviewIndex()
    {
        $userId = Auth::guard('member')->user()->id;
        $orders = Order::where('member_id', $userId)->orderBy('id', 'desc')->get();
        return view('my-reviews');
    }
}

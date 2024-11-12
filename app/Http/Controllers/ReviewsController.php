<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;

class ReviewsController extends MainController
{
    public function reviewsIndex()
    {
        return view('reviews');
    }
    public function myReviewIndex()
    {
        return view('my-reviews');
    }
    // public function edit($lang, $id) {}

    // public function add() {}

    // public function submit(Request $request) {}

    // public function update(Request $request, $lang, $id) {}
}

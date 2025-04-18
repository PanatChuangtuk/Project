<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserApiController;


Route::controller(UserApiController::class)->group(function () {
    Route::get('/get-user', 'getUser');
    Route::get('/get-adviser', 'getAdviser');
});

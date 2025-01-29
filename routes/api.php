<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;


Route::controller(UserController::class)->group(function () {
    Route::get('/get-user', 'getUser');
});

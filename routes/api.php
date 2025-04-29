<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\{UserApiController, EquipmentApiController};


Route::controller(UserApiController::class)->group(function () {
    Route::get('/get-user', 'getUser');
    Route::get('/get-adviser', 'getAdviser');
});

Route::controller(EquipmentApiController::class)->group(function () {
    Route::get('/get-type', 'getType');
    Route::get('/get-item', 'getItem');
    Route::get('/get-equipment', 'getEquipment');
});

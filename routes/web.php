<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{

    LoginController,
    RegisterController,
    ProfileController,
    EquipmentController,
    ImageController,
    EquipmentListController,
    BorrowController,
    ReturnController,
    TaskController
};

require base_path('routes/admin.php');
require base_path('routes/api.php');


Route::get('login', [LoginController::class, 'loginIndex'])->name('login');
Route::post('login', [LoginController::class, 'submit'])->name('login.submit');
Route::get('/run-hourly-task', [TaskController::class, 'hourlyTask']);


Route::get('/capture', [ImageController::class, 'showCaptureForm']);
Route::post('/save-image', [ImageController::class, 'saveImage'])->name('save.image');

// Route::get('/student/dashboard', [MemberController::class, 'studentDashboard'])->name('student.dashboard');


Route::get('register', [RegisterController::class, 'registerIndex'])->name('register');
Route::post('register/submit', [RegisterController::class, 'submit'])->name('register.submit');
Route::middleware(['auth:member'])->group(function () {
    Route::get('profile', [ProfileController::class, 'profileIndex'])->name('profile');
    Route::post('profile', [ProfileController::class, 'submit'])->name('profile.submit');
    Route::get('equipment', [EquipmentController::class, 'index'])->name('equipment');
    Route::get('equipment-list', [EquipmentListController::class, 'equipmentListIndex'])->name('equipment.list');
    Route::post('equipment-list/cart', [EquipmentListController::class, 'equipmentCart'])->name('equipment.list.cart');
    Route::get('borrow-cart', [BorrowController::class, 'borrow'])->name('borrow.cart');
    Route::get('return', [ReturnController::class, 'index'])->name('return.index');
    Route::post('return-equipment/{id}', [ReturnController::class, 'returnEquipment'])->name('return.equipment');
    Route::post('borrow/submit', [BorrowController::class, 'submit'])->name('borrow.submit');
    Route::post('logout', [ProfileController::class, 'logout'])->name('logout');
    Route::post('/equipment/update', [EquipmentController::class, 'update'])->name('equipment.update');
});
// Route::get('/', function () {
//     return redirect(app()->getLocale() . '/ ');
// })->where('any', '.*');

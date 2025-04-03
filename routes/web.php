<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{

    LoginController,
    RegisterController,
    ProfileController,
    EquipmentController,
    ImageController
};

require base_path('routes/admin.php');


Route::get('login', [LoginController::class, 'loginIndex'])->name('login');
Route::post('login', [LoginController::class, 'submit'])->name('login.submit');



Route::get('/capture', [ImageController::class, 'showCaptureForm']);
Route::post('/save-image', [ImageController::class, 'saveImage'])->name('save.image');

// Route::get('/student/dashboard', [MemberController::class, 'studentDashboard'])->name('student.dashboard');


Route::get('register', [RegisterController::class, 'registerIndex'])->name('register');
Route::post('register/submit', [RegisterController::class, 'submit'])->name('register.submit');
Route::middleware(['auth:member'])->group(function () {
    Route::get('profile', [ProfileController::class, 'profileIndex'])->name('profile');
    Route::post('profile', [ProfileController::class, 'submit'])->name('profile.submit');
    Route::get('equipment', [EquipmentController::class, 'index'])->name('equipment');
    Route::post('logout', [ProfileController::class, 'logout'])->name('logout');
});
// Route::get('/', function () {
//     return redirect(app()->getLocale() . '/ ');
// })->where('any', '.*');

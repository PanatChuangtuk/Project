<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CkeditorController;
use App\Http\Controllers\Administrator\{
    AboutController,
    AuthController,
    UserController,
    AdminController,
    DashboardController
};

Route::prefix('administrator')->group(function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [AuthController::class, 'login'])->name('administrator.login');
        Route::post('/login', [AuthController::class, 'loginPost'])->name('administrator.login');
    });

    Route::middleware(['auth', 'checkrole:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('administrator.dashboard');
        Route::get('/logout', [AuthController::class, 'logout'])->name('administrator.logout');
        Route::post('ckeditor/upload', [CkeditorController::class, 'upload'])->name('administrator.ckeditor.upload');



        Route::group(['prefix' => 'admin', 'as' => 'administrator.'], function () {
            Route::get('/', [AdminController::class, 'index'])->name('admin');
            Route::get('/add', [AdminController::class, 'add'])->name('admin.add');
            Route::post('/submit', [AdminController::class, 'submit'])->name('admin.submit');
            Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
            Route::post('/update/{id}', [AdminController::class, 'update'])->name('admin.update');
            Route::delete('/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
            Route::post('/bulk-delete', [AdminController::class, 'bulkDelete'])->name('admin.bulk.delete');
        });
    });
});
Route::get('/', function () {
    return redirect()->route('administrator.dashboard');
})->where('any', '.*');

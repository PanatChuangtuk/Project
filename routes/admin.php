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

    Route::group(['middleware' => 'auth:web'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('administrator.dashboard');
        Route::get('/logout', [AuthController::class, 'logout'])->name('administrator.logout');
        Route::post('ckeditor/upload', [CkeditorController::class, 'upload'])->name('administrator.ckeditor.upload');


        Route::group(['prefix' => 'about', 'as' => 'administrator.'], function () {
            Route::get('/', [AboutController::class, 'index'])->name('about');
            Route::get('/add', [AboutController::class, 'add'])->name('about.add');
            Route::get('/edit/{id}', [AboutController::class, 'edit'])->name('about.edit');
            Route::post('/submit', [AboutController::class, 'submit'])->name('about.submit');
            Route::post('/update/{id}', [AboutController::class, 'update'])->name('about.update');
            Route::delete('/{id}', [AboutController::class, 'destroy'])->name('about.destroy');
            Route::post('/bulk-delete', [AboutController::class, 'bulkDelete'])->name('about.bulk.delete');
            Route::post('image/{id}', [AboutController::class, 'deleteImage'])->name('about.delete.image');
        });

        Route::group(['prefix' => 'users', 'as' => 'administrator.'], function () {
            Route::get('/', [UserController::class, 'index'])->name('users');
            Route::get('/add', [UserController::class, 'add'])->name('users.add');
            Route::post('/submit', [UserController::class, 'submit'])->name('users.submit');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
            Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
            Route::post('/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulk.delete');
        });
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

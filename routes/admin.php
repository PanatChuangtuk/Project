<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CkeditorController;
use App\Http\Controllers\Administrator\{
    ApproveUserController,
    AuthController,
    UserController,
    AdminController,
    DashboardController,
    StudentController
};

Route::prefix('administrator')->group(function () {
    // Route::group(['middleware' => 'guest'], function () {
    //     Route::get('/login', [AuthController::class, 'login'])->name('administrator.login');
    //     Route::post('/login', [AuthController::class, 'loginPost'])->name('administrator.login');
    // });

    Route::middleware(['auth:web'])->group(function () {
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

        Route::group(['prefix' => 'users', 'as' => 'administrator.'], function () {
            Route::get('/', [UserController::class, 'index'])->name('users');
            Route::get('/add', [UserController::class, 'add'])->name('users.add');
            Route::post('/submit', [UserController::class, 'submit'])->name('users.submit');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
            Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
            Route::post('/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulk.delete');
        });

        Route::group(['prefix' => 'student', 'as' => 'administrator.'], function () {
            Route::get('/', [StudentController::class, 'index'])->name('student');
            Route::get('/add', [StudentController::class, 'add'])->name('student.add');
            Route::post('/submit', [StudentController::class, 'submit'])->name('student.submit');
            Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
            Route::post('/update/{id}', [StudentController::class, 'update'])->name('student.update');
            Route::delete('/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
            Route::post('/bulk-delete', [StudentController::class, 'bulkDelete'])->name('student.bulk.delete');
            Route::post('/import', [StudentController::class, 'import'])->name('student.import');
            Route::get('/export', [StudentController::class, 'exportPage'])->name('student.export');
            Route::post('/import/submit', [StudentController::class, 'import'])->name('student.import.submit');
            Route::post('/export/submit', [StudentController::class, 'export'])->name('student.export.submit');
        });

        Route::group(['prefix' => 'user', 'as' => 'administrator.'], function () {
            Route::get('/', [UserController::class, 'index'])->name('user');
            Route::get('/add', [UserController::class, 'add'])->name('user.add');
            Route::post('/submit', [UserController::class, 'submit'])->name('user.submit');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
            Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.destroy');
            Route::post('/bulk-delete', [UserController::class, 'bulkDelete'])->name('user.bulk.delete');
        });

        Route::group(['prefix' => 'approve-user', 'as' => 'administrator.'], function () {
            Route::get('/', [ApproveUserController::class, 'index'])->name('approve-user');
            Route::post('/approve', [ApproveUserController::class, 'updateApprove'])->name('approve-user.approve');
        });
    });
});
Route::get('/', function () {
    return redirect()->route('administrator.dashboard');
})->where('any', '.*');

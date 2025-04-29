<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CkeditorController;
use App\Http\Controllers\Administrator\{
    ApproveUserController,
    AuthController,
    UserController,
    AdminController,
    DashboardController,
    StudentController,
    EquipmentCategoryController,
    EquipmentController,
    EquipmentItemController,
    ApproveEquipmentController,
    ReturnEquipmentController
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

        Route::group(['prefix' => 'category-equipment', 'as' => 'administrator.'], function () {
            Route::get('/', [EquipmentCategoryController::class, 'index'])->name('category-equipment');
            Route::get('/add', [EquipmentCategoryController::class, 'add'])->name('category-equipment.add');
            Route::post('/submit', [EquipmentCategoryController::class, 'submit'])->name('category-equipment.submit');
            Route::get('/edit/{id}', [EquipmentCategoryController::class, 'edit'])->name('category-equipment.edit');
            Route::post('/update/{id}', [EquipmentCategoryController::class, 'update'])->name('category-equipment.update');
            Route::delete('/{id}', [EquipmentCategoryController::class, 'destroy'])->name('category-equipment.destroy');
            Route::post('/bulk-delete', [EquipmentCategoryController::class, 'bulkDelete'])->name('category-equipment.bulk.delete');
        });

        Route::group(['prefix' => 'item-equipment', 'as' => 'administrator.'], function () {
            Route::get('/', [EquipmentItemController::class, 'index'])->name('item-equipment');
            Route::get('/add', [EquipmentItemController::class, 'add'])->name('item-equipment.add');
            Route::post('/submit', [EquipmentItemController::class, 'submit'])->name('item-equipment.submit');
            Route::get('/edit/{id}', [EquipmentItemController::class, 'edit'])->name('item-equipment.edit');
            Route::post('/update/{id}', [EquipmentItemController::class, 'update'])->name('item-equipment.update');
            Route::delete('/{id}', [EquipmentItemController::class, 'destroy'])->name('item-equipment.destroy');
            Route::post('/bulk-delete', [EquipmentItemController::class, 'bulkDelete'])->name('item-equipment.bulk.delete');
            Route::post('image/{id}', [EquipmentItemController::class, 'deleteImage'])->name('item-equipment.delete.image');
        });

        Route::group(['prefix' => 'equipment', 'as' => 'administrator.'], function () {
            Route::get('/', [EquipmentController::class, 'index'])->name('equipment');
            Route::get('/add', [EquipmentController::class, 'add'])->name('equipment.add');
            Route::post('/submit', [EquipmentController::class, 'submit'])->name('equipment.submit');
            Route::get('/edit/{id}', [EquipmentController::class, 'edit'])->name('equipment.edit');
            Route::post('/update/{id}', [EquipmentController::class, 'update'])->name('equipment.update');
            Route::delete('/{id}', [EquipmentController::class, 'destroy'])->name('equipment.destroy');
            Route::post('/bulk-delete', [EquipmentController::class, 'bulkDelete'])->name('equipment.bulk.delete');
            Route::post('image/{id}', [EquipmentController::class, 'deleteImage'])->name('equipment.delete.image');
        });

        Route::group(['prefix' => 'approve-user', 'as' => 'administrator.'], function () {
            Route::get('/', [ApproveUserController::class, 'index'])->name('approve-user');
            Route::post('/approve', [ApproveUserController::class, 'updateApprove'])->name('approve-user.approve');
        });

        Route::group(['prefix' => 'approve-equipment', 'as' => 'administrator.'], function () {
            Route::get('/', [ApproveEquipmentController::class, 'index'])->name('approve-equipment');
            Route::get('/edit/{id}', [ApproveEquipmentController::class, 'edit'])->name('approve-equipment.edit');
            Route::post('/update', [ApproveEquipmentController::class, 'updateApprove'])->name('approve-equipment.update');
            Route::post('/equipment-update', [ApproveEquipmentController::class, 'approveEquipment'])->name('approve-equipment.approveEquipment');
        });

        Route::group(['prefix' => 'return-equipment', 'as' => 'administrator.'], function () {
            Route::get('/', [ReturnEquipmentController::class, 'index'])->name('return-equipment');
            Route::get('/edit/{id}', [ReturnEquipmentController::class, 'edit'])->name('return-equipment.edit');
            Route::post('/update', [ReturnEquipmentController::class, 'updateApprove'])->name('return-equipment.update');
            Route::post('/equipment-update', [ReturnEquipmentController::class, 'approveEquipment'])->name('return-equipment.approveEquipment');
        });
    });
});
Route::get('/', function () {
    return redirect()->route('administrator.dashboard');
})->where('any', '.*');

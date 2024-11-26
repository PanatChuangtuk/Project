<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    NewsController,
    IndexController,
    LocaleController,
    ServiceController,
    AboutController,
    ContactController,
    FaqController,
    PromotionController,
    CatalogController,
    PurchaseController,
    LoginController,
    RegisterController,
    ProfileController,
    AddressController,
    TaxController,
    CartController,
    ProductController,
    FavouriteController,
    ReviewsController,
    CouponController,
    NotificationController,
    TermController,
    PrivacyController,
    ChangePasswordController,
    TrackTraceController,
    ProductListController,
    OrderController,
    RefundController
};

require base_path('routes/admin.php');


Route::get('login', [LoginController::class, 'loginIndex'])->name('login');
Route::post('login', [LoginController::class, 'submit'])->name('login.submit');



Route::get('register', [RegisterController::class, 'registerIndex'])->name('register');
Route::post('register/submit', [RegisterController::class, 'submit'])->name('register.submit');

// Route::get('profile', [ProfileController::class, 'profileIndex'])->name('profile')->middleware('auth:member');
// Route::post('profile', [ProfileController::class, 'submit'])->name('profile.submit')->middleware('auth:member');
Route::post('logout', [ProfileController::class, 'logout'])->name('logout')->middleware('auth:member');

// Route::get('/', function () {
//     return redirect(app()->getLocale() . '/ ');
// })->where('any', '.*');

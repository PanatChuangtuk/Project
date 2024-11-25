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


// Route::get('/', function () {
//     return redirect(app()->getLocale() . '/ ');
// })->where('any', '.*');

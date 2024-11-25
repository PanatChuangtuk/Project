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


Route::get('lang/{lang}', [LocaleController::class, 'setLocale'])->name('setLocale');
Route::prefix('{lang}')->group(function () {
    Route::get('login', [LoginController::class, 'loginIndex'])->name('login');
    Route::post('login', [LoginController::class, 'submit'])->name('login.submit');

    Route::get('otp-forgot-password', [LoginController::class, 'otpForgotPassword'])->name('forgot.password');
    Route::post('otp-forgot-password/submit', [LoginController::class, 'otpForgotPasswordSubmit'])->name('forgot.password.submit');

    Route::get('otp-forgot-password-login', [LoginController::class, 'dataForgotPassword'])->name('login.forgot.password');
    Route::post('otp-forgot-password-submit', [LoginController::class, 'dataForgotPasswordSubmit'])->name('login.forgot.password.submit');



    Route::get('set-new-password', [LoginController::class, 'resetPasswordIndex'])->name('login.reset.password');
    Route::post('set-new-password/submit', [LoginController::class, 'resetPasswordSubmit'])->name('login.reset.password.submit');


    Route::get('/', [IndexController::class, 'bannerShow'])->name('index');
    Route::get('news', [NewsController::class, 'newsIndex'])->name('news');
    Route::get('news-detail/{id}', [NewsController::class, 'newsDetail'])->name('news.detail');
    Route::get('about', [AboutController::class, 'aboutIndex'])->name('about');
    Route::get('service', [ServiceController::class, 'serviceIndex'])->name('service');
    Route::get('contact', [ContactController::class, 'contactIndex'])->name('contact');
    Route::get('faq', [FaqController::class, 'faqIndex'])->name('faq');
    Route::get('promotion', [PromotionController::class, 'promotionIndex'])->name('promotion');
    Route::get('promotion-detail/{id}', [PromotionController::class, 'promotionDetail'])->name('promotion.detail');
    Route::get('download', [CatalogController::class, 'catalogIndex'])->name('download');
    Route::get('download-catalog/{id}', [CatalogController::class, 'downloadCatalog'])->name('download.catalog');
    Route::get('track-trace', [TrackTraceController::class, 'trackTraceIndex'])->name('track.trace');
    Route::get('cart', [CartController::class, 'cartIndex'])->name('cart.index');

    Route::post('order/submit/{id}', [CartController::class, 'orderAddress'])->name('cart.order.submit');

    Route::post('cart-add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('cart-remove/{id}', [CartController::class, 'removeCart'])->name('cart.remove');
    Route::post('cart-delete/{id}', [CartController::class, 'deleteCart'])->name('cart.delete');
    Route::get('cart-check-out/{id}', [CartController::class, 'cartCheckIndex'])->name('cart.check.index')->middleware('auth:member');



    Route::post('order', [CartController::class, 'order'])->name('order.submit');

    // Route::post('clear-session', [CartController::class, 'clearSession'])->name('clear.session');

    Route::get('product', [ProductController::class, 'productIndex'])->name('product');
    Route::post('product/submit', [ProductController::class, 'submit'])->name('product.submit');
    Route::get('product-detail/{id}', [ProductController::class, 'productDetail'])->name('product.detail');
    Route::post('product-review', [ProductController::class, 'productReviewSubmit'])->name('product.review.submit');
    Route::get('product-list', [ProductListController::class, 'productListIndex'])->name('product.list');
    Route::get('return-refund/{id}', [RefundController::class, 'refundIndex'])->name('refund');

    // Route::post('product-detail-add/{id}', [ProductController::class, 'addToCart'])->name('product.detail.add');
    // Route::post('product-detail-delete/{id}', [ProductController::class, 'removeCart'])->name('product.detail.delete');


    Route::get('register', [RegisterController::class, 'registerIndex'])->name('register');
    Route::post('register/submit', [RegisterController::class, 'submit'])->name('register.submit');
    Route::get('set-new-password-2', [ProfileController::class, 'resetPasswordIndex'])->name('profile.reset.password')->middleware('auth:member');
    Route::post('set-new-password-2/submit', [ProfileController::class, 'resetPasswordSubmit'])->name('profile.reset.password.submit')->middleware('auth:member');



    Route::get('profile', [ProfileController::class, 'profileIndex'])->name('profile')->middleware('auth:member');
    Route::post('profile', [ProfileController::class, 'submit'])->name('profile.submit')->middleware('auth:member');
    Route::post('logout', [ProfileController::class, 'logout'])->name('logout')->middleware('auth:member');
    Route::get('address', [AddressController::class, 'address'])->name('profile.address')->middleware('auth:member');
    Route::get('cart-address', [AddressController::class, 'cartAddress'])->name('profile.address.add')->middleware('auth:member');
    Route::post('cart-address/submit', [AddressController::class, 'submit'])->name('profile.address.submit')->middleware('auth:member');
    Route::get('cart-address-detail/{id}', [AddressController::class, 'edit'])->name('profile.address.edit')->middleware('auth:member');
    Route::post('cart-address/update/{id}', [AddressController::class, 'update'])->name('profile.address.update')->middleware('auth:member');
    Route::get('tax-invoice', [TaxController::class, 'tax'])->name('tax')->middleware('auth:member');
    Route::get('request-full-tax-invoice', [TaxController::class, 'add'])->name('tax.add')->middleware('auth:member');
    Route::post('request-full-tax-invoice/submit', [TaxController::class, 'submit'])->name('tax.submit')->middleware('auth:member');
    Route::get('request-full-tax-invoice-detail/{id}', [TaxController::class, 'edit'])->name('tax.edit')->middleware('auth:member');
    Route::post('request-full-tax-invoice/update/{id}', [TaxController::class, 'update'])->name('tax.update')->middleware('auth:member');
    Route::get('my-purchase', [PurchaseController::class, 'purchaseIndex'])->name('purchase')->middleware('auth:member');
    Route::get('my-favourite', [FavouriteController::class, 'favouriteIndex'])->name('favourite')->middleware('auth:member');
    Route::get('reviews', [ReviewsController::class, 'reviewsIndex'])->name('reviews')->middleware('auth:member');
    Route::get('my-reviews', [ReviewsController::class, 'myReviewIndex'])->name('my.reviews')->middleware('auth:member');
    Route::get('my-coupon', [CouponController::class, 'couponIndex'])->name('coupon')->middleware('auth:member');
    Route::get('my-point', [CouponController::class, 'pointIndex'])->name('point')->middleware('auth:member');
    Route::get('notification', [NotificationController::class, 'notificationIndex'])->name('notification')->middleware('auth:member');
    Route::get('term-condition', [TermController::class, 'termIndex'])->name('term')->middleware('auth:member');
    Route::get('privacy-policy', [PrivacyController::class, 'privacyIndex'])->name('privacy')->middleware('auth:member');
    Route::get('change-password', [ChangePasswordController::class, 'changePasswordIndex'])->name('change.password')->middleware('auth:member');
});

Route::get('/', function () {
    return redirect(app()->getLocale() . '/ ');
})->where('any', '.*');

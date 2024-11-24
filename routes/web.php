<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Administrator\AuthController;
use App\Http\Controllers\Administrator\BannerController;
use App\Http\Controllers\Administrator\BrandController;
use App\Http\Controllers\Administrator\DashboardController;
use App\Http\Controllers\Administrator\NewsController;
use App\Http\Controllers\Administrator\MilestoneController;
use App\Http\Controllers\Administrator\TestimonialController;
use App\Http\Controllers\Administrator\ServiceController;
use App\Http\Controllers\Administrator\CatalogController;
use App\Http\Controllers\Administrator\FAQController;
use App\Http\Controllers\Administrator\SocialLinkController;
use App\Http\Controllers\Administrator\PromotionController;
use App\Http\Controllers\Administrator\ContactController;
use App\Http\Controllers\Administrator\PrivacyPolicyController;
use App\Http\Controllers\Administrator\TermAndConditionController;
use App\Http\Controllers\Administrator\UserController;
use App\Http\Controllers\CkeditorController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('administrator')->group(function () {
    

    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [AuthController::class, 'login'])->name('administrator.login');
        Route::post('/login', [AuthController::class, 'loginPost'])->name('administrator.login');
       
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('administrator.dashboard');
        Route::get('/logout', [AuthController::class, 'logout'])->name('administrator.logout');
        Route::post('/submit', [NewsController::class, 'submit'])->name('administrator.submit');
        Route::post('ckeditor/upload', [CkeditorController::class, 'upload'])->name('administrator.ckeditor.upload');
        Route::post('/update/{id}', [NewsController::class, 'update'])->name('administrator.update');
        Route::post('image/{id}', [NewsController::class, 'deleteImage'])->name('administrator.delete.image');
        


        Route::group(['prefix' => 'users', 'as' => 'administrator.'], function () {
            Route::get('/create', [UserController::class, 'createUser'])->name('users.create');
            Route::post('/createPost', [UserController::class, 'createUserPost'])->name('users.create.post');
        });

        Route::group(['prefix' => 'news', 'as' => 'administrator.'], function () {
            Route::get('/', [NewsController::class, 'index'])->name('news');
            Route::get('/add', [NewsController::class, 'add'])->name('news.add');
            Route::get('/edit/{id}', [NewsController::class, 'edit'])->name('news.edit');
        });

        Route::group(['prefix' => 'banner', 'as' => 'administrator.'], function () {
            Route::get('/', [BannerController::class, 'index'])->name('banner');
            Route::get('/add', [BannerController::class, 'add'])->name('banner.add');
            Route::get('/edit/{id}', [BannerController::class, 'edit'])->name('banner.edit');
            Route::post('/submit', [BannerController::class, 'submit'])->name('banner.submit');
            Route::post('/update/{id}', [BannerController::class, 'update'])->name('banner.update');
            Route::post('image/{id}', [BannerController::class, 'deleteImage'])->name('banner.delete.image');
        });

        Route::group(['prefix' => 'milestone', 'as' => 'administrator.'], function () {
            Route::get('/add', [MilestoneController::class, 'add'])->name('milestone.add');
            Route::get('/edit/{id}', [MilestoneController::class, 'edit'])->name('milestone.edit');
            Route::post('/submit', [MilestoneController::class, 'submit'])->name('milestone.submit');
            Route::post('/update/{id}', [MilestoneController::class, 'update'])->name('milestone.update');
            Route::post('image/{id}', [MilestoneController::class, 'deleteImage'])->name('milestone.delete.image');
        });

        Route::group(['prefix' => 'testimonial', 'as' => 'administrator.'], function () {
            Route::get('/add', [TestimonialController::class, 'add'])->name('testimonial.add');
            Route::get('/edit/{id}', [TestimonialController::class, 'edit'])->name('testimonial.edit');
            Route::post('/submit', [TestimonialController::class, 'submit'])->name('testimonial.submit');
            Route::post('/update/{id}', [TestimonialController::class, 'update'])->name('testimonial.update');
            Route::post('image/{id}', [TestimonialController::class, 'deleteImage'])->name('testimonial.delete.image');
        });

        Route::group(['prefix' => 'brand', 'as' => 'administrator.'], function () {
            Route::get('/add', [BrandController::class, 'add'])->name('brand.add');
            Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
            Route::post('/submit', [BrandController::class, 'submit'])->name('brand.submit');
            Route::post('/update/{id}', [BrandController::class, 'update'])->name('brand.update');
            Route::post('image/{id}', [BrandController::class, 'deleteImage'])->name('brand.delete.image');
        });

        Route::group(['prefix' => 'service', 'as' => 'administrator.'], function () {
            Route::get('/add', [ServiceController::class, 'add'])->name('service.add');
            Route::get('/edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
            Route::post('/submit', [ServiceController::class, 'submit'])->name('service.submit');
            Route::post('/update/{id}', [ServiceController::class, 'update'])->name('service.update');
            Route::post('image/{id}', [ServiceController::class, 'deleteImage'])->name('service.delete.image');
        });

        Route::group(['prefix' => 'catalog', 'as' => 'administrator.'], function () {
            Route::get('/add', [CatalogController::class, 'add'])->name('catalog.add');
            Route::get('/edit/{id}', [CatalogController::class, 'edit'])->name('catalog.edit');
            Route::post('/submit', [CatalogController::class, 'submit'])->name('catalog.submit');
            Route::post('/update/{id}', [CatalogController::class, 'update'])->name('catalog.update');
            Route::post('image/{id}', [CatalogController::class, 'deleteImage'])->name('catalog.delete.image');
        });

        Route::group(['prefix' => 'FAQ', 'as' => 'administrator.'], function () {
            Route::get('/add', [FAQController::class, 'add'])->name('faq.add');
            Route::get('/edit/{id}', [FAQController::class, 'edit'])->name('faq.edit');
            Route::post('/submit', [FAQController::class, 'submit'])->name('faq.submit');
            Route::post('/update/{id}', [FAQController::class, 'update'])->name('faq.update');
            Route::post('image/{id}', [FAQController::class, 'deleteImage'])->name('faq.delete.image');
        });
        
        Route::group(['prefix' => 'promotion', 'as' => 'administrator.'], function () {
            Route::get('/add', [PromotionController::class, 'add'])->name('promotion.add');
            Route::get('/edit/{id}', [PromotionController::class, 'edit'])->name('promotion.edit');
            Route::post('/submit', [PromotionController::class, 'submit'])->name('promotion.submit');
            Route::post('/update/{id}', [PromotionController::class, 'update'])->name('promotion.update');
            Route::post('image/{id}', [PromotionController::class, 'deleteImage'])->name('promotion.delete.image');
        });
        Route::group(['prefix' => 'contact', 'as' => 'administrator.'], function () {
            Route::get('/add', [ContactController::class, 'add'])->name('contact.add');
            Route::get('/edit/{id}', [ContactController::class, 'edit'])->name('contact.edit');
            Route::post('/submit', [ContactController::class, 'submit'])->name('contact.submit');
            Route::post('/update/{id}', [ContactController::class, 'update'])->name('contact.update');
            Route::post('image/{id}', [ContactController::class, 'deleteImage'])->name('contact.delete.image');
        });
        Route::group(['prefix' => 'term_and_condition', 'as' => 'administrator.'], function () {
            Route::get('/add', [TermAndConditionController::class, 'add'])->name('term_and_condition.add');
            Route::get('/edit/{id}', [TermAndConditionController::class, 'edit'])->name('term_and_condition.edit');
            Route::post('/submit', [TermAndConditionController::class, 'submit'])->name('term_and_condition.submit');
            Route::post('/update/{id}', [TermAndConditionController::class, 'update'])->name('term_and_condition.update');
            Route::post('image/{id}', [TermAndConditionController::class, 'deleteImage'])->name('term_and_condition.delete.image');
        });

        Route::group(['prefix' => 'privacy', 'as' => 'administrator.'], function () {
            Route::get('/add', [PrivacyPolicyController::class, 'add'])->name('privacy.add');
            Route::get('/edit/{id}', [PrivacyPolicyController::class, 'edit'])->name('privacy.edit');
            Route::post('/submit', [PrivacyPolicyController::class, 'submit'])->name('privacy.submit');
            Route::post('/update/{id}', [PrivacyPolicyController::class, 'update'])->name('privacy.update');
            Route::post('image/{id}', [PrivacyPolicyController::class, 'deleteImage'])->name('privacy.delete.image');
        });

        Route::group(['prefix' => 'social', 'as' => 'administrator.'], function () {
            Route::get('/add', [SocialLinkController::class, 'add'])->name('social.add');
            Route::get('/edit/{id}', [SocialLinkController::class, 'edit'])->name('social.edit');
            Route::post('/submit', [SocialLinkController::class, 'submit'])->name('social.submit');
            Route::post('/update/{id}', [SocialLinkController::class, 'update'])->name('social.update');
            Route::post('image/{id}', [SocialLinkController::class, 'deleteImage'])->name('social.delete.image');
        });

    });
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CkeditorController;
use App\Http\Controllers\Administrator\{
    AboutController,
    AuthController,
    BannerController,
    BrandController,
    CatalogController,
    CommonController,
    ContactController,
    DashboardController,
    FaqController,
    MilestoneController,
    NewsController,
    PermissionController,
    ProductController,
    PromotionController,
    RoleController,
    SocialController,
    TestimonialController,
    UserController,
    ProductModelController,
    AdminController
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

        Route::group(['prefix' => 'news', 'as' => 'administrator.'], function () {
            Route::get('/', [NewsController::class, 'index'])->name('news');
            Route::get('/add', [NewsController::class, 'add'])->name('news.add');
            Route::post('/submit', [NewsController::class, 'submit'])->name('news.submit');
            Route::get('/edit/{id}', [NewsController::class, 'edit'])->name('news.edit');
            Route::post('/update/{id}', [NewsController::class, 'update'])->name('news.update');
            Route::delete('/{id}', [NewsController::class, 'destroy'])->name('news.destroy');
            Route::post('/bulk-delete', [NewsController::class, 'bulkDelete'])->name('news.bulk.delete');
            Route::post('image/{id}', [NewsController::class, 'deleteImage'])->name('news.delete.image');
        });

        Route::group(['prefix' => 'banner', 'as' => 'administrator.'], function () {
            Route::get('/', [BannerController::class, 'index'])->name('banner');
            Route::get('/add', [BannerController::class, 'add'])->name('banner.add');
            Route::get('/edit/{id}', [BannerController::class, 'edit'])->name('banner.edit');
            Route::post('/submit', [BannerController::class, 'submit'])->name('banner.submit');
            Route::post('/update/{id}', [BannerController::class, 'update'])->name('banner.update');
            Route::delete('/{id}', [BannerController::class, 'destroy'])->name('banner.destroy');
            Route::post('/bulk-delete', [BannerController::class, 'bulkDelete'])->name('banner.bulk.delete');
            Route::post('image/{id}', [BannerController::class, 'deleteImage'])->name('banner.delete.image');
        });

        Route::group(['prefix' => 'milestone', 'as' => 'administrator.'], function () {
            Route::get('/', [MilestoneController::class, 'index'])->name('milestone');
            Route::get('/add', [MilestoneController::class, 'add'])->name('milestone.add');
            Route::get('/edit/{id}', [MilestoneController::class, 'edit'])->name('milestone.edit');
            Route::post('/submit', [MilestoneController::class, 'submit'])->name('milestone.submit');
            Route::post('/update/{id}', [MilestoneController::class, 'update'])->name('milestone.update');
            Route::post('image/{id}', [MilestoneController::class, 'deleteImage'])->name('milestone.delete.image');
        });

        Route::group(['prefix' => 'testimonial', 'as' => 'administrator.'], function () {
            Route::get('/', [TestimonialController::class, 'index'])->name('testimonial');
            Route::get('/add', [TestimonialController::class, 'add'])->name('testimonial.add');
            Route::get('/edit/{id}', [TestimonialController::class, 'edit'])->name('testimonial.edit');
            Route::post('/submit', [TestimonialController::class, 'submit'])->name('testimonial.submit');
            Route::post('/update/{id}', [TestimonialController::class, 'update'])->name('testimonial.update');
            Route::delete('/{id}', [TestimonialController::class, 'destroy'])->name('testimonial.destroy');
            Route::post('/bulk-delete', [TestimonialController::class, 'bulkDelete'])->name('testimonial.bulk.delete');
            Route::post('image/{id}', [TestimonialController::class, 'deleteImage'])->name('testimonial.delete.image');
        });

        Route::group(['prefix' => 'brand', 'as' => 'administrator.'], function () {
            Route::get('/', [BrandController::class, 'index'])->name('brand');
            Route::get('/add', [BrandController::class, 'add'])->name('brand.add');
            Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
            Route::post('/submit', [BrandController::class, 'submit'])->name('brand.submit');
            Route::post('/update/{id}', [BrandController::class, 'update'])->name('brand.update');
            Route::delete('/{id}', [BrandController::class, 'destroy'])->name('brand.destroy');
            Route::post('/bulk-delete', [BrandController::class, 'bulkDelete'])->name('brand.bulk.delete');
            Route::post('image/{id}', [BrandController::class, 'deleteImage'])->name('brand.delete.image');
        });

        Route::group(['prefix' => 'catalog', 'as' => 'administrator.'], function () {
            Route::get('/', [CatalogController::class, 'index'])->name('catalog');
            Route::get('/add', [CatalogController::class, 'add'])->name('catalog.add');
            Route::get('/edit/{id}', [CatalogController::class, 'edit'])->name('catalog.edit');
            Route::post('/submit', [CatalogController::class, 'submit'])->name('catalog.submit');
            Route::post('/update/{id}', [CatalogController::class, 'update'])->name('catalog.update');
            Route::delete('/{id}', [CatalogController::class, 'destroy'])->name('catalog.destroy');
            Route::post('/bulk-delete', [CatalogController::class, 'bulkDelete'])->name('catalog.bulk.delete');
            Route::post('image/{id}', [CatalogController::class, 'deleteImage'])->name('catalog.delete.image');
            Route::post('file/{id}', [CatalogController::class, 'deleteFile'])->name('catalog.delete.file');
        });

        Route::group(['prefix' => 'faq', 'as' => 'administrator.'], function () {
            Route::get('/', [FaqController::class, 'index'])->name('faq');
            Route::get('/add', [FaqController::class, 'add'])->name('faq.add');
            Route::get('/edit/{id}', [FaqController::class, 'edit'])->name('faq.edit');
            Route::post('/submit', [FaqController::class, 'submit'])->name('faq.submit');
            Route::post('/update/{id}', [FaqController::class, 'update'])->name('faq.update');
            Route::delete('/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');
            Route::post('/bulk-delete', [FaqController::class, 'bulkDelete'])->name('faq.bulk.delete');
            Route::post('image/{id}', [FaqController::class, 'deleteImage'])->name('faq.delete.image');
        });

        Route::group(['prefix' => 'promotion', 'as' => 'administrator.'], function () {
            Route::get('/', [PromotionController::class, 'index'])->name('promotion');
            Route::get('/add', [PromotionController::class, 'add'])->name('promotion.add');
            Route::get('/edit/{id}', [PromotionController::class, 'edit'])->name('promotion.edit');
            Route::post('/submit', [PromotionController::class, 'submit'])->name('promotion.submit');
            Route::post('/update/{id}', [PromotionController::class, 'update'])->name('promotion.update');
            Route::delete('/{id}', [PromotionController::class, 'destroy'])->name('promotion.destroy');
            Route::post('/bulk-delete', [PromotionController::class, 'bulkDelete'])->name('promotion.bulk.delete');
            Route::post('image/{id}', [PromotionController::class, 'deleteImage'])->name('promotion.delete.image');
        });

        Route::group(['prefix' => 'contact', 'as' => 'administrator.'], function () {
            Route::get('/', [ContactController::class, 'index'])->name('contact');
            Route::get('/add', [ContactController::class, 'add'])->name('contact.add');
            Route::get('/edit/{id}', [ContactController::class, 'edit'])->name('contact.edit');
            Route::post('/submit', [ContactController::class, 'submit'])->name('contact.submit');
            Route::post('/update/{id}', [ContactController::class, 'update'])->name('contact.update');
            Route::delete('/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');
            Route::post('/bulk-delete', [ContactController::class, 'bulkDelete'])->name('contact.bulk.delete');
            Route::post('image/{id}', [ContactController::class, 'deleteImage'])->name('contact.delete.image');
        });

        Route::group(['prefix' => 'common', 'as' => 'administrator.'], function () {
            Route::get('/', [CommonController::class, 'index'])->name('common');
            Route::get('/add', [CommonController::class, 'add'])->name('common.add');
            Route::get('/edit/{id}', [CommonController::class, 'edit'])->name('common.edit');
            Route::post('/update/{id}', [CommonController::class, 'update'])->name('common.update');
            Route::delete('/{id}', [CommonController::class, 'destroy'])->name('common.destroy');
            Route::post('/bulk-delete', [CommonController::class, 'bulkDelete'])->name('common.bulk.delete');
            Route::post('/submit', [CommonController::class, 'submit'])->name('common.submit');
        });

        Route::group(['prefix' => 'social', 'as' => 'administrator.'], function () {
            Route::get('/', [SocialController::class, 'index'])->name('social');
            Route::get('/add', [SocialController::class, 'add'])->name('social.add');
            Route::get('/edit/{id}', [SocialController::class, 'edit'])->name('social.edit');
            Route::post('/submit', [SocialController::class, 'submit'])->name('social.submit');
            Route::post('/update/{id}', [SocialController::class, 'update'])->name('social.update');
            Route::delete('/{id}', [SocialController::class, 'destroy'])->name('social.destroy');
            Route::post('/bulk-delete', [SocialController::class, 'bulkDelete'])->name('social.bulk.delete');
            Route::post('image/{id}', [SocialController::class, 'deleteImage'])->name('social.delete.image');
        });

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

        Route::group(['prefix' => 'roles', 'as' => 'administrator.'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('roles');
            Route::get('/add', [RoleController::class, 'add'])->name('roles.add');
            Route::post('/submit', [RoleController::class, 'submit'])->name('roles.submit');
            Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
            Route::post('/update/{id}', [RoleController::class, 'update'])->name('roles.update');
            Route::delete('/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
            Route::post('/bulk-delete', [RoleController::class, 'bulkDelete'])->name('roles.bulk.delete');
        });

        Route::group(['prefix' => 'permissions', 'as' => 'administrator.'], function () {
            Route::get('/', [PermissionController::class, 'index'])->name('permissions');
            Route::get('/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
            Route::put('/update', [PermissionController::class, 'update'])->name('permissions.update');
        });

        Route::group(['prefix' => 'product', 'as' => 'administrator.'], function () {
            Route::get('/', [ProductController::class, 'index'])->name('product');
            Route::get('/add', [ProductController::class, 'add'])->name('product.add');
            Route::post('/submit', [ProductController::class, 'submit'])->name('product.submit');
            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
            Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
            Route::post('/bulk-delete', [ProductController::class, 'bulkDelete'])->name('product.bulk.delete');

            Route::get('/import', [ProductController::class, 'importPage'])->name('product.import');
            Route::get('/export', [ProductController::class, 'exportPage'])->name('product.export');
            Route::post('/import/submit', [ProductController::class, 'import'])->name('product.import.submit');
            Route::post('/export/submit', [ProductController::class, 'export'])->name('product.export.submit');
        });

        Route::group(['prefix' => 'product_model', 'as' => 'administrator.'], function () {
            Route::get('/', [ProductModelController::class, 'index'])->name('product.model');
            Route::get('/edit/{id}', [ProductModelController::class, 'edit'])->name('product.model.edit');
            Route::post('/update/{id}', [ProductModelController::class, 'update'])->name('product.model.update');
        });
    });
});
Route::get('/', function () {
    return redirect()->route('administrator.dashboard');
})->where('any', '.*');

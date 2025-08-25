<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Author\{AuthorViewController, AuthorController,ProductCategoryController,ProductSubCategoryController,ProductController,SettingController,TestimonialController,DiscountCouponController,OrderController,HomeContentController,UsersController,WalletController};

/* Vendor Routes Start */
Route::group(['prefix' => 'author'], function () {
    Route::post('/post-sign-in', [AuthorController::class, 'login'])->name('vendor.post-sign-in');
    
    Route::group(['middleware' => 'VendorViewUnAuth'], function () {
        Route::get('/', [AuthorViewController::class, 'login_view'])->name('vendor.login');
        Route::get('/login', [AuthorViewController::class, 'login_view'])->name('vendor.login');
    });

    Route::group(['middleware' => 'VendorViewAuth'], function () {
        Route::post('/upload_image', [AuthorController::class, 'upload_image']);
        Route::get('/logout', [AuthorController::class, 'logout'])->name('vendor.logout');
        Route::get('/dashboard', [AuthorViewController::class, 'dashboard_view'])->name('vendor.dashboard');
        Route::get('/profile', [AuthorViewController::class, 'profile_view'])->name('vendor.profile');
        Route::get('/user-management', [AuthorViewController::class, 'user_management_view'])->name('vendor.user-management');
        Route::get('/contactus', [AuthorViewController::class, 'contactus_view'])->name('vendor.contactus.index');
        Route::post('/update_profile', [AuthorController::class, 'update_profile'])->name('vendor.update_profile');;
        Route::post('/user-additional-info', [AuthorController::class, 'additionalInfo'])->name('vendor.users.additionalInfo');;
        Route::post('/update-image', [AuthorController::class, 'update_image'])->name('vendor.update_image');;
        
       
        Route::resource('product-category', ProductCategoryController::class)->names([
            'index' => 'vendor.pro_category.index',
            'store' => 'vendor.pro_category.store',
            'create' => 'vendor.pro_category.create',
            'edit' => 'vendor.pro_category.edit',
            'destroy' => 'vendor.pro_category.destroy',
            'show' => 'vendor.pro_category.show',
        ]);

        Route::resource('product-subcategory',ProductSubCategoryController::class)->names([
            'index' => 'vendor.subcategory.index',
            'store' => 'vendor.subcategory.store',
            'create' =>'vendor.subcategory.create',
            'edit' => 'vendor.subcategory.edit',
            'destroy' => 'vendor.subcategory.destroy',
            'show' => 'vendor.subcategory.show',
        ]);
      
       
        Route::controller(OrderController::class)->prefix('sales')->group(function(){
            Route::get('/', 'index')->name('vendor.order.index');
            Route::get('show/{id}', 'show')->name('vendor.order.show');
        });
        Route::controller(UsersController::class)->prefix('users')->group(function(){
            Route::get('/', 'index')->name('vendor.users.index');
            Route::get('show/{id}', 'show')->name('vendor.users.show');
        });

        Route::controller(WalletController::class)->prefix('wallet')->group(function(){
            Route::get('/', 'index')->name('vendor.wallet.index');
            Route::get('show/{id}', 'show')->name('vendor.wallet.show');
            Route::post('store', 'store')->name('vendor.wallet.store');
        });
       
        Route::controller(ProductController::class)->prefix('product')->group(function(){
            Route::get('/', 'index')->name('vendor.product.index');
            Route::get('edit/{id}', 'edit')->name('vendor.product.edit');
            Route::get('show/{id}', 'show')->name('vendor.product.show');
            Route::patch('update/{id}', 'update')->name('vendor.product.update');
            Route::patch('update_status_featured/{id}', 'update_status_featured')->name('vendor.product.featured_update');
            Route::get('/create-step-one', 'addProductStep1')->name('vendor.product.create.step1');
            Route::get('/create-step-one', 'addProductStep1')->name('vendor.product.create.step1');
            Route::get('/create-step-two/{id}', 'addProductStep2')->name('vendor.product.create.step2');
            Route::get('/edit-step-two/{id}', 'editProductStep2')->name('vendor.product.edit.step2');
            Route::post('/post-step-one', 'storeProductStep1')->name('vendor.product.store.step1');
            Route::post('/post-step-two', 'storeProductStep2')->name('vendor.product.store.step2');
            Route::delete('destroy/{id}', 'destroy')->name('vendor.product.destroy');
            Route::get('comment/{id}', 'comment_view')->name('vendor.product.comment');
            Route::get('review/{id}', 'review_view')->name('vendor.product.review');
            Route::get('feedback/{id}', 'feedback_view')->name('vendor.product.feedback');
        });
    });
});
/* Vendor Routes  End */


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ADMIN\{AdminViewController, AdminController, PageController, ProductCategoryController, ProductSubCategoryController, UsersController, VendorController, EmailIntegrationsController, ProductController, SettingController, TestimonialController, DiscountCouponController, OrderController, HomeContentController, MailController, LocaleFileController, WalletController};
use App\Http\Controllers\Frontend\{CouponsController, HomeController, ProductController as FrontendProductController, HomeViewController, UserController, CartController, CommentController, SocialLoginController};
use App\Http\Controllers\Payment\{CheckoutController, PaymentsController, PayPalPaymentController, FlutterwaveController, StripePaymentController, RazorpayController, PawaPayController};
use App\Http\Controllers\Chat\ChatController;
use Laravel\Socialite\Facades\Socialite;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Admin Routes Start */

Route::group(['prefix' => 'admin'], function () {
    Route::post('/post-sign-in', [AdminController::class, 'login'])->name('admin.post-sign-in');

    Route::group(['middleware' => 'AdminViewUnAuth'], function () {
        Route::get('/', [AdminViewController::class, 'login_view'])->name('admin.login');
        Route::get('/login', [AdminViewController::class, 'login_view'])->name('admin.login');
    });
    Route::group(['middleware' => 'AdminViewAuth'], function () {
        Route::post('/upload_image', [AdminController::class, 'upload_image']);
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::get('/dashboard', [AdminViewController::class, 'dashboard_view'])->name('admin.dashboard');
        Route::get('/profile', [AdminViewController::class, 'profile_view'])->name('admin.profile');
        Route::get('/user-management', [AdminViewController::class, 'user_management_view'])->name('admin.user-management');
        Route::get('/contactus', [AdminViewController::class, 'contactus_view'])->name('admin.contactus.index');
        Route::delete('/contact-us/destroy/{id}', [AdminViewController::class, 'destroy'])->name('admin.contactus.destroy');
        Route::post('/update_profile', [AdminController::class, 'update_profile'])->name('admin.update_profile');;

        Route::resource('pages', PageController::class)->names([
            'index' => 'admin.pages.index',
            'create' => 'admin.pages.create',
            'store' => 'admin.pages.store',
            'edit'  => 'admin.pages.edit',
            'destroy' => 'admin.pages.destroy',
        ]);
        Route::resource('product-category', ProductCategoryController::class)->names([
            'index' => 'admin.pro_category.index',
            'store' => 'admin.pro_category.store',
            'create' => 'admin.pro_category.create',
            'edit' => 'admin.pro_category.edit',
            'destroy' => 'admin.pro_category.destroy',
            'show' => 'admin.pro_category.show',
        ]);
        Route::resource('product-subcategory', ProductSubCategoryController::class)->names([
            'index' => 'admin.subcategory.index',
            'store' => 'admin.subcategory.store',
            'create' => 'admin.subcategory.create',
            'edit' => 'admin.subcategory.edit',
            'destroy' => 'admin.subcategory.destroy',
            'show' => 'admin.subcategory.show',
        ]);
        Route::resource('users', UsersController::class)->names([
            'index' => 'admin.users.index',
            'store' => 'admin.users.store',
            'edit'  => 'admin.users.edit',
            'create' => 'admin.users.create',
            'destroy' => 'admin.users.destroy',
            'show' => 'admin.users.show',
        ]);
        Route::resource('vendor', VendorController::class)->names([
            'index' => 'admin.vendor.index',
            'store' => 'admin.vendor.store',
            'edit' => 'admin.vendor.edit',
            'destroy' => 'admin.vendor.destroy',
            'show' => 'admin.vendor.show',
            'create' => 'admin.vendor.create',
        ]);
        Route::post('/editVendor', [VendorController::class, 'edit_save_vendor'])->name('admin.vendor.edit_save_vendor');

        Route::controller(VendorController::class)->group(function () {
            Route::get('get-request', 'get_request')->name('admin.vendor.get_request');
            Route::get('show-request/{id}', 'show_request')->name('admin.vendor.show_request');
            Route::post('request_status_update/{id}', 'request_status_update')->name('admin.vendor.request_status_update');
            Route::delete('delete-request/{id}', 'delete_request')->name('admin.vendor.delete_request');
            Route::post('add_edit_content', 'add_edit_content')->name('admin.vendor.add_edit_content');
            Route::get('consent-form-setting', 'vendor_management')->name('admin.vendor.consent-form-setting');
        });


        Route::resource('email-integrations', EmailIntegrationsController::class)->names([
            'index' => 'admin.email_integrations.index',
            'store' => 'admin.email_integrations.store',
            'destroy' =>  'admin.email_integrations.destroy',
        ]);

        Route::controller(EmailIntegrationsController::class)->group(function () {
            Route::get('/emailList', 'SubscriberEmailList')->name('admin.emailList');
            Route::post('/email_autoresponder', 'email_autoresponder')->name('email_autoresponder');
            Route::post('/saveList', 'saveList')->name('admin.email_integrations.saveList');
        });


        Route::resource('testimonial', TestimonialController::class)->names([
            'index' => 'admin.testimonial.index',
            'store' => 'admin.testimonial.store',
            'create' => 'admin.testimonial.create',
            'edit'   => 'admin.testimonial.edit',
            'destroy' => 'admin.testimonial.destroy',
            'show' => 'admin.testimonial.show',
        ]);
        Route::resource('discount-coupons', DiscountCouponController::class)->names([
            'index' => 'admin.discount_coupon.index',
            'create' => 'admin.discount_coupon.create',
            'store' =>   'admin.discount_coupon.store',
            'edit' =>   'admin.discount_coupon.edit',
            'destroy' => 'admin.discount_coupon.destroy',
            'show' => 'admin.discount_coupon.show',
        ]);

        Route::resource('order', OrderController::class)->names([
            'index' => 'admin.order.index',
            'create' => 'admin.order.create',
            'store' =>   'admin.order.store',
            'edit' =>   'admin.order.edit',
            'destroy' => 'admin.order.destroy',
            'show' => 'admin.order.show',
        ]);
        Route::post('order-update-status', [OrderController::class, 'update_status'])->name('admin.order.update-status');

        Route::controller(LocaleFileController::class)->prefix('lang')->group(function () {
            Route::get('/', 'index')->name('admin.lang.index');
            Route::get('create/', 'create')->name('admin.lang.create');
            Route::post('/', 'store')->name('admin.lang.store');
            Route::post('store_master_file', 'store_master_file')->name('admin.lang.store_master_file');
            Route::post('store_message_file', 'store_message_file')->name('admin.lang.store_message_file');
            Route::post('store_page_title_file', 'store_page_title_file')->name('admin.lang.store_page_title_file');
            Route::post('store_fnt_message_file', 'store_fnt_message_file')->name('admin.lang.store_fnt_message_file');
            Route::get('edit/{id}', 'edit')->name('admin.lang.edit');
            Route::get('show/{lang}', 'show')->name('admin.lang.show');
            Route::patch('update/{id}', 'update')->name('admin.lang.update');
            Route::delete('destroy/{id}', 'destroy')->name('admin.lang.destroy');
        });

        Route::controller(HomeContentController::class)->prefix('home_content')->group(function () {
            Route::get('/', 'index')->name('admin.home_content.index');
            Route::get('create/', 'create')->name('admin.home_content.create');
            Route::post('/', 'store')->name('admin.home_content.store');
            Route::get('edit/{id}', 'edit')->name('admin.home_content.edit');
            Route::patch('update/{id}', 'update')->name('admin.home_content.update');
            Route::delete('destroy/{id}', 'destroy')->name('admin.home_content.destroy');
        });
        Route::controller(HomeContentController::class)->prefix('advertise')->group(function () {
            Route::get('/', 'advertise_view')->name('admin.advertise.index');
            Route::post('/',  'advertise_store')->name('admin.advertise.store');
            Route::get('create/', 'advertise_create')->name('admin.advertise.create');
            Route::get('edit/{id}', 'advertise_edit')->name('admin.advertise.edit');
        });

        Route::controller(ProductController::class)->prefix('product')->group(function () {
            Route::get('/', 'index')->name('admin.product.index');
            Route::get('edit/{id}', 'edit')->name('admin.product.edit');
            Route::get('show/{id}', 'show')->name('admin.product.show');
            Route::patch('update/{id}', 'update')->name('admin.product.update');
            Route::patch('update_status_featured/{id}', 'update_status_featured')->name('admin.product.featured_update');
            Route::get('/create-step-one', 'addProductStep1')->name('admin.product.create.step1');
            Route::get('/create-step-one', 'addProductStep1')->name('admin.product.create.step1');
            Route::get('/create-step-two/{id}', 'addProductStep2')->name('admin.product.create.step2');
            Route::get('/edit-step-two/{id}', 'editProductStep2')->name('admin.product.edit.step2');
            Route::post('/post-step-one', 'storeProductStep1')->name('admin.product.store.step1');
            Route::post('/post-step-two', 'storeProductStep2')->name('admin.product.store.step2');
            Route::delete('destroy/{id}', 'destroy')->name('admin.product.destroy');
            Route::get('comment/{id}', 'comment_view')->name('admin.product.comment');
            Route::get('review/{id}', 'review_view')->name('admin.product.review');
            Route::get('attach-files/{id}', 'attach_files_view')->name('admin.product.attach_files_view');
            Route::get('download', 'download_product')->name('admin.product.download');
            Route::post('/update_product_review_status', 'update_product_review_status')->name('admin.product.update_product_review_status');
        });



        Route::controller(SettingController::class)->prefix('setting')->group(function () {
            Route::get('/website',  'website_setting_view')->name('admin.website-setting');
            Route::post('/add_update',  'store')->name('admin.setting.store');
            Route::post('/updateSettings',  'updateSettings')->name('admin.setting.updateSettings');
            Route::post('/add_update_long_text',  'storelongtext')->name('admin.setting.storelongtext');
            Route::post('/add_update_lang',  'add_update_lang')->name('admin.setting.addupdatelang');
            Route::get('/menu',  'menu')->name('admin.menu');
            Route::get('/payment',  'payment_setting_view')->name('admin.payment-setting');
            Route::post('/add_update_banner',  'add_update_banner')->name('admin.setting.add_update_banner');
            Route::get('/manage_banner',  'manage_banner')->name('admin.setting.manage_banner');
            Route::get('/why_choose_us',  'why_choose_us_view')->name('admin.setting.why_choose_us');
            Route::get('/portal_revenue',  'portal_revenue_view')->name('admin.setting.revenue');
            Route::post('/email_templates_store', 'email_templates_stores')->name('admin.email_templates_store');
            Route::get('/email_template', 'email_templates')->name('admin.email_templates');
            Route::get('/social_login',  'social_login')->name('admin.setting.social-login');
            Route::post('/post-social',  'saveSociallogin')->name('admin.setting.post-social');
            Route::get('/social_login',  'social_login')->name('admin.setting.social-login');
            Route::get('/storage',  'storage_view')->name('admin.storage.index');
            Route::get('/color',  'color_view')->name('admin.color_setting.index');
            Route::get('/media',  'media_view')->name('admin.media.index');
            Route::post('/post-media',  'saveMediaSettings')->name('admin.setting.post-media');
        });
        Route::post('/send_mail', [MailController::class, 'send_mail'])->name('admin.email.sendmail');

        /* Wallet routes */
        Route::controller(WalletController::class)->prefix('wallet')->group(function () {
            Route::get('/', 'index')->name('admin.wallet.index');
            Route::get('show/{id}', 'show')->name('admin.wallet.show');
            Route::get('withdraw-request', 'withdraw_request')->name('admin.wallet.withdraw-request');
            Route::get('edit-request/{id}', 'edit_request')->name('admin.wallet.edit-request');
            Route::post('update-request', 'update_request')->name('admin.wallet.update_request');
            Route::get('withdraw-setting', 'withdraw_setting')->name('admin.wallet.withdraw-setting');
        });
    });
});
Route::post('/upload_preview_image', [ProductController::class, 'storeMedia']);

/* Admin Routes  End */

/* Frontend Routes Start */
// Route::get('/', function () {
//     return redirect(app()->getLocale());
// });

Route::get('/',  [HomeViewController::class, 'index'])->name('frontend.home');
Route::get('install/',  [HomeViewController::class, 'install'])->name('frontend.install');


Route::get('locale/{lang}',  function ($locale) {
    app()->setLocale($locale);
    return redirect()->route('frontend.home', $locale);
})->name('frontend.setlang');

Route::group(
    [
        'prefix' => '{locale}',
        'where' => ['locale' => '[a-zA-Z]{2}'],
        'middleware' => 'setlocale'
    ],
    function () {
        Route::controller(HomeViewController::class)->group(function () {
            Route::get('/',  'index')->name('frontend.home');
            Route::get('/aboutus',  'aboutus_view')->name('frontend.about-us');
            Route::get('/privacy-policy',  'privacy_policy_view')->name('frontend.privacy-policy');
            Route::get('/terms-and-conditions',  'terms_and_conditions_view')->name('frontend.terms-and-conditions');
            Route::get('/author-terms-and-conditions',  'author_terms_and_conditions_view')->name('frontend.author-terms-and-conditions');
            Route::get('/contact-us', 'contactus_view')->name('frontend.contact-us');
        });

        //User access without login
        Route::group(['middleware' => 'UserViewUnAuth'], function () {

            Route::controller(HomeViewController::class)->group(function () {
                Route::get('/sign-in', 'login_view')->name('frontend.sign-in');
                Route::get('/sign-up', 'register_view')->name('frontend.sign-up');
                Route::get('/forgot', 'forgot_view')->name('frontend.forgot');
                Route::get('/reset-password', 'reset_password_view')->name('frontend.reset-password');
            });
        });

        //Product
        Route::controller(FrontendProductController::class)->prefix('product')->group(function () {
            Route::get('shop/{slug}', 'single_details')->name('frontend.product.single_details');
            Route::get('search', 'search')->name('frontend.product.search');
            Route::post('ajax_search_product', 'ajax_search_product')->name('frontend.product.postsearch');
            Route::get('author/{name}/portfolio', 'author_details')->name('frontend.user.author');
        });

        // Cart
        Route::get('cart/', [CartController::class, 'index'])->name('frontend.cart.index');
        Route::group(['middleware' => 'UserViewAuth'], function () {
            Route::controller(HomeViewController::class)->group(function () {
                Route::get('/my-profile', 'profile_view')->name('frontend.profile');
                Route::get('wishlist', 'wishlist_view')->name('frontend.wishlist');
            });
        });

        // Cart
        Route::controller(CartController::class)->prefix('cart')->group(function () {
            Route::post('/', 'store')->name('frontend.cart.store');
            Route::delete('{product}/{cart}', 'destroy')->name('frontend.cart.destroy');
            Route::post('save-later/{product}', 'saveLater')->name('frontend.cart.save-later');
            Route::post('add-to-cart/{product}', 'addToCart')->name('frontend.cart.add-to-cart');
            Route::patch('{product}', 'update')->name('frontend.cart.update');
            Route::post('add-to-wishlist', 'addToWishlist')->name('frontend.cart.add-to-cart');
            Route::post('remove-wishlist', 'removefromWishlist')->name('frontend.wishlist.remove');
        });
        Route::controller(HomeController::class)->group(function () {
            Route::post('/post-contact-us', 'postContactus')->name('frontend.post-contact-us');
            Route::get('/email-verification', 'emailVerify')->name('frontend.email-verify');
        });
        //User access without login
        Route::group(['middleware' => 'UserViewUnAuth'], function () {

            Route::controller(UserController::class)->group(function () {
                Route::post('/signup',  'signup')->name('frontend.usersignup');
                Route::post('/login',  'login')->name('frontend.userlogin');
                Route::post('/post-forgot',  'forgot_password')->name('frontend.post-forgot');
                Route::post('/post-reset-password',  'update_reset_password')->name('frontend.post-reset-password');
            });
        });

        //user access with login
        Route::group(['middleware' => 'UserViewAuth'], function () {

            Route::controller(UserController::class)->group(function () {
                Route::get('/logout',  'logout')->name('frontend.logout');
                Route::post('/update-profile',  'updateProfile')->name('frontend.update_profile');
                Route::post('/update-user-image',  'update_user_image')->name('frontend.update_user_image');
                Route::post('/change-password',  'change_password')->name('frontend.change-password');
                Route::post('/become-an-vendor-request',  'become_an_vendor_request')->name('frontend.become-an-vendor-request');
            });

            //coupon code apply
            Route::post('/post-coupon-code', [CouponsController::class, 'checkCouponCode'])->name('frontend.coupon.apply');
            Route::delete('/coupon-code', [CouponsController::class, 'destroy'])->name('frontend.coupon.destroy');

            // Product comment
            Route::controller(CommentController::class)->group(function () {
                Route::post('comment', 'store')->name('frontend.comment.store');
                Route::post('rating', 'rating_store')->name('admin.rating.store');
            });

            //chat routes
            Route::get('/me/chats', [ChatController::class, 'list'])->name('chat.list');
            Route::get('/me/chats/open/{partnerId}', [ChatController::class, 'open'])->name('chat.open');
            Route::post('/me/chats/send', [ChatController::class, 'send'])->name('chat.send');
        });
        /* paypal payment gateway*/
        Route::controller(PayPalPaymentController::class)->prefix('paypal')->group(function () {
            Route::get('cancel-payment', 'paymentCancel')->name('paypal.cancel.payment');
            Route::get('payment-success', 'paymentSuccess')->name('paypal.success.payment');
        });

        /*Stripe Payment */
        Route::controller(StripePaymentController::class)->prefix('stripe')->group(function () {
            Route::get('payment-success', 'success')->name('frontend.success.payment');
            Route::post('handle-payment', 'handlePayment')->name('frontend.stripe.handle');
            Route::get('payment-failed', 'failed')->name('frontend.payment.failed');
        });
        /*Stripe Payment*/

        /*pawapay Payment */
        Route::controller(PawaPayController::class)->prefix('pawapay')->group(function () {
            Route::get('payment-success', 'success')->name('frontend.pawapay.success');
        });
        /*pawapay Payment*/



        /*razorpay Payment */
        Route::controller(RazorpayController::class)
            ->prefix('razorpay')
            ->group(function () {
                Route::post('handle-payment', 'handlePayment')->name('razorpay.make.payment');
            });
        /*razorpay Payment*/


        /*flutterwave Payment */
        Route::controller(FlutterwaveController::class)->prefix('flutterwave')->group(function () {
            Route::get('payment-success', 'success')->name('frontend.flutterwave.success');
            Route::get('transaction-success-api', 'transaction_success_api');
        });

        Route::controller(CheckoutController::class)->group(function () {
            Route::get('/checkout', 'index')->name('frontend.checkout');
            Route::post('/checkout', 'store')->name('frontend.checkout.store');
            Route::get('/transaction-success', 'transactionSuccess')->name('frontend.success.transaction');
            Route::get('/download-file', 'downlaodfile')->name('frontend.download-file');
            Route::get('/download-invoice', 'downlaod_invoice')->name('frontend.download-invoice');
            Route::get('/view-invoice', 'view_invoice')->name('frontend.view-invoice');
            Route::get('/transaction-error', 'transactionError')->name('frontend.cancel.payment');
        });

        // Product comment

        Route::post('comment/ajax_search', [CommentController::class, 'ajax_search_comments'])->name('frontend.comment.search');
        Route::post('rating/ajax_search', [CommentController::class, 'ajax_search_rating'])->name('frontend.rating.search');
        Route::get('get_advertize', [HomeController::class, 'get_advertize'])->name('frontend.get_advertize');
        Route::post('post_newsletter', [HomeController::class, 'postNewsletter'])->name('frontend.post_newsletter');
    }
);

//Social Login
Route::get('/google/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('frontend.login.google');
Route::get('/facebook/redirect', function () {
    return Socialite::driver('facebook')->redirect();
})->name('frontend.login.facebook');

Route::get('/google/callback', [SocialLoginController::class, 'googleCallback']);
Route::get('/facebook/callback', [SocialLoginController::class, 'facebookCallback']);
/* Frontend Routes End  */


/* Vendor Routes Start */

include  __DIR__ . '/vendor_web.php';

/* Vendor Routes End */

Route::get('/cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return redirect()->route('frontend.home', app()->getLocale());
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return redirect()->route('frontend.home', app()->getLocale());
    // dd(Artisan::output());
});

Route::get('/migration', function () {
    Artisan::call('migrate');
    dd(Artisan::output());
});

<?php

use Illuminate\Support\Facades\Route;

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


Route::namespace('App\Http\Controllers')->group(function () {


    Route::prefix('auth')->group(function () {

        Route::post('/signin', 'Auth\AuthController@signIn');
        Route::post('/signup', 'Auth\AuthController@signUp');
        Route::post('/verify-email', 'Auth\AuthController@verifyEmail');
        Route::post('/send-password-reset', 'Auth\AuthController@sendPasswordReset');
        Route::post('/reset-password', 'Auth\AuthController@resetPassword');
        Route::get('/unauthenticated', 'Auth\AuthController@unauthenticated')
            ->name('auth.unauthenticated');


        Route::middleware('auth:sanctum')->group(function () {
            Route::patch('/update-profile', 'Auth\AuthController@updateProfile');
            Route::patch('/update-credentials', 'Auth\AuthController@updateCredentials');
            Route::get('/user', 'Auth\AuthController@user');
            Route::post('/logout', 'Auth\AuthController@logout');
            Route::post('/resend-otp', 'Auth\AuthController@resendEmailVerificationOtp');
        });
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', 'Category\CategoriesController@viewAll');
        Route::get('/featured', 'Category\CategoriesController@viewFeatured');
        Route::get('/{slug}', 'Category\CategoriesController@view');
        Route::middleware(['auth:sanctum', 'verified', 'role:admin'])->group(function () {
            Route::post('/', 'Category\CategoriesController@store');
            Route::post('/{category}/update', 'Category\CategoriesController@update');
        });
        Route::get('/{slug}/products', 'Category\CategoriesController@viewProducts');
        Route::delete('/{category}', 'Category\CategoriesController@destroy');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', 'Products\ProductsController@viewAll');

        Route::middleware(['auth:sanctum', 'verified', 'role:admin'])->group(function () {
            Route::post('/', 'Products\ProductsController@store');
            Route::patch('/{product}/remove-image/{index}', 'Products\ProductsController@removeAdditionalImage');
            Route::delete('/{product}', 'Products\ProductsController@destroy');
            Route::post('/{product}/update', 'Products\ProductsController@update');
        });
        Route::get('/latest', 'Products\ProductsController@viewLatest');
        Route::get('/low-cost', 'Products\ProductsController@viewLowCost');
        Route::get('/{product}', 'Products\ProductsController@show');
        Route::get('/{product}/related', 'Products\ProductsController@relatedProducts');
        Route::get('/{product}/reviews', 'Products\ProductsController@reviews');
    });

    Route::middleware('auth:sanctum', 'verified')->group(function () {
        Route::prefix('wishlist')->group(function () {
            Route::get('/', 'Products\WishlistController@viewAll');
            Route::post('/{product}', 'Products\WishlistController@store');
            Route::delete('/{item}', 'Products\WishlistController@destroy');
        });

        Route::prefix('cart')->group(function () {
            Route::get('/', 'Products\CartController@viewAll');
            Route::post('/', 'Products\CartController@store');
            Route::get('/order-summary', 'Products\CartController@viewOrderSummary');
            Route::delete('/{item}', 'Products\CartController@destroy');
            Route::patch('/{item}', 'Products\CartController@update');
        });

        Route::prefix('checkout')->group(function () {
            Route::get('/summary', 'Products\CheckoutController@getCheckoutSummary');
            Route::get('/', 'Products\CheckoutController@view');
            Route::get('/billing', 'Products\CheckoutController@billing');
            Route::post('/', 'Products\CheckoutController@checkout');
        });


        Route::prefix('orders')->group(function () {
            Route::get('/', 'Invoice\OrderController@viewOrders');
            Route::get('/all', 'Invoice\OrderController@viewAllOrders');
            Route::get('/history', 'Invoice\OrderController@viewOrderHistory');
            Route::get('/{invoice}', 'Invoice\OrderController@viewOrder');
            Route::patch('/{invoice}', 'Invoice\OrderController@update');
            Route::get('/{invoice}/status', 'Invoice\OrderController@deliveryStatus');
        });

        Route::prefix('billing-information')->group(function () {
            Route::get('/', 'Invoice\BillingInformationController@viewAll');
            Route::get('/default', 'Invoice\BillingInformationController@viewDefault');
            Route::get('/{info}', 'Invoice\BillingInformationController@view');
            Route::delete('/{info}', 'Invoice\BillingInformationController@destroy');
            Route::post('/', 'Invoice\BillingInformationController@store');
            Route::patch('/{info}', 'Invoice\BillingInformationController@update');
        });

        Route::prefix('communication-preferences')->group(function () {
            Route::get('/', 'Communication\CommunicationPreferenceController@viewAll');
            Route::put('/', 'Communication\CommunicationPreferenceController@save');
        });

        Route::prefix('notifications')->group(function () {
            Route::get('/', 'Notification\NotificationsController@viewAll');
            Route::patch('/{notification}', 'Notification\NotificationsController@markAsRead');
            Route::middleware('role:admin')->group(function () {
                Route::post('/', 'Notification\NotificationsController@sendNotifications');
            });
        });


        Route::prefix('reviews')->group(function () {
            Route::post('/', 'Reviews\ReviewsController@store');

            Route::middleware('role:admin')->group(function () {
                Route::get('/', 'Reviews\ReviewsController@viewAll');
                Route::get('/{review}', 'Reviews\ReviewsController@view');
            });
        });

        Route::middleware('role:admin')->group(function () {

            Route::prefix('overview')->group(function () {
                Route::get('/', 'Overview\OverviewController');
            });

            Route::prefix('coupons')->group(function () {
                Route::get('/', 'Coupon\CouponController@viewAll');
                Route::post('/', 'Coupon\CouponController@store');
                Route::get('/{coupon}', 'Coupon\CouponController@view');
                Route::patch('/{coupon}', 'Coupon\CouponController@update');
                Route::delete('/{coupon}', 'Coupon\CouponController@destroy');
            });

            Route::prefix('users')->group(function () {
                Route::get('/', 'User\UsersController@viewAll');
                Route::get('/{user}', 'User\UsersController@view');
                Route::patch('/{user}/{status}', 'User\UsersController@updateStatus');
            });

            Route::prefix('shipping-fee')->group(function () {
                Route::put('/', 'Settings\ShippingFeeController@save');
                Route::get('/', 'Settings\ShippingFeeController@view');
            });

            Route::prefix('hero-details')->group(function () {
                Route::post('/', 'Home\HomeController@store');
                Route::delete('/{details}', 'Home\HomeController@destroy');
                Route::post('/{details}/update', 'Home\HomeController@update');
            });
        });
    });

    Route::prefix('webhook')->group(function () {
        Route::post('/paystack', 'Webhook\WebhookController@paystack')
            ->name('webhook.paystack');
        Route::post('/stripe', 'Webhook\WebhookController@stripe')
            ->name('webhook.stripe');
    });

    Route::prefix('newsletter')->group(function () {
        Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
            Route::get('/', 'Newsletter\NewsletterSubscribersController@viewAll');
            Route::get('/export', 'Newsletter\NewsletterSubscribersController@exportCsv');
        });
        Route::post('/subscribe', 'Newsletter\NewsletterSubscribersController@store');
    });

    Route::get('/hero-details', 'Home\HomeController@viewAll');
    Route::get('/hero-details/{details}', 'Home\HomeController@view');
});

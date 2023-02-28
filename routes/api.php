<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/






Route::group(['prefix' => 'main'], function () {
    Route::controller(App\Http\Controllers\Api\MainController::class)->group(function () {
        Route::get('cities', 'cities');
        Route::get('neighborhoods', 'neighborhoods');
        Route::get('classifications', 'classifications');
        Route::get('settings', 'settings');
        Route::post('contact-us', 'contactUs');
    });
});
Route::group(['prefix' => 'client'], function () {
    Route::controller(App\Http\Controllers\Api\Client\AuthClientController::class)->prefix('auth/')->group(function () {
        Route::post('register', 'createClient');
        Route::post('login', 'loginClient');
        Route::post('forget-password', 'forgetPassword');
        Route::post('new-password', 'newPassword');
    });
    Route::controller(App\Http\Controllers\Api\Client\ClientController::class)->group(function () {
        Route::get('restaurants', 'restaurants');
        Route::get('restaurants/meals/{id}', 'showRestaurantsMeals');
        Route::get('restaurants/meal-detail/{id}', 'showMealDetails');
        Route::get('show-reviews/{restaurant_id}', 'showReviews');
        Route::get('offers', 'offers');
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::controller(App\Http\Controllers\Api\Client\ClientController::class)->group(function () {
            Route::post('/auth/logout', 'logout');
            Route::post('/auth/edit-data', 'editData');
            Route::post('create-review', 'createReview');
        });
        Route::controller(App\Http\Controllers\Api\Client\OrderController::class)->group(function () {
            Route::post('create-order', 'createOrder');
            Route::get('order-details/{id}', 'orderDetails');
            Route::get('recent-orders', 'recentOrders');
            Route::get('latest-orders', 'latestOrders');
            Route::post('deliver-order/{id}', 'deliverOrder');
            Route::post('reject-order/{id}', 'rejectOrder');
        });
        route::controller(App\Http\Controllers\Api\NotificationController::class)->group(function () {
            Route::post('register-token', 'registerToken');
            Route::post('remove-token', 'removeToken');
            Route::get('notification-list','notificationList');
            Route::get('notification-count','notificationCount');
            Route::get('read-notification/{id}','notification');
        });
    });
});
Route::group(['middleware' => 'auth:api-restaurant'], function () {
    Route::controller(App\Http\Controllers\Api\Restaurant\AuthRestarantController::class)->prefix('auth/')->group(function () {
        Route::post('register', 'createRestaurant');
        Route::post('login', 'loginRestaurant');
        Route::post('forget-password', 'forgetPassword');
        Route::post('new-password', 'newPassword');
    });
    Route::group(['prefix' => 'restaurant'], function () {
        Route::controller(App\Http\Controllers\Api\Restaurant\RestaurantController::class)->group(function () {
            Route::post('/auth/logout', 'logout');
            Route::post('/auth/edit-restaurant-data', 'editRestaurantData');
            Route::controller(App\Http\Controllers\Api\Restaurant\MealsController::class)->group(function () {
                Route::post('/add-meal', 'addMeal');
                Route::post('/delete-meal/{id}', 'deleteMeal');
                Route::get('/show-meal/{id}', 'editMeal');
                Route::post('/update-meal/{id}', 'updateMeal');
                Route::get('/show-restaurant-meals', 'showRestaurantMeals');
            });
            Route::controller(App\Http\Controllers\Api\Restaurant\FeespaidController::class)->group(function () {
                Route::get('/commision', 'commision');
                Route::post('/pay-fees', 'payFees');
            });
        });
        Route::controller(App\Http\Controllers\Api\Restaurant\OfferController::class)->group(function () {
            Route::get('/offers', 'index');
            Route::post('/offer/create-offer', 'createOffer');
            Route::post('/offer/delete-offer/{id}', 'deleteOffer');
            Route::get('/offer/show-offer/{id}', 'editOffer');
            Route::post('/offer/update-offer/{id}', 'updateOffer');
        });
        Route::controller(App\Http\Controllers\Api\Restaurant\OrderController::class)->group(function () {
            Route::get('/new-orders', 'newOrders');
            Route::get('/recent-orders', 'recentOrders');
            Route::get('/last-orders', 'lastOrders');
           Route::post('accept-order/{id}', 'acceptOrder');
            Route::post('reject-order/{id}', 'rejectOrder');
            Route::post('confirm-delivered-order/{id}', 'confirmDeliveredOrder');
        });
        route::controller(App\Http\Controllers\Api\NotificationController::class)->group(function () {
            Route::post('register-token', 'registerToken');
            Route::post('remove-token', 'removeToken');
            Route::get('notification-list','notificationList');
            Route::get('notification-count','notificationCount');
            Route::get('read-notification/{id}','notification');
        });
    });
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

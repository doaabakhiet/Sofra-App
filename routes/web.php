<?php

use App\Http\Controllers\Dashboard\OfferController;
use App\Http\Controllers\Dashboard\RestaurantController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\AccountController;
use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\ClassificationController;
use App\Http\Controllers\Dashboard\ContactController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\NeighbourhoodController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\PaymentController;
use App\Http\Controllers\Dashboard\PdfController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
        return view('welcome');
    });


Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['isAdmin','auth']], function () {
    Route::get('admin', [DashboardController::class, 'index'])->name('admin');
    Route::resource('cities', CityController::class);
    Route::resource('neighbourhoods', NeighbourhoodController::class);
    Route::resource('setting', SettingController::class);
    Route::resource('accounts', AccountController::class);
    Route::resource('contacts', ContactController::class);
    Route::resource('classifications', ClassificationController::class);
    Route::resource('clients', ClientController::class);
    Route::post('client-toggle-active', [ClientController::class, 'toggleActive'])->name('client.toggle-active');
    Route::resource('restaurants', RestaurantController::class);
    Route::post('toggle-active', [RestaurantController::class, 'toggleActive'])->name('restaurant.toggle-active');
    Route::resource('offers', OfferController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles',RoleController::class);

    Route::get('manage-password', [DashboardController::class, 'managePassword']);
    Route::put('update-password', [DashboardController::class, 'updatePassword']);
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');





 // route::get('order/invoice/{id}/generate',[PdfController::class,'view']);
    // route::get('order/invoice/{id}/mail',[PdfController::class,'sendEmail']);


<?php

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\CategoryOptionsController;
use App\Http\Controllers\Delivery\DeliveryController;
use App\Http\Controllers\Donations\DonationsController;
use App\Http\Controllers\Donations\DonationsTypeController;
use App\Http\Controllers\DontationHelp\DonationHelpController;
use App\Http\Controllers\Food\FoodController;
use App\Http\Controllers\Food\FoodRequestsConroller;
use App\Http\Controllers\Food\MonthlyHelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Uploads\UploadsController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
    $user = auth()->guard('admin')->user();
    if($user)
        return $user;
    return view('welcome');
});
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware'=>[
        'localizationRedirect',
        'localeSessionRedirect',
        'localeViewPath',
    ]
], function() {
    Auth::routes();
    Route::group(['middleware'=>['auth:admin']],function (){
        Route::get('/', [HomeController::class, 'Dashboard'])->name('Dashboard');
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/users/data-table', [UsersController::class, 'dataTable'])->name('users.dataTable');
        Route::resource('users', UsersController::class)->middleware(['auth:admin']);
        Route::get('/categories/data-table', [CategoryController::class, 'dataTable'])->name('categories.dataTable');
        Route::post('/categories/upload-img', [CategoryController::class, 'uploadImg'])->name('categories.uploadImg');
        Route::get('categories/list-for-filters', [App\Http\Controllers\API\Category\CategoryController::class, 'index'])->name('categories.listForFilter');
        Route::resource('categories', CategoryController::class)->middleware(['auth:admin']);
        Route::get('/category-option/data-table', [CategoryOptionsController::class, 'dataTable'])->name('category-option.dataTable');
        Route::resource('category-option', CategoryOptionsController::class)->middleware(['auth:admin']);//->name('categoryOption.');
        Route::get('/uploads/index', [UploadsController::class, 'index'])->name('uploads.index');
        Route::post('/uploads/upload', [UploadsController::class, 'uploadFiles'])->name('uploads.uploadFiles');
        Route::get('/donation-types/data-table', [DonationsTypeController::class, 'dataTable'])->name('donation-types.dataTable');
        Route::resource('donation-types', DonationsTypeController::class)->middleware(['auth:admin']);//->name('categoryOption.');
        Route::get('donations/data-table', [DonationsController::class, 'dataTable'])->middleware(['auth:admin'])->name('donations.dataTable');
        Route::post('donations/accept', [DonationsController::class, 'acceptDonation'])->middleware(['auth:admin'])->name('donations.accept');
        Route::delete('donations/refuse', [DonationsController::class, 'refuseDonation'])->middleware(['auth:admin'])->name('donations.refuse');
        Route::resource('donations', DonationsController::class)->middleware(['auth:admin']);//->name('categoryOption.');
        Route::get('deliveries/data-table', [DeliveryController::class, 'dataTable'])->middleware(['auth:admin'])->name('deliveries.dataTable');
        Route::resource('deliveries', DeliveryController::class)->middleware(['auth:admin']);//->name('categoryOption.');
        Route::get('foods/data-table', [FoodController::class, 'dataTable'])->middleware(['auth:admin'])->name('foods.dataTable');
        Route::post('/foods/upload-img', [FoodController::class, 'uploadImg'])->name('foods.uploadImg');

        Route::resource('foods', FoodController::class)->middleware(['auth:admin']);//->name('categoryOption.');

        Route::get('monthly-help/data-table', [MonthlyHelpController::class, 'dataTable'])->middleware(['auth:admin'])->name('monthly-help.dataTable');

        Route::resource('monthly-help', MonthlyHelpController::class)->middleware(['auth:admin']);//->name('categoryOption.');

        Route::get('food-requests/data-table', [FoodRequestsConroller::class, 'dataTable'])->middleware(['auth:admin'])->name('food-requests.dataTable');
        Route::post('food-requests/accept', [FoodRequestsConroller::class, 'accept'])->middleware(['auth:admin'])->name('food-requests.accept');

        Route::delete('food-requests/refuse', [FoodRequestsConroller::class, 'refuse'])->middleware(['auth:admin'])->name('food-requests.refuse');

        Route::resource('food-requests', FoodRequestsConroller::class)->middleware(['auth:admin']);//->name('categoryOption.');



        Route::get('donation-helps/data-table', [DonationHelpController::class, 'dataTable'])->middleware(['auth:admin'])->name('donation-helps.dataTable');
        Route::post('donation-helps/accept', [DonationHelpController::class, 'acceptDonation'])->middleware(['auth:admin'])->name('donation-helps.accept');
        Route::delete('donation-helps/refuse', [DonationHelpController::class, 'refuseDonation'])->middleware(['auth:admin'])->name('donation-helps.refuse');
        Route::post('donation-helps/upload-img', [DonationHelpController::class, 'uploadImg'])->name('donation-helps.uploadImg');
        Route::resource('donation-helps', DonationHelpController::class)->middleware(['auth:admin']);//->name('categoryOption.');

    });


});

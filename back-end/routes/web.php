<?php

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
        Route::get('/', [App\Http\Controllers\HomeController::class, 'Dashboard'])->name('Dashboard');
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/users/data-table', [App\Http\Controllers\Users\UsersController::class, 'dataTable'])->name('users.dataTable');
        Route::resource('users', \App\Http\Controllers\Users\UsersController::class)->middleware(['auth:admin']);
        Route::get('/categories/data-table', [App\Http\Controllers\Category\CategoryController::class, 'dataTable'])->name('categories.dataTable');
        Route::post('/categories/upload-img', [App\Http\Controllers\Category\CategoryController::class, 'uploadImg'])->name('categories.uploadImg');
        Route::get('categories/list-for-filters', [App\Http\Controllers\API\Category\CategoryController::class, 'index'])->name('categories.listForFilter');
        Route::resource('categories', \App\Http\Controllers\Category\CategoryController::class)->middleware(['auth:admin']);
        Route::get('/category-option/data-table', [App\Http\Controllers\Category\CategoryOptionsController::class, 'dataTable'])->name('category-option.dataTable');
        Route::resource('category-option', \App\Http\Controllers\Category\CategoryOptionsController::class)->middleware(['auth:admin']);//->name('categoryOption.');
        Route::get('/uploads/index', [App\Http\Controllers\Uploads\UploadsController::class, 'index'])->name('uploads.index');
        Route::post('/uploads/upload', [App\Http\Controllers\Uploads\UploadsController::class, 'uploadFiles'])->name('uploads.uploadFiles');
        Route::get('/donation-types/data-table', [App\Http\Controllers\Donations\DonationsTypeController::class, 'dataTable'])->name('donation-types.dataTable');
        Route::resource('donation-types', \App\Http\Controllers\Donations\DonationsTypeController::class)->middleware(['auth:admin']);//->name('categoryOption.');
        Route::get('donations/data-table', [\App\Http\Controllers\Donations\DonationsController::class, 'dataTable'])->middleware(['auth:admin'])->name('donations.dataTable');
        Route::post('donations/accept', [\App\Http\Controllers\Donations\DonationsController::class, 'acceptDonation'])->middleware(['auth:admin'])->name('donations.accept');
        Route::resource('donations', \App\Http\Controllers\Donations\DonationsController::class)->middleware(['auth:admin']);//->name('categoryOption.');
        Route::get('deliveries/data-table', [\App\Http\Controllers\Delivery\DeliveryController::class, 'dataTable'])->middleware(['auth:admin'])->name('deliveries.dataTable');
        Route::resource('deliveries', \App\Http\Controllers\Delivery\DeliveryController::class)->middleware(['auth:admin']);//->name('categoryOption.');
    });


});

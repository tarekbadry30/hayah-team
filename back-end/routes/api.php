<?php

use App\Http\Controllers\API\DonationHelp\DonationHelpController;
use App\Http\Controllers\API\DonationType\DonationTypeController;
use App\Http\Controllers\API\FormSheet\FormSheetController;
use App\Http\Controllers\Settings\SettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth\APIController;
use \App\Http\Controllers\API\Category\CategoryController;
use \App\Http\Controllers\API\Donations\DonationsController;
use \App\Http\Controllers\API\Delivery\DeliveryController;
use \App\Http\Controllers\API\Foods\FoodsController;
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
Route::post('login',[APIController::class,'usersLogin']);
Route::post('register',[APIController::class,'usersRegister']);
Route::get('about',[SettingsController::class,'forApi']);
Route::get('contact-info',[SettingsController::class,'contactInfo']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix'=>'donations'], function() {
    Route::get('list', [DonationTypeController::class, 'index']);//->name('api.category.list');
    Route::get('urgent', [CategoryController::class, 'urgent']);//->name('api.category.list');
    Route::get('category/list', [CategoryController::class, 'index']);//->name('api.category.list');
    Route::get('category/list/all', [CategoryController::class, 'all'])->name('api.category.list');
    Route::post('/create', [DonationsController::class, 'store'])->middleware(['auth:sanctum']);
    Route::post('/financial/create', [DonationsController::class, 'createFinanceDonation'])->middleware(['auth:sanctum']);
});

Route::group(['prefix'=>'delivery'],function () {
    Route::post('login',[APIController::class,'driversLogin']);
    Route::group(['middleware'=>'auth:delivery_api'],function () {
        Route::apiResource('orders/',DeliveryController::class);
    });
});
Route::group(['prefix'=>'food'],function () {
    Route::get('/',[FoodsController::class,'index']);
    Route::post('/store',[FoodsController::class,'store']);
    /*Route::group(['middleware'=>'auth:delivery_api'],function () {
        Route::apiResource('orders/',DeliveryController::class);
    });*/
});

Route::group(['prefix'=>'donations-help','middleware'=>['auth:sanctum']],function () {
    Route::get('/',[DonationHelpController::class,'index']);
    Route::post('/create',[DonationHelpController::class,'store']);
    //Route::post('/store',[FoodsController::class,'store']);
    /*Route::group(['middleware'=>'auth:delivery_api'],function () {
        Route::apiResource('orders/',DeliveryController::class);
    });*/
});
Route::group(['prefix'=>'form-sheet','middleware'=>['auth:sanctum']],function () {
    Route::get('/',[FormSheetController::class,'index']);
    Route::post('/answer',[FormSheetController::class,'store']);
    //Route::post('/store',[FoodsController::class,'store']);
    /*Route::group(['middleware'=>'auth:delivery_api'],function () {
        Route::apiResource('orders/',DeliveryController::class);
    });*/
});

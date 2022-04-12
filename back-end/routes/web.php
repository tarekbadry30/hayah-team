<?php

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\CategoryOptionsController;
use App\Http\Controllers\ContactUs\ContactUsController;
use App\Http\Controllers\Delivery\DeliveryController;
use App\Http\Controllers\Donations\DonationsController;
use App\Http\Controllers\Donations\DonationsTypeController;
use App\Http\Controllers\DontationHelp\DonationHelpController;
use App\Http\Controllers\DontationHelp\DonationHelpAsksController;
use App\Http\Controllers\Food\FoodController;
use App\Http\Controllers\Food\FoodRequestsConroller;
use App\Http\Controllers\Food\MonthlyHelpController;
use App\Http\Controllers\FormSheet\FormSheetController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Settings\PhoneContactController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Settings\VisionController;
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
    return view('FrontWebsite.index');
});
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware'=>[
        'localizationRedirect',
        'localeSessionRedirect',
        'localeViewPath',
    ]
], function() {
    Auth::routes();
    Route::get('/', [FrontendController::class,'index']);
    Route::post('/receive-message',[ContactUsController::class,'receiveMessage'])->name('website.receiveMessage');

    Route::group(['middleware'=>['auth:admin']],function () {
        Route::get('/dashboard', [HomeController::class, 'Dashboard'])->name('Dashboard');
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        Route::get('/users/data-table', [UsersController::class, 'dataTable'])->name('users.dataTable');
        Route::get('/users/export', [UsersController::class, 'export'])->name('users.export');
        Route::get('/users/import', [UsersController::class, 'importPage'])->name('users.importPage');
        Route::post('/users/import-data', [UsersController::class, 'importData'])->name('users.import');
        Route::resource('users', UsersController::class)->middleware(['auth:admin']);

        Route::get('/categories/data-table', [CategoryController::class, 'dataTable'])->name('categories.dataTable');
        Route::post('/categories/upload-img', [CategoryController::class, 'uploadImg'])->name('categories.uploadImg');
        Route::get('categories/list-for-filters', [App\Http\Controllers\API\Category\CategoryController::class, 'index'])->name('categories.listForFilter');
        Route::get('/categories/export', [CategoryController::class, 'export'])->name('categories.export');
        Route::get('/categories/import', [CategoryController::class, 'importPage'])->name('categories.importPage');
        Route::post('/categories/import', [CategoryController::class, 'importData'])->name('categories.import');
        Route::resource('categories', CategoryController::class)->middleware(['auth:admin']);

        Route::get('/category-option/data-table', [CategoryOptionsController::class, 'dataTable'])->name('category-option.dataTable');
        Route::get('/category-option/export', [CategoryOptionsController::class, 'export'])->name('category-option.export');
        Route::get('/category-option/import', [CategoryOptionsController::class, 'importPage'])->name('category-option.importPage');
        Route::post('/category-option/import-data', [CategoryOptionsController::class, 'importData'])->name('category-option.import');
        Route::resource('category-option', CategoryOptionsController::class)->middleware(['auth:admin']);//->name('categoryOption.');

        Route::get('/uploads/index', [UploadsController::class, 'index'])->name('uploads.index');
        Route::post('/uploads/upload', [UploadsController::class, 'uploadFiles'])->name('uploads.uploadFiles');

        Route::get('/donation-types/data-table', [DonationsTypeController::class, 'dataTable'])->name('donation-types.dataTable');
        Route::post('donation-types/upload-img', [DonationsTypeController::class, 'uploadImg'])->name('donation-types.uploadImg');
        Route::get('/donation-types/import', [DonationsTypeController::class, 'importPage'])->name('donation-types.importPage');
        Route::post('/donation-types/import-data', [DonationsTypeController::class, 'importData'])->name('donation-types.importData');
        Route::get('donation-types/export', [DonationsTypeController::class, 'export'])->name('donation-types.export');
        Route::resource('donation-types', DonationsTypeController::class)->middleware(['auth:admin']);//->name('categoryOption.');

        Route::get('donations/data-table', [DonationsController::class, 'dataTable'])->middleware(['auth:admin'])->name('donations.dataTable');
        Route::post('donations/accept', [DonationsController::class, 'acceptDonation'])->middleware(['auth:admin'])->name('donations.accept');
        Route::delete('donations/refuse', [DonationsController::class, 'refuseDonation'])->middleware(['auth:admin'])->name('donations.refuse');
        Route::resource('donations', DonationsController::class)->middleware(['auth:admin']);//->name('categoryOption.');

        Route::get('deliveries/data-table', [DeliveryController::class, 'dataTable'])->middleware(['auth:admin'])->name('deliveries.dataTable');
        Route::get('/deliveries/export', [DeliveryController::class, 'export'])->name('deliveries.export');
        Route::get('/deliveries/import', [DeliveryController::class, 'importPage'])->name('deliveries.importPage');
        Route::post('/deliveries/import-data', [DeliveryController::class, 'importData'])->name('deliveries.import');
        Route::resource('deliveries', DeliveryController::class)->middleware(['auth:admin']);//->name('categoryOption.');

        Route::get('foods/data-table', [FoodController::class, 'dataTable'])->middleware(['auth:admin'])->name('foods.dataTable');
        Route::post('foods/upload-img', [FoodController::class, 'uploadImg'])->name('foods.uploadImg');
        Route::get('foods/export', [FoodController::class, 'export'])->name('foods.export');
        Route::get('foods/import', [FoodController::class, 'importPage'])->name('foods.importPage');
        Route::post('foods/import', [FoodController::class, 'importData'])->name('foods.import');
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


        Route::get('donation-help-ask/', [DonationHelpAsksController::class, 'index'])->middleware(['auth:admin'])->name('donation-help-asks.index');
        Route::get('donation-help-ask/data-table', [DonationHelpAsksController::class, 'dataTable'])->middleware(['auth:admin'])->name('donation-help-asks.dataTable');
        Route::post('donation-help-ask/accept', [DonationHelpAsksController::class, 'accept'])->middleware(['auth:admin'])->name('donation-help-asks.accept');
        Route::delete('donation-help-ask/refuse', [DonationHelpAsksController::class, 'refuse'])->middleware(['auth:admin'])->name('donation-help-asks.refuse');


        Route::get('food-requests/data-table', [FoodRequestsConroller::class, 'dataTable'])->middleware(['auth:admin'])->name('food-requests.dataTable');
        Route::resource('food-requests', FoodRequestsConroller::class)->middleware(['auth:admin']);//->name('categoryOption.');

        Route::get('contact-us/export', [ContactUsController::class, 'export'])->middleware(['auth:admin'])->name('contact-us.export');

        Route::get('contact-us/data-table', [ContactUsController::class, 'dataTable'])->middleware(['auth:admin'])->name('contact-us.dataTable');
        Route::resource('contact-us', ContactUsController::class)->middleware(['auth:admin']);//->name('categoryOption.');


        Route::get('form-sheet/export', [FormSheetController::class, 'export'])->middleware(['auth:admin'])->name('form-sheet.export');

        Route::get('form-sheets/data-table', [FormSheetController::class, 'dataTable'])->middleware(['auth:admin'])->name('form-sheets.dataTable');
        Route::resource('form-sheets', FormSheetController::class)->middleware(['auth:admin']);//->name('categoryOption.');




        Route::group(['prefix' => 'settings','as'=>'settings.'], function () {
            Route::get('/', [SettingsController::class, 'index'])->middleware(['auth:admin'])->name('index');
            Route::get('/edit', [SettingsController::class, 'edit'])->middleware(['auth:admin'])->name('edit');
            Route::get('/update', [SettingsController::class, 'update'])->middleware(['auth:admin'])->name('update');
            Route::get('/phone/import', [PhoneContactController::class, 'importPage'])->middleware(['auth:admin'])->name('phone.importPage');
            Route::post('/phone/importData', [PhoneContactController::class, 'importData'])->middleware(['auth:admin'])->name('phone.import');
            Route::get('/phone/export', [PhoneContactController::class, 'export'])->middleware(['auth:admin'])->name('phone.export');
            Route::resource('phone',PhoneContactController::class);
        });
    });


});

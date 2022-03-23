<?php

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
    $user = auth()->guard('admin')->user();
    if($user)
        return $user;
    return view('welcome');
});

Auth::routes();
Route::get('/users/data-table', [App\Http\Controllers\Users\UsersController::class, 'dataTable'])->name('users.dataTable');
Route::resource('users',\App\Http\Controllers\Users\UsersController::class)->middleware(['auth:admin']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

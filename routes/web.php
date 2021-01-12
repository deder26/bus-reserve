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
    return view('welcome');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'custom.guest'], function () {
    Route::get('custom/login', [App\Http\Controllers\CustomLoginController::class, 'showLoginForm'])->name('custom.login');
    Route::post('custom/login', [App\Http\Controllers\CustomLoginController::class, 'login'])->name('custom.auth');
});

Route::group(['middleware' => 'custom.auth'], function () {
    Route::get('/custom/home',[App\Http\Controllers\AdminController::class, 'index'])->name('custom.home');
});




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great   !
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('users')->namespace('Users')->name('users.')->middleware(['web','auth'])->group(function(){
    Route::get('/', [UsersController::class,'index'])->name('dashboard');
});

Route::prefix('data')->namespace('Data')->middleware(['web','auth'])->group(base_path('routes/web/data.php'));

Route::get('/verify',[App\Http\Controllers\Auth\RegisterController::class,'verifyUser'])->name('verify.user');
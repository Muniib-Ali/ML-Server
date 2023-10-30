<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
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

Route::get('/create-account', function () {
    return view('create-account');
});

Route::post('/createaccount', [RegistrationController::class, 'registrate']);


Route::get('/login', function () {
    return view('login');
});

Route::post('/login', [LoginController::class, 'login']);

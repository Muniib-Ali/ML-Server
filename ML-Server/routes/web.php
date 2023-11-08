<?php

use App\Http\Controllers\InitializeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
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
Route::middleware(['initializeSite'])->group(function(){


    Route::get('/createaccount', function () {
        return view('create-account');
    });
    
    Route::post('/createaccount', [RegistrationController::class, 'registrate']);
    
    
    Route::get('/login', function () {
        return view('login');
    });
    
    Route::get('/admin', function () {
        return view('admin-home');
    });
    
    Route::get('/', function () {
        return view('admin-home');
    });
    
    
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/logout', [LogoutController::class, 'logout']);
});


Route::get('/initialize', [InitializeController::class, 'show']);
Route::post('/initialize', [InitializeController::class, 'registrate']);



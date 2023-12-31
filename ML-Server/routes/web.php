<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\InitializeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
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

Route::middleware(['initializeSiteOnce'])->group(function(){

    Route::get('/initialize', [InitializeController::class, 'show']);
    Route::post('/initialize', [InitializeController::class, 'registrate']);


});



Route::middleware(['userauth'])->group(function(){

    Route::get('/', function () {
        return view('user-home');
    });

    Route::get('/home', function () {
        return view('user-home');
    });

    Route::get('/credits', [UserController::class, 'show']);
    Route::post('/creditrequest', [UserController::class, 'requestCredits']);
    Route::get('/logout', [LogoutController::class, 'logout']);
    Route::get('/bookings', [BookingsController::class, 'show']);
    Route::get('/get-resources-by-group', [BookingsController::class, 'getResourcesByGroup']);
    Route::post('/bookings', [BookingsController::class, 'book']);



});


Route::middleware(['adminauth'])->group(function(){

    Route::get('/admin', function () {
        return view('admin-home');
    });
    

    
    Route::get('/users', [AdminController::class, 'listUsers']);

    Route::post('/admin/change-status/{id}', [AdminController::class, 'changeStatus']);

    Route::post('/admin/resource/change-status/{id}', [AdminController::class, 'changeResourceStatus']);
    Route::post('/admin/resource/delete/{id}', [AdminController::class, 'deleteResource']);
    Route::get('requests' , [AdminController::class, 'listRequests']);

    Route::post('requests/change-status/{id}/accept', [AdminController::class, 'acceptRequest']);
    Route::post('requests/change-status/{id}/decline', [AdminController::class, 'declineRequest']);
    Route::get('/logout', [LogoutController::class, 'logout']);

    Route::get('/resources', [AdminController::class, 'showResourceRequest']);

    Route::post('/createresourcegroup', [AdminController::class, 'createResourceGroup']);

    Route::post('/createresource', [AdminController::class, 'createResource']);


    

});

Route::middleware(['guestauth'])->group(function(){
    Route::get('/signup', function () {
        return view('create-account');
    });
    
    Route::post('/createaccount', [RegistrationController::class, 'registrate']);
    
    
    Route::get('/login', function () {
        return view('login');
    });
    
   
    Route::post('/login', [LoginController::class, 'login']);
   
    

});

Route::get('/logout', [LogoutController::class, 'logout']);




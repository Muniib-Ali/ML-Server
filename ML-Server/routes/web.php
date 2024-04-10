<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\InitializeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


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

   

    Route::get('/credits', [UserController::class, 'show']);
    Route::post('/creditrequest', [UserController::class, 'requestCredits']);
    Route::get('/logout', [LogoutController::class, 'logout']);
    Route::get('/', [BookingsController::class, 'show']);
    Route::get('/get-resources-by-group', [BookingsController::class, 'getResourcesByGroup']);
    Route::post('/bookings', [BookingsController::class, 'book']);
    Route::get('/list-bookings', [BookingsController::class, 'showBookings']);
    Route::post('/delete-booking/{id}', [BookingsController::class, 'deleteBooking']);
    Route::get('/update-account', [UserController::class, 'showUpdate']);
    Route::post('/update-account', [UserController::class, 'updateAccount']);





});


Route::middleware(['adminauth'])->group(function(){

   
    


    
    Route::get('/users', [AdminController::class, 'listUsers']);

    Route::post('/admin/change-status/{id}', [AdminController::class, 'changeStatus']);
    Route::post('/admin/change-activation/{id}', [AdminController::class, 'changeActivationStatus']);


    Route::post('/admin/resource/change-status/{id}', [AdminController::class, 'changeResourceStatus']);
    Route::post('/admin/resource/delete/{id}', [AdminController::class, 'deleteResource']);
    Route::get('/requests' , [AdminController::class, 'listRequests']);

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
   
    Route::get('/password-reset', [LoginController::class, 'showResetPage']);

    Route::post('/password-reset', [LoginController::class, 'sendPasswordResetEmail']);

    Route::get('/reset-password/{token}', function (string $token) {
        return view('reset-password', ['token' => $token]);
    })->middleware('guest')->name('password.reset');


    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
    
        return $status === Password::PASSWORD_RESET
        ? redirect('/login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
    })->middleware('guest')->name('password.update');


});

Route::get('/logout', [LogoutController::class, 'logout']);


Route::get('/get-currentbookings', [BookingsController::class, 'jsonApi']);

Route::get('/get-thresholds', [BookingsController::class, 'getThreshold']);

Route::get('/get-users', [BookingsController::class, 'getUsers']);







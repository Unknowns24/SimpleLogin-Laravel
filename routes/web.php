<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;

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

/////////////////
// Auth Routes //
/////////////////

// Login Routes
Route::get('login',                          [ AuthController::class,  'loginForm'                  ])->name('login');
Route::post('login',                         [ AuthController::class,  'login'                      ])->name('login');

// Register Routes
Route::get('register',                       [ AuthController::class,  'registerForm'               ])->name('register');
Route::post('register',                      [ AuthController::class,  'register'                   ])->name('register');

// Password Reset Routes
Route::get('forgot-password',                [ AuthController::class,  'forgetPassForm'             ])->name('password.forgot');
Route::get('reset-password',                 [ AuthController::class,  'sendResetPasswordEmail'     ])->name('reset.sendMail');
Route::get('reset-password/{userid}/{code}', [ AuthController::class,  'verifyPasswordReset'        ])->name('reset.verify');
Route::post('reset-password/{userid}',       [ AuthController::class,  'ResetPassword'              ])->name('reset.password');

// Mail Verification Routes
Route::get('/MailVerification',              [ AuthController::class,  'verification'               ])->name('verification.notice')->middleware('auth');
Route::get('MailVerification/resend',        [ AuthController::class,  'ResendMail'                 ])->name('mail.resend');
Route::get('verifyMail/{userid}/{code}',     [ AuthController::class,  'verifyMail'                 ])->name('mail.verify');

// Logout Route
Route::post('logout',                        [ AuthController::class,  'logout'                     ])->name('logout');

// Route to test verification 
Route::get('home', function() {
    return "logged!";
})->middleware('auth')->middleware('verified')->name('mail.verify');

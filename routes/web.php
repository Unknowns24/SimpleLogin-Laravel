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

// Auth Routes 
Route::get('login',     [ AuthController::class,  'loginForm'     ])->name('login');
Route::get('register',  [ AuthController::class,  'registerForm'  ])->name('register');
Route::post('login',    [ AuthController::class,  'login'         ])->name('login');
Route::post('register', [ AuthController::class,  'register'      ])->name('register');
Route::post('logout',   [ AuthController::class,  'logout'        ])->name('logout');
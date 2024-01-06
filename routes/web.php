<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::post( '/user-registration', [UserController::class, 'UserRegistration'] );
Route::post( '/user-login', [UserController::class, 'UserLogin'] );
Route::get( '/user-profile', [UserController::class, 'UserProfile'] )->middleware( 'auth:sanctum' );
Route::get( '/logout', [UserController::class, 'UserLogout'] )->middleware( 'auth:sanctum' );
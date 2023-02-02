<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\Auth\ApiPasswordController;
use App\Http\Controllers\Api\Auth\ApiProfileController;
use App\Http\Controllers\Api\Auth\ApiPasswordResetLinkController;
use App\Http\Controllers\Api\Auth\NewPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::get('/profile/{user}',[ApiProfileController::class,'show']);
    Route::put('/update',[ApiProfileController::class,'update']);
    Route::put('/password-update',[ApiPasswordController::class,'updatePassword']);
});
Route::post('/login', [ApiAuthController::class, 'login']);
Route::patch('/password-reset',[NewPasswordController::class,'store']);
Route::post('/password-reset-link',[ApiPasswordResetLinkController::class,'sendPasswordResetLink']);
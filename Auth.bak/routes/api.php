<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\API\V1\AuthController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

// Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
//     Route::apiResource('auth', AuthController::class)->names('auth');
// });


Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
     Route::post('/login', [AuthController::class, 'login']);
});

<?php

use Illuminate\Support\Facades\Route;
use Modules\UCM\Http\Controllers\UCMController;

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

Route::group([], function () {
    Route::resource('ucm', UCMController::class)->names('ucm');
});

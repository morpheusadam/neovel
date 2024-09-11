<?php

use Illuminate\Support\Facades\Route;
use Modules\ThemeManager\Http\Controllers\ThemeManagerController;

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
    Route::resource('thememanager', ThemeManagerController::class)->names('thememanager');
});

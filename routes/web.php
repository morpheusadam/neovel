<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Post\CommentController;

// // مسیرهای مربوط به احراز هویت
// Route::get('login', [LoginController::class, 'login']);
// Route::post('register', [RegisterController::class, 'register']);
// Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
// Route::post('password/reset', [ResetPasswordController::class, 'reset']);

// // مسیرهای مربوط به کاربران
// Route::get('users', [UserController::class, 'index']);
// Route::get('users/{id}', [UserController::class, 'show']);
// Route::get('profile/{id}', [ProfileController::class, 'show']);
// Route::post('profile/{id}', [ProfileController::class, 'update']);

// // مسیرهای مربوط به پست‌ها
// Route::get('blog/', [PostController::class, 'index']);
// Route::get('blog/{id}', [PostController::class, 'show']);
// Route::post('blog/{id}/comments', [CommentController::class, 'store']);


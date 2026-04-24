<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('posts', PostController::class)->only(['index', 'show']);
Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/myposts', [PostController::class, 'myPosts']);
    Route::get('/myposts/{post}', [PostController::class, 'showMyPost']);
   
    // Posts: auth + policy in controller
    Route::apiResource('posts', PostController::class)->except(['index', 'show']);

    // Categories: editor/admin
    Route::middleware('role:editor,admin')->group(function () {
        Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
    });

    // Users: admin only
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('users', UserController::class);
    });
});
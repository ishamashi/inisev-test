<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function() {
    Route::post('create', [UserController::class, 'create']);
    Route::post('{id}/update', [UserController::class, 'update']);
    Route::delete('{id}/delete', [UserController::class, 'delete']);
});

Route::prefix('website')->group(function() {
    Route::post('create', [WebsiteController::class, 'create']);
    Route::post('{id}/update', [WebsiteController::class, 'update']);
    Route::delete('{id}/delete', [WebsiteController::class, 'delete']);
});

Route::prefix('post')->group(function() {
    Route::post('create', [PostController::class, 'create']);
    Route::post('{id}/update', [PostController::class, 'update']);
    Route::delete('{id}/delete', [PostController::class, 'delete']);
});

Route::prefix('subscribe')->group(function() {
    Route::post('/', [SubscriptionController::class, 'subscribe']);
    Route::delete('{id}/undo', [SubscriptionController::class, 'unsubscribe']);
});

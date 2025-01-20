<?php

use App\Http\Controllers\Api\Auth\ {
    AuthController,
    EmailVerificationController,
    PasswordResetController
};
use App\Http\Controllers\Api\Posts\PostController;
use App\Http\Controllers\Api\Register\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/signin', [AuthController::class, 'signin']);
Route::get('/verify/{hash}', [EmailVerificationController::class, 'verify']);
Route::post('/resendEmail', [EmailVerificationController::class, 'resendEmail']);
Route::post('/forgot-password', [PasswordResetController::class, 'sendPasswordResetLink'])->middleware('guest');
Route::post('/password-reset', [PasswordResetController::class, 'passwordReset']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/logout', [AuthController::class, 'logout']);

    /** User's Routes */
    Route::post('/users/register', [UserController::class, 'create']);
    Route::put('/users/edit', [UserController::class, 'update']);
    Route::get('/users/{user_id}', [UserController::class, 'show']);

    /** Post's Routes */
    Route::apiResource('/posts', PostController::class);
});

Route::get('/api', function() {
    return response()->json(['status' => 'Success', 'message' => 'API is running']);
});

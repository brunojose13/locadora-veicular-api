<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/unauthorized', [AuthController::class, 'unauthorize'])->name('unauthorized');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me', [AuthController::class, 'recoverAuthenticated'])->name('authenticated.user');
});

Route::prefix('users')->group(function () {
    Route::post('/create', [UserController::class, 'store']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::put('/update', [UserController::class, 'update']);
        Route::delete('/delete', [UserController::class, 'destroy']);
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
    });
});

Route::prefix('cars')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/create', [CarController::class, 'store']);
        Route::put('/update', [CarController::class, 'update']);
        Route::get('/', [CarController::class, 'index']);
        Route::get('/list-deleted', [CarController::class, 'destroyedList']);
        Route::get('/{id}', [CarController::class, 'show']);
        Route::delete('/{id}/delete', [CarController::class, 'destroy']);
    });
});

<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourtController;
use App\Http\Controllers\Api\ReservationController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/courts', [CourtController::class, 'index']);
    Route::post('/courts', [CourtController::class, 'store']);
    Route::get('/courts/{court}', [CourtController::class, 'show']);
    Route::put('/courts/{court}', [CourtController::class, 'update']);
    Route::delete('/courts/{court}', [CourtController::class, 'destroy']);

    Route::get('/courts/{court}/availability', [CourtController::class, 'availability']);

    Route::post('/reservations', [ReservationController::class, 'store']);

});
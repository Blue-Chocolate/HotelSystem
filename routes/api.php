<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApiReservationController;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user',       fn(Request $r) => $r->user());
    Route::get('reservations',      [ApiReservationController::class, 'index']);
    Route::post('reservations',     [ApiReservationController::class, 'store']);
    Route::put('reservations/{id}', [ApiReservationController::class, 'update']);
    Route::delete('reservations/{id}', [ApiReservationController::class, 'destroy']);
});

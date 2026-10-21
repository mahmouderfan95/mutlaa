<?php

use App\Http\Controllers\Admin\TripController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use \App\Http\Controllers\Admin\OrderController;

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1');
    Route::middleware(['auth:sanctum','admin'])->group(function () {
        #logout request
        Route::post('logout', [AuthController::class, 'logout']);
        #profile
        Route::get('me', [AuthController::class, 'me']);
        #trips
        Route::apiResource('trips', TripController::class);
        #orders
        Route::apiResource('orders',OrderController::class);
    });

});

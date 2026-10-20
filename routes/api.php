<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Front\TripController;
//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

//
Route::group(['prefix' => 'front/v1'],function(){
    Route::group(['prefix' => 'trips'],function(){
        #get all trips
        Route::get('/',[TripController::class,'index']);
        #get offer trips
        Route::get('offers',[TripController::class,'offers']);
        #get tripe details
        Route::get('/{id}',[TripController::class,'show']);
    });
    Route::get('trips/search',[TripController::class,'search']);
});

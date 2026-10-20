<?php

use App\Http\Controllers\Front\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Front\TripController;
use \App\Http\Controllers\Front\ContactMessageController;
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
        #search for trip
        Route::get('/search',[TripController::class,'search']);
        #create order
        Route::post('create-reservation',[OrderController::class,'store']);
        #get tripe details
        Route::get('/{id}',[TripController::class,'show']);
    });
    Route::post('contact-message',[ContactMessageController::class,'store']);
});

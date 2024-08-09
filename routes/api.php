<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TopupController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register',[RegisterController::class,'register']);
Route::post('login',[LoginController::class,'login']);

//topup
Route::post('topup', [TopupController::class, 'topUp'])->middleware('auth:sanctum');
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TransactionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register',[RegisterController::class,'register']);
Route::post('login',[LoginController::class,'login']);

//with authentication
Route::post('topup', [TopupController::class, 'topUp'])->middleware('auth:sanctum');
Route::post('pay', [PaymentController::class, 'payment'])->middleware('auth:sanctum');
Route::post('transfer', [TransferController::class, 'transfer'])->middleware('auth:sanctum');
Route::get('history', [TransactionController::class, 'getTransactionHistory'])->middleware('auth:sanctum');
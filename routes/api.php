<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RestauantController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/verify_otp', [AuthController::class, 'verifyOtp']);
Route::post('/resendOtp', [AuthController::class, 'resendOtp']);
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');

Route::get('/showAll',[RestauantController::class,'index']);
Route::get('/showProduct',[RestauantController::class,'showProduct']);


//للاحطتياط
Route::post('/send_otp', [AuthController::class, 'sendOtpCode']);

Route::apiResource('/orders',OrderController::class);

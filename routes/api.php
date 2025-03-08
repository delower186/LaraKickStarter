<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\BlogController;
use App\Http\Controllers\API\V1\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('user', [AuthController::class,'user']);
    Route::apiResource('users', UserController::class);
    Route::apiResource('blogs', BlogController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::post('logout', [AuthController::class,'logout']);
});

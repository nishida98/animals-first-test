<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetAdoptionController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/auth/login', [AuthController::class, 'login']);
Route::patch('/users/{id}/password', [UserController::class, 'reset']);
Route::apiResource('pets', PetController::class);
Route::patch('/pets/{id}/adoption', [PetAdoptionController::class, 'adopt']);

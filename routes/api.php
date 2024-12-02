<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;


Route::middleware(['guest'])->group(function () {

    Route::post('/sign-in-with-google', [AuthController::class, 'signInWithGoogle']);
   
});
Route::get('/user', function (Request $request) {
    return $request->user();

   
})->middleware('auth:sanctum');


Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('user', [AuthController::class, 'userDetails']);
    Route::get('/courses/available', [CourseController::class, 'getAvailableCourses']);
});

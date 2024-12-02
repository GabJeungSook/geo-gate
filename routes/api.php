<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::middleware(['guest'])->group(function () {

    Route::post('/sign-in-with-google', [AuthController::class, 'signInWithGoogle']);
   
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

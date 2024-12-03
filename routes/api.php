<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FCMController;
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


Route::get('/send-notification', function(){
    FCMController::sendPushNotification('fUyNeZkhQ-6wn2-S-Jn48C:APA91bHZSBE0Lu8bOBpc98TPcXi6BywPoTpFr9aXfQjuJjIhK_6H8mlaoNRdpu_U2YXbLghaM-v1DiNH_8jMLcrhLcoCoPL4eiF8ioZp8oacivLXBqi1SC8', 'Task Assigned', 'test', [

        'notification' => 'task',
    ]);
});

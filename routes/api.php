<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FCMController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DeviceController;


Route::middleware(['guest'])->group(function () {

    Route::post('/sign-in-with-google', [AuthController::class, 'signInWithGoogle']);
    

});
Route::get('/user', function (Request $request) {
    return $request->user();


})->middleware('auth:sanctum');


Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('user', [AuthController::class, 'userDetails']);
    Route::get('/courses/available', [CourseController::class, 'getAvailableCourses']);
    Route::put('user/details', [AuthController::class, 'updateUserDetails']);
   

    Route::post('devices/register', [DeviceController::class, 'storeOrUpdate']);
    Route::delete('devices/{deviceId}', [DeviceController::class, 'destroy']);


    Route::get('active-event', [EventController::class,'getEvent']);

    
});


Route::get('/send-notification', function(){
    $response = FCMController::sendPushNotification(
        'fUyNeZkhQ-6wn2-S-Jn48C:APA91bHZSBE0Lu8bOBpc98TPcXi6BywPoTpFr9aXfQjuJjIhK_6H8mlaoNRdpu_U2YXbLghaM-v1DiNH_8jMLcrhLcoCoPL4eiF8ioZp8oacivLXBqi1SC8',
        'Task Assigned',
        'This is a test message',
        ['notification' => 'task']
    );

    return $response;
});

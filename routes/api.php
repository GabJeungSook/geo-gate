<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FCMController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PreRegistrationController;


Route::middleware(['guest'])->group(function () {

    Route::post('/sign-in-with-google', [AuthController::class, 'signInWithGoogle']);
    

});
Route::get('/user', function (Request $request) {
    return $request->user();


})->middleware('auth:sanctum');


Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', [AuthController::class, 'userDetails']);
    Route::put('/user/details', [AuthController::class, 'updateUserDetails']);

    Route::post('/devices/register', [DeviceController::class, 'storeOrUpdate']);
    Route::delete('/devices/{deviceId}', [DeviceController::class, 'destroy']);
    
    
    Route::get('/courses/available', [CourseController::class, 'getAvailableCourses']);
    Route::get('/active-event', [EventController::class,'getActiveEvent']);
    Route::get('/active-schedule/{eventId}', [EventController::class,'getActiveSchedule']);

    Route::post('/pre-registration', [PreRegistrationController::class, 'createOrUpdatePreRegistration']);


    Route::get('/attendance', [AttendanceController::class, 'index']);
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn']);
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut']);
    Route::post('/attendance/mark-absent', [AttendanceController::class, 'markAbsent']);
    Route::post('/attendance/geofence-out', [AttendanceController::class, 'updateGeofenceOut']);


    
});


Route::get('/send-notification', function(){
    $response = FCMController::sendPushNotification(
        'e43CZDRWT_Sj2_jJGvW0VS:APA91bGH6l3qXU2sdqBMRo677q4bnhMk2UGyh3ZYoq1Fh8dAbsrPY0YN3jaVbAv6Z6KtHCIKGE73tTBGyZbyKDUn0B4D1sDGzJtRYk5TbQgrCRKXIzyNU38',
        'Task Assigned',
        'This is a test message',
        ['notification' => 'task']
    );

    return $response;
});

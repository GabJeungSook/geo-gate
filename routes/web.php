<?php

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Campus;
use App\Models\Event;

Route::get('/', function () {
    return redirect()->route('login');
});



Route::middleware(['guest'])->group(function () {

    Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->middleware('guest')->name('auth.google.redirect');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->middleware('guest')->name('auth.google.callback');
   
});


Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/courses', function () {
    return view('admin.courses');
})->middleware(['auth', 'verified'])->name('courses');

Route::get('/campuses', function () {
    return view('admin.campuses');
})->middleware(['auth', 'verified'])->name('campuses');

Route::get('/add-campus', function () {
    return view('admin.pages.add_campus');
})->middleware(['auth', 'verified'])->name('add_campus');

Route::get('/edit-campus/{record}', function ($record) {
    $campus = Campus::findOrFail($record);
    return view('admin.pages.edit_campus', ['record' => $campus]);
})
    ->middleware(['auth', 'verified'])
    ->name('edit_campus');

Route::get('/events', function () {
    return view('admin.events');
})->middleware(['auth', 'verified'])->name('events');

Route::get('/event-details/{record}', function ($record) {
    $event = Event::findOrFail($record);
    return view('admin.pages.event_details', ['record' => $event]);
})
    ->middleware(['auth', 'verified'])
    ->name('event_details');

Route::get('/select-schedule', function () {
    return view('admin.select_schedule');
})->middleware(['auth', 'verified'])->name('select-schedule');

Route::get('/view-attendance', function () {
    return view('admin.view-attendance');
})->middleware(['auth', 'verified'])->name('view-attendance');

Route::get('/report/pre-registration', function () {
    return view('reports.pre-registration');
})->middleware(['auth', 'verified'])->name('report.pre-registration');

Route::get('/report/attendance', function () {
    return view('reports.attendance');
})->middleware(['auth', 'verified'])->name('report.attendance');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

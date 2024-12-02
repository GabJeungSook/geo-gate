<?php

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});



Route::middleware(['guest'])->group(function () {

    Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->middleware('guest');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->middleware('guest');
   
});


Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/campuses', function () {
    return view('admin.campuses');
})->middleware(['auth', 'verified'])->name('campuses');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

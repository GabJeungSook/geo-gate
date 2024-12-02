<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Campus;

Route::get('/', function () {
    return redirect()->route('login');
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


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

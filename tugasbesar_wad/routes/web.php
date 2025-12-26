<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/events', [DashboardController::class, 'index'])->name('events.index');
Route::get('/venues', [DashboardController::class, 'index'])->name('venues.index');
Route::get('/rankings', [DashboardController::class, 'index'])->name('rankings.index');
Route::get('/certificates', [DashboardController::class, 'index'])->name('certificates.index');
Route::get('/speakers', [DashboardController::class, 'index'])->name('speakers.index');
Route::get('/reviews', [DashboardController::class, 'index'])->name('reviews.index');


// Routing Resource (Otomatis buat rute index, create, store, edit, update, destroy)
Route::resource('events', EventController::class);           // Ketua
Route::resource('venues', VenueController::class);           // Anggota 1
Route::resource('participants', ParticipantController::class); // Anggota 2
Route::resource('speakers', SpeakerController::class);       // Anggota 3
Route::resource('reviews', ReviewController::class);         // Anggota 4



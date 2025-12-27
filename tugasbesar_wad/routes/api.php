<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventApiController;

Route::prefix('events')->group(function () {

    // List Semua Event
    Route::get('/', [EventApiController::class, 'index']);

    // Detail Event
    Route::get('/{id}', [EventApiController::class, 'show']);

    // POST (Create)
    Route::post('/', [EventApiController::class, 'store']);

    // PUT (Update)
    Route::put('/{id}', [EventApiController::class, 'update']);

    // DELETE (Destroy)
    Route::delete('/{id}', [EventApiController::class, 'destroy']);
});

use App\Http\Controllers\Api\VenueApiController;

Route::prefix('venues')->group(function () {
    Route::get('/', [VenueApiController::class, 'index']);
    Route::get('/{id}', [VenueApiController::class, 'show']);
    Route::post('/', [VenueApiController::class, 'store']);
    Route::put('/{id}', [VenueApiController::class, 'update']);
    Route::delete('/{id}', [VenueApiController::class, 'destroy']);
});


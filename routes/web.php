<?php

use App\Http\Controllers\BoardingHouseController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/booking-check', [BookingController::class, 'check'])->name('booking_check');
Route::get('/find-kost', [BoardingHouseController::class, 'find'])->name('find_kost');

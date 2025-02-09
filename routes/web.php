<?php

use App\Http\Controllers\BoardingHouseController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('kost/{slug}', [BoardingHouseController::class, 'show'])->name('kost_show');
Route::get('kost/{slug}/rooms', [BoardingHouseController::class, 'rooms'])->name('kost_rooms');

Route::get('/booking-check', [BookingController::class, 'check'])->name('booking_check');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category_show');
Route::get('/city/{slug}', [CityController::class, 'show'])->name('city_show');
Route::get('/find-kost', [BoardingHouseController::class, 'find'])->name('find_kost');
Route::get('/find-kost-results', [BoardingHouseController::class, 'findResults'])->name('find_kost.results');

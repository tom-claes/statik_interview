<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('reservation');
})->name("reservation.form");

Route::post('/submit-reservation', [ReservationController::class, 'store'])->name("reservation.submit");

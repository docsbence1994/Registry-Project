<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CustomerController;

Route::get('/', [CalendarController::class, 'index']);
Route::get('/customer/events', [CustomerController::class, 'events']);
Route::post('/customer/store', [CustomerController::class, 'store']);
Route::post('/customer/store', [CustomerController::class, 'store']);

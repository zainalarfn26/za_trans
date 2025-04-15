<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\CarsController;
use App\Http\Controllers\User\BookingsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // Mobil untuk dipilih user
    Route::get('/cars', [User\CarsController::class, 'index']);
    Route::get('/cars/{id}', [User\CarsController::class, 'show']);

    // Proses booking
    Route::post('/bookings', [User\BookingsController::class, 'store']);
    
    return $request->user();
});

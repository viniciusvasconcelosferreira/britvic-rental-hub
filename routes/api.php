<?php

use App\Http\Controllers\API\Authentication\AuthController;
use App\Http\Controllers\API\Reservations\ReservationController;
use App\Http\Controllers\API\Users\UserController;
use App\Http\Controllers\API\Vehicles\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    return $request->user();
});

Route::apiResource('vehicle', VehicleController::class)->only(['index']);

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    });
});

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::apiResource('user', UserController::class)->middleware('can:access-admin-reservation');
    Route::apiResource('vehicle', VehicleController::class)->except(['index'])->middleware('can:access-admin-reservation');
    Route::get('/reservation', [ReservationController::class, 'indexAll'])->name('reservation.index_all')->middleware('can:access-admin-reservation');
    Route::get('/reservation/{reservation}', [ReservationController::class, 'showAll'])->name('reservation.show_all')->middleware('can:access-admin-reservation');
    Route::patch('/reservations/{reservation}/update-status', [ReservationController::class, 'updateStatus'])->name('reservation.update_status')->middleware('can:access-admin-reservation');
    Route::get('/vehicles/all', [VehicleController::class, 'indexAll'])->name('vehicle.index_all');
    Route::put('/reservation/{reservation}', [ReservationController::class, 'updateAll'])->name('reservation.update_all')->middleware('can:access-admin-reservation');
    Route::get('/users/all', [UserController::class, 'indexAll'])->name('user.index_all')->middleware('can:access-admin-reservation');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('reservation', ReservationController::class);
});

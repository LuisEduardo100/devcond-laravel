<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BilletController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\FoundAndLostController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WallController;
use App\Http\Controllers\WarningController;

Route::get('/ping', function () {
  return ['pong' => true];
});

Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
  Route::post('/auth/validate', [AuthController::class, 'validateToken']);
  Route::post('/auth/logout', [AuthController::class, 'logout']);

  // Mural de avisos
  Route::get('/walls', [WallController::class, 'getAll']);
  Route::post('/walls/{id}/like', [WallController::class, 'like']);

  // Documentos
  Route::get('/docs', [DocController::class, 'getAll']);

  // Livros de ocorrências
  Route::get('/warnings', [WarningController::class, 'getMyWarnings']);
  Route::post('/warnings', [WarningController::class, 'setWarning']);
  Route::post('/warning/file', [WarningController::class, 'addWarningFile']);

  // Boletos
  Route::get('/billets', [BilletController::class, 'getAll']);

  // Achados e perdidos
  Route::get('/found-and-lost', [FoundAndLostController::class, 'getAll']);
  Route::post('found-and-lost', [FoundAndLostController::class, 'insert']);
  Route::put('found-and-lost', [FoundAndLostController::class, 'update']);

  // Unidade 
  Route::get('/unit/{id}', [UnitController::class, 'getInfo']);
  Route::post('/unit/{id}/add-person', [UnitController::class, 'addPerson']);
  Route::post('/unit/{id}/add-vehicle', [UnitController::class, 'addVehicle']);
  Route::post('/unit/{id}/add-pet', [UnitController::class, 'addPet']);
  Route::post('/unit/{id}/remove-person', [UnitController::class, 'removePerson']);
  Route::post('/unit/{id}/remove-vehicle', [UnitController::class, 'removeVehicle']);
  Route::post('/unit/{id}/remove-pet', [UnitController::class, 'removePet']);

  // Reservas
  Route::get('/reservations', [ReservationController::class, 'getReservations']);
  Route::post('/my-reservations', [ReservationController::class, 'setMyReservations']);

  Route::get('/reservation/{id}/disabled-dates', [ReservationController::class, 'getDisabledDates']);
  Route::get('/reservation/{id}/times', [ReservationController::class, 'getTimes']);

  Route::get('/my-reservations/{id}', [ReservationController::class, 'getMyReservation']);
  Route::post('/my-reservations/{id}', [ReservationController::class, 'delMyReservation']);
});

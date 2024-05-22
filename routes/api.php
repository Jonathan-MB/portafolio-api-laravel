<?php

use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\NoteController;
use App\Http\Controllers\api\RolController;
use App\Http\Controllers\api\StateController;
use App\Http\Controllers\api\VisibilityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// generacion de rutas para users
Route::resource('user', UserController::class);

// generacion de rutas para notes
Route::resource('note', NoteController::class);

// generacion de rutas para rols
Route::resource('rol', RolController::class);

// generacion de rutas para states
Route::resource('state', StateController::class);

// generacion de rutas para visibility
Route::resource('Visibility', VisibilityController::class);

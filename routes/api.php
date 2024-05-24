<?php

use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\NoteController;
use App\Http\Controllers\api\RolController;
use App\Http\Controllers\api\StateController;
use App\Http\Controllers\api\VisibilityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Generación de rutas ---------------------------------------------
Route::resources([

    // generacion de rutas para users
    'user' => UserController::class,

    // generacion de rutas para notes
    'note' => NoteController::class,

    // generacion de rutas para rols
    'rol' => RolController::class,

    // generacion de rutas para states
    'state' => StateController::class,

    // generacion de rutas para visibility
    'visibility' => VisibilityController::class
]);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\FallbackController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\NoteController;
use App\Http\Controllers\api\RolController;
use App\Http\Controllers\api\StateController;
use App\Http\Controllers\api\VisibilityController;



// Generacion de rutas individuales -----------------------------------------------------------------------------------

Route::post('register', [AuthController::class, 'store']);

Route::post('login', [AuthController::class, 'login']);




Route::group([
    "middleware" => ["auth:sanctum"]
], function () {


    // Generación de rutas --------------------------------------------------------------------------------------------------
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
});


// Manejo de rutas inexistentes y mal manejo de metodos -----------------------------------------------------------------------------------------

Route::any('{fallbackPlaceholder?}', [FallbackController::class, 'fallback'])
    ->where('fallbackPlaceholder', '.*');

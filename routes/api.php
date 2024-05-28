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



// Creacion de rutas individuales -----------------------------------------------------------------------------------

Route::post('register', [AuthController::class, 'store']);

Route::post('login', [AuthController::class, 'login']);



// Agrupacion de rutas
Route::group([

    'middleware' =>
    [
        // Proteccion autentificacion  sanctum 
        'auth:sanctum',
        // Limitacion solicitudes x ruta usuario Auth ( 60 x Min )
        'throttle:60'
    ]
], function () {


    Route::get('noteAll', [NoteController::class, 'noteAll']);
    Route::get('notePublic', [NoteController::class, 'publicNote']);
    Route::put('userAdmin/{user}', [UserController::class, 'updateAdmin']);
    Route::delete('userAdmin/{user}', [UserController::class, 'destroyAdmin']);
    
    // Creacion automatica rutas  --------------------------------------------------------------------------------------------------
    Route::resources([

        // Generacion de rutas para users
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


// Manejo de rutas inexistentes  -----------------------------------------------------------------------------------------

Route::any('{fallbackPlaceholder?}', [FallbackController::class, 'fallback'])
    ->where('fallbackPlaceholder', '.*');

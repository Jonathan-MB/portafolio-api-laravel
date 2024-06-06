<?php

use App\Http\Controllers\api\FallbackController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::any('{fallbackPlaceholder?}', [FallbackController::class, 'fallback'])
    ->where('fallbackPlaceholder', '.*');
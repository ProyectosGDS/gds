<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Eventos\TipoEventoController;
use App\Http\Controllers\Eventos\EventoController;

Route::apiResource('tipo-eventos', TipoEventoController::class) 
            ->only( [ 'index', 'show', 'store', 'update', 'destroy']);

Route::apiResource('eventos', EventoController::class)
            ->only( [ 'index', 'show', 'store', 'update', 'destroy']);

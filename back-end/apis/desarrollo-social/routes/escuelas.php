<?php

use App\Http\Controllers\Escuelas\CategoriasCursosController;
use App\Http\Controllers\Escuelas\CursosController;
use App\Http\Controllers\Escuelas\EscuelasController;
use App\Http\Controllers\Escuelas\HorariosController;
use App\Http\Controllers\Escuelas\InscripcionesController;
use App\Http\Controllers\Escuelas\InstructoresController;
use App\Http\Controllers\Escuelas\NivelesController;
use App\Http\Controllers\Escuelas\PortafolioController;
use App\Http\Controllers\Escuelas\ProgramasController;
use App\Http\Controllers\Escuelas\RequisitosController;
use App\Http\Controllers\Escuelas\SeccionesController;
use App\Http\Controllers\Escuelas\SedesController;
use Illuminate\Support\Facades\Route;



Route::prefix('escuelas')->group(function(){
    Route::get('index',[EscuelasController::class,'index']);
    Route::get('show/{id}',[EscuelasController::class,'show']);
    Route::post('store',[EscuelasController::class,'store']);
    Route::put('update/{escuela}',[EscuelasController::class,'update']);
    Route::delete('destroy/{escuela}',[EscuelasController::class,'destroy']);
});

Route::prefix('programas')->group(function(){
    Route::get('index/{direccion_id}/{escuela_id?}',[ProgramasController::class,'index']);
    Route::get('show/{id}',[ProgramasController::class,'show']);
    Route::post('store',[ProgramasController::class,'store']);
    Route::put('update/{programa}',[ProgramasController::class,'update']);
    Route::delete('destroy/{id}',[ProgramasController::class,'destroy']);
});

Route::prefix('niveles')->group(function(){
    Route::get('index',[NivelesController::class,'index']);
    Route::get('show/{nivel_id}/{programa_id}',[NivelesController::class,'show']);
    Route::post('store',[NivelesController::class,'store']);
    Route::put('update/{nivel}',[NivelesController::class,'update']);
    Route::delete('destroy/{nivel}',[NivelesController::class,'destroy']);
});

Route::prefix('secciones')->group(function(){
    Route::get('index',[SeccionesController::class,'index']);
    Route::get('show/{seccion_id}/{nivel_id}/{programa_id}',[SeccionesController::class,'show']);
    Route::post('store',[SeccionesController::class,'store']);
    Route::put('update/{seccion}',[SeccionesController::class,'update']);
    Route::delete('destroy/{seccion}',[SeccionesController::class,'destroy']);
});

Route::prefix('cursos')->group(function(){
    Route::get('index',[CursosController::class,'index']);
    Route::get('curses-details/{programa_id}/{nivel_id}/{seccion_id}',[CursosController::class,'cursesDetails']);
    Route::get('show/{id}',[CursosController::class,'show']);
    Route::post('store',[CursosController::class,'store']);
    Route::put('update/{curso}',[CursosController::class,'update']);
    Route::delete('destroy/{curso}',[CursosController::class,'destroy']);
});

Route::prefix('requisitos')->group(function(){
    Route::get('index',[RequisitosController::class,'index']);
    Route::get('show/{id}',[RequisitosController::class,'show']);
    Route::post('store',[RequisitosController::class,'store']);
    Route::put('update/{requisito}',[RequisitosController::class,'update']);
    Route::delete('destroy/{requisito}',[RequisitosController::class,'destroy']);
});

Route::prefix('horarios')->group(function(){
    Route::get('index',[HorariosController::class,'index']);
    Route::get('show/{id}',[HorariosController::class,'show']);
    Route::post('store',[HorariosController::class,'store']);
    Route::put('update/{horario}',[HorariosController::class,'update']);
    Route::delete('destroy/{horario}',[HorariosController::class,'destroy']);
});

Route::prefix('instructores')->group(function(){
    Route::get('index',[InstructoresController::class,'index']);
    Route::get('show/{id}',[InstructoresController::class,'show']);
    Route::post('store',[InstructoresController::class,'store']);
    Route::put('update/{instructor}',[InstructoresController::class,'update']);
    Route::delete('destroy/{instructor}',[InstructoresController::class,'destroy']);
});

Route::prefix('portafolio')->group(function(){
    Route::get('index',[PortafolioController::class,'index']);
    Route::get('show/{id}',[PortafolioController::class,'show']);
    Route::post('store',[PortafolioController::class,'store']);
    Route::put('update',[PortafolioController::class,'update']);
    Route::delete('destroy',[PortafolioController::class,'destroy']);
});

Route::prefix('sedes')->group(function(){
    Route::get('index',[SedesController::class,'index']);
    Route::post('store',[SedesController::class,'store']);
    Route::put('update/{sede}',[SedesController::class,'update']);
    Route::delete('destroy/{sede}',[SedesController::class,'destroy']);
});

Route::prefix('inscripciones')->group(function(){
    Route::get('index',[InscripcionesController::class,'index']);
});

Route::prefix('categorias')->group(function(){
    Route::get('index',[CategoriasCursosController::class,'index']);
});



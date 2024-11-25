<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Escuelas\InscripcionesController;
use App\Http\Controllers\Global\DepartamentosController;
use App\Http\Controllers\Global\DireccionesController;
use App\Http\Controllers\Global\ExportExcelController;
use App\Http\Controllers\Global\PaisesController;
use App\Http\Controllers\Personas\HistorialBeneficiarioUnicoController;
use App\Http\Controllers\Personas\PersonasController;
use Illuminate\Support\Facades\Route;



Route::post('exportar-excel',[ExportExcelController::class,'exportExcel']);

Route::post('login',[LoginController::class,'authenticate']);

Route::post('register',[RegisterController::class,'register']);

Route::post('logout',[LoginController::class,'logout'])->middleware(['jwtAuth']);

Route::post('me',[LoginController::class,'verifyAuth'])->middleware(['jwtAuth']);


Route::get('paises/{pais}',[PaisesController::class,'show']);

Route::get('catalogos',[InscripcionesController::class,'catalogos']);

Route::get('departamentos',[DepartamentosController::class,'index']);
Route::get('departamentos/{departamento}',[DepartamentosController::class,'show']);




Route::post('personas',[PersonasController::class,'store']);
Route::post('consulta-beneficiario-unico',[HistorialBeneficiarioUnicoController::class,'show']);
Route::post('pre-inscripcion',[PersonasController::class,'preInscripcion']);
Route::post('inscripcion',[PersonasController::class,'inscripcionOnline']);
Route::get('campos-registro',[PersonasController::class,'camposRegistro']);

Route::prefix('direcciones')->group(function(){
    Route::get('index/{id?}',[DireccionesController::class,'index']);
    Route::post('store',[DireccionesController::class,'store']);
    Route::put('update/{direccion}',[DireccionesController::class,'update']);
    Route::delete('delete/{direccion}',[DireccionesController::class,'destroy']);
});
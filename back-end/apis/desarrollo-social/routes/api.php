<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Global\DepartamentosController;
use App\Http\Controllers\Global\DireccionesController;
use App\Http\Controllers\Global\EnfermedadesCronicasController;
use App\Http\Controllers\Global\EscolaridadesController;
use App\Http\Controllers\Global\ExportExcelController;
use App\Http\Controllers\Global\GruposEtnicosController;
use App\Http\Controllers\Global\GruposHabitacionalesController;
use App\Http\Controllers\Global\MunicipiosController;
use App\Http\Controllers\Global\PaisesController;
use App\Http\Controllers\Global\ParentescosController;
use App\Http\Controllers\Global\TipSangreController;
use App\Http\Controllers\Global\ZonasController;
use App\Http\Controllers\Personas\PersonasController;
use Illuminate\Support\Facades\Route;



Route::post('exportar-excel',[ExportExcelController::class,'exportExcel']);

Route::post('login',[LoginController::class,'authenticate']);

Route::post('register',[RegisterController::class,'register']);

Route::post('logout',[LoginController::class,'logout'])->middleware(['jwtAuth']);

Route::post('me',[LoginController::class,'verifyAuth'])->middleware(['jwtAuth']);


Route::get('paises',[PaisesController::class,'index']);
Route::get('paises/{pais}',[PaisesController::class,'show']);

Route::get('departamentos',[DepartamentosController::class,'index']);
Route::get('departamentos/{departamento}',[DepartamentosController::class,'show']);

Route::get('municipios',[MunicipiosController::class,'index']);
Route::get('zonas',[ZonasController::class,'index']);
Route::get('grupos-habitacionales',[GruposHabitacionalesController::class,'index']);
Route::get('etnias',[GruposEtnicosController::class,'index']);
Route::get('escolaridades',[EscolaridadesController::class,'index']);
Route::get('enfermedades',[EnfermedadesCronicasController::class,'index']);
Route::get('parentescos',[ParentescosController::class,'index']);
Route::get('tipo-sangre',[TipSangreController::class,'index']);

Route::post('personas',[PersonasController::class,'store']);

Route::prefix('direcciones')->group(function(){
    Route::get('index/{id?}',[DireccionesController::class,'index']);
    Route::post('store',[DireccionesController::class,'store']);
    Route::put('update/{direccion}',[DireccionesController::class,'update']);
    Route::delete('delete/{direccion}',[DireccionesController::class,'destroy']);
});
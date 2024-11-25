<?php

use App\Http\Controllers\ParticipacionCiudadana\CarouselController;
use Illuminate\Support\Facades\Route;

Route::prefix('carousel')->group(function(){
    Route::get('index',[CarouselController::class,'index']);
});
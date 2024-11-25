<?php

namespace App\Http\Controllers\ParticipacionCiudadana;

use App\Http\Controllers\Controller;
use App\Models\Gds\pcCarousel;


class CarouselController extends Controller
{
    public function index() {
        try {
            $carousel = pcCarousel::all();
            return response($carousel);
        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }
}

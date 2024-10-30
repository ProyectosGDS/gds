<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use App\Models\Gds\Paises;
use Illuminate\Http\Request;

class PaisesController extends Controller
{
    public function index() {
        try {
            
            $paises = Paises::all();
            return response($paises);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function show(Paises $pais) {
        try {
            return response($pais->load('departamentos'));
        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }
}

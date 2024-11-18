<?php

namespace App\Http\Controllers\Escuelas;

use App\Http\Controllers\Controller;
use App\Models\Gds\Enfermedades;
use App\Models\Gds\EscIncripciones;
use App\Models\Gds\Escolaridades;
use App\Models\Gds\GruposEtnicos;
use App\Models\Gds\GruposHabitacionales;
use App\Models\Gds\Paises;
use App\Models\Gds\Parentescos;
use App\Models\Gds\TipoSangre;
use App\Models\Gds\Zonas;
use Illuminate\Http\Request;

class InscripcionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        try {
            
            $inscripciones = EscIncripciones::with([
                    'persona.status',
                    'portafolio.curso',
                    'portafolio.programa.direccion'
                ])->get();

            return response($inscripciones);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        //
    }

    public function catalogos() {
        try {
            
            $catalogos = [
                'paises' => Paises::all(),
                'etnias' => GruposEtnicos::all(),
                'gruposHabitacionales' => GruposHabitacionales::all(),
                'zonas' => Zonas::all(),
                'escolaridades' => Escolaridades::all(),
                'tipo_sangre' => TipoSangre::all(),
                'enfermedades' => Enfermedades::all(),
                'parentescos' => Parentescos::all(),
            ];

            return response($catalogos);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }
}

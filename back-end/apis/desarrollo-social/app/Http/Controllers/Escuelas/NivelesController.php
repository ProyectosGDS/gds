<?php

namespace App\Http\Controllers\Escuelas;

use App\Http\Controllers\Controller;
use App\Models\Gds\EscNiveles;
use App\Models\Gds\EscPortafolio;
use Illuminate\Http\Request;

class NivelesController extends Controller
{
    public function index() {
        try {
            
            $niveles = EscNiveles::all();

            return response($niveles);


        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function show(int $nivel_id, int $programa_id) {
        try {

            $secciones = EscPortafolio::with([
                                'seccion:id,nombre',
                                'curso:id,nombre',
                                'instructor:id,nombre',
                                'horario:id,dia,hora_inicial,hora_final',
                                'sede.zona'
                            ])
                            ->where('programa_id',$programa_id)
                            ->where('nivel_id',$nivel_id)
                            ->get()->groupBy('seccion.nombre');

            $nivel = EscNiveles::find($nivel_id);
            $nivel->secciones = $secciones;
            
            return response($nivel);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:80',
        ]);

        try {
            
            $nivel = EscNiveles::create([
                'nombre' => strtoupper(trim($request->nombre)),
                'descripcion' => $request->descripcion ?? '',
            ]);

            if($nivel){
                return response([
                    'status' => 'ok',
                    'message' => 'Nivel creado exitosamente'
                ]);
            }

            return response([
                'status' => 'error',
                'message' => 'Error al intentar crear el registro'
            ]);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function update(EscNiveles $nivel, Request $request) {

        $request->validate([
            'nombre' => 'required|string|max:80',
        ]);

        try {
            
            $nivel->nombre = $request->nombre;
            $nivel->descripcion = $request->descripcion ?? '';
            $nivel->deleted_at = is_null($request->deleted_at) ? null : $request->deleted_at;
            $nivel->save();

            return response('Nivel actualizado exitosamente');

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function destroy(EscNiveles $nivel) {
        
        try {
            
            $nivel->deleted_at = now();
            $nivel->save();

            return response('Nivel eliminado exitosamente');

        } catch (\Throwable $th) {

            return response($th->getMessage());
        }
    }
}

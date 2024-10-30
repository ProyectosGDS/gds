<?php

namespace App\Http\Controllers\Escuelas;

use App\Http\Controllers\Controller;
use App\Models\Gds\EscCursos;
use App\Models\Gds\EscSecciones;
use Illuminate\Http\Request;

class SeccionesController extends Controller
{
    public function index() {
        try {
            
            $secciones = EscSecciones::all();

            return response($secciones);


        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function show(int $seccion_id,int $nivel_id,int $programa_id) {
        try {

            $seccion = EscSecciones::with(['cursos' => function($query) use($nivel_id, $programa_id) {
                                $query->where('nivel_id',$nivel_id)
                                    ->where('programa_id',$programa_id);
                            }])->whereNull('deleted_at')
                            ->where('id',$seccion_id)
                            ->first();
            
            $cursos = collect($seccion->cursos)->unique('id')->values();

            unset($seccion->cursos);

            $seccion->cursos = $cursos;

            return response($seccion);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:50',
        ]);

        try {
            
            $seccion = EscSecciones::create([
                'nombre' => strtoupper(trim($request->nombre)),
            ]);

            if($seccion){
                return response([
                    'status' => 'ok',
                    'message' => 'Seccion creada exitosamente'
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

    public function update(EscSecciones $seccion, Request $request) {

        $request->validate([
            'nombre' => 'required|string|max:80',
        ]);

        try {
            
            $seccion->nombre = $request->nombre;
            $seccion->deleted_at = is_null($request->deleted_at) ? null : $request->deleted_at;
            $seccion->save();

            return response('Seccion actualizada exitosamente');

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function destroy(EscSecciones $seccion) {
        
        try {
            
            $seccion->deleted_at = now();
            $seccion->save();

            return response('Seccion eliminada exitosamente');

        } catch (\Throwable $th) {

            return response($th->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Escuelas;

use App\Http\Controllers\Controller;
use App\Models\Gds\EscEscuelas;
use Illuminate\Http\Request;

class EscuelasController extends Controller
{
    public function index() {
        try {
            
            $escuelas = EscEscuelas::with(['programas'])
                            ->get();

            return response($escuelas);


        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function show(string $id) {
        try {
            
            $escuela = EscEscuelas::with(['programas.niveles.secciones','direccion'])
                        ->whereNull('deleted_at')
                        ->where('id',$id)
                        ->first();

            foreach ($escuela->programas as &$programa) {
                $niveles = $programa->niveles->unique('id')->values();
                unset($programa->niveles);
                $programa->niveles = $niveles;
            }

            return response($escuela);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function store(Request $request) {

        $request->validate([
            'nombre' => 'required|string|max:80',
            'di_direccion_id' => 'required|exists:di_direcciones,id'
        ]);

        try {
            
            $escuela = EscEscuelas::create([
                'nombre' => strtoupper(trim($request->nombre)),
                'descripcion' => $request->descripcion ?? '',
                'di_direccion_id' => $request->di_direccion_id,
            ]);

            if($escuela){
                return response([
                    'status' => 'ok',
                    'message' => 'Escuela creada exitosamente'
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

    public function update(EscEscuelas $escuela, Request $request) {

        $request->validate([
            'nombre' => 'required|string|max:80',
            'direccion' => 'required|string|max:255',
            'direccion_id' => 'required|exists:di_direcciones,id'
        ]);

        try {
            
            $escuela->nombre = $request->nombre;
            $escuela->direccion = $request->direccion;
            $escuela->descripcion = $request->descripcion ?? '';
            $escuela->deleted_at = is_null($request->deleted_at) ? null : $request->deleted_at;
            $escuela->direccion_id = $request->direccion_id;
            $escuela->save();

            return response('Escuela actualizada exitosamente');

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function destroy(EscEscuelas $escuela) {
        
        try {
            
            $escuela->deleted_at = now();
            $escuela->save();

            return response('Escuela eliminada exitosamente');

        } catch (\Throwable $th) {

            return response($th->getMessage());
        }
    }
}

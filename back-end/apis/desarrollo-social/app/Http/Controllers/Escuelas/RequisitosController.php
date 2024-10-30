<?php

namespace App\Http\Controllers\Escuelas;

use App\Http\Controllers\Controller;
use App\Models\Gds\EscRequisitos;
use Illuminate\Http\Request;

class RequisitosController extends Controller
{
    public function index() {
        try {
            
            $requisitos = EscRequisitos::with(['cursos'])
                            ->get();

            return response($requisitos);


        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function show(int $id) {
        try {
            
            $requisito = EscRequisitos::with(['cursos'])
                        ->whereNull('deleted_at')
                        ->where('id',$id)
                        ->first();

            return response($requisito);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:80',
        ]);

        try {
            
            $requisito = EscRequisitos::create([
                'nombre' => strtoupper(trim($request->nombre)),
                'descripcion' => $request->descripcion ?? '',
            ]);

            if($requisito){
                return response([
                    'status' => 'ok',
                    'message' => 'Requisito creado exitosamente'
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

    public function update(EscRequisitos $requisito, Request $request) {

        $request->validate([
            'nombre' => 'required|string|max:80'
        ]);

        try {
            
            $requisito->nombre = $request->nombre;
            $requisito->descripcion = $request->descripcion ?? '';
            $requisito->save();

            return response('Requisito actualizado exitosamente');

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function destroy(EscRequisitos $requisito) {
        
        try {
            
            $requisito->deleted_at = now();
            $requisito->save();

            return response('Requisito eliminado exitosamente');

        } catch (\Throwable $th) {

            return response($th->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use App\Models\Gds\DiDirecciones;
use Illuminate\Http\Request;

class DireccionesController extends Controller
{
    public function index(string $id = '') {
        try {
            
            $direcciones = DiDirecciones::whereNull('deleted_at')
                            ->when(!empty($id),function($query) use($id) {
                                $query->where('id',$id);
                            })->with(['escuelas','programas'])
                            ->get();

            return response($direcciones);


        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:80',
        ]);

        try {
            
            $direccion = DiDirecciones::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion ?? ''
            ]);

            if($direccion){
                return response([
                    'status' => 'ok',
                    'message' => 'Direccion creada exitosamente'
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

    public function update(DiDirecciones $direccion, Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:80'
        ]);

        try {
            
            $direccion->nombre = $request->nombre;
            $direccion->descripcion = $request->descripcion ?? '';
            $direccion->save();

            return response('Direccion actualizada exitosamente');

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function  destroy(DiDirecciones $direccion) {
        
        try {
            
            $direccion->deleted_at = now();
            $direccion->save();

            return response('Direccion eliminada exitosamente');

        } catch (\Throwable $th) {

            return response($th->getMessage());
        }
    }
}

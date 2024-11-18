<?php

namespace App\Http\Controllers\Escuelas;

use App\Http\Controllers\Controller;
use App\Models\Gds\EscSedes;
use Illuminate\Http\Request;

class SedesController extends Controller
{
    public function index() {
        try {
            
            $sedes = EscSedes::with(['zona'])->get();

            return response($sedes);


        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:80',
            'direccion' => 'required|string|max:80',
            'zona_id'   => 'required'
        ]);

        try {
            
            $sede = EscSedes::create([
                'nombre' => strtoupper(trim($request->nombre)),
                'direccion' => strtoupper(trim($request->direccion)),
                'zona_id' => $request->zona_id
            ]);

            if($sede){
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

    public function update(EscSedes $sede, Request $request) {

        $request->validate([
            'nombre' => 'required|string|max:80',
            'direccion' => 'required|string|max:80',
            'zona_id'   => 'required'
        ]);

        try {
            
            $sede->nombre = strtoupper(trim($request->nombre));
            $sede->deleted_at = is_null($request->deleted_at) ? null : $request->deleted_at;
            $sede->direccion = $request->direccion;
            $sede->zona_id = $request->zona_id;
            $sede->save();

            return response('Seccion actualizada exitosamente');

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function destroy(EscSedes $sede) {
        
        try {
            
            $sede->deleted_at = now();
            $sede->save();

            return response('Seccion eliminada exitosamente');

        } catch (\Throwable $th) {

            return response($th->getMessage());
        }
    }
}

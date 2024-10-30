<?php

namespace App\Http\Controllers\Escuelas;

use App\Http\Controllers\Controller;
use App\Models\Gds\EscInstructores;
use Illuminate\Http\Request;

class InstructoresController extends Controller
{
    public function index() {
        try {
            
            $instructores = EscInstructores::all();

            return response($instructores);


        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function show(int $id) {
        try {
            
            $instructor = EscInstructores::whereNull('deleted_at')
                        ->where('id',$id)
                        ->first();

            return response($instructor);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:80'
        ]);

        try {
            
            $instructor = EscInstructores::create([
                'nombre' => strtoupper(trim($request->nombre))
            ]);

            if($instructor){
                return response([
                    'status' => 'ok',
                    'message' => 'Instructor creado exitosamente'
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

    public function update(EscInstructores $instructor, Request $request) {

        $request->validate([
            'nombre' => 'required|string|max:80'
        ]);

        try {
            
            $instructor->nombre = $request->nombre;
            $instructor->deleted_at = is_null($request->deleted_at) ? null : $request->deleted_at;
            $instructor->save();

            return response('Instructor actualizado exitosamente');

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function destroy(EscInstructores $instructor) {
        
        try {
            
            $instructor->deleted_at = now();
            $instructor->save();

            return response('Instructor eliminado exitosamente');

        } catch (\Throwable $th) {

            return response($th->getMessage());
        }
    }
}

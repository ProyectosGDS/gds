<?php

namespace App\Http\Controllers\Escuelas;

use App\Http\Controllers\Controller;
use App\Models\Gds\EscHorarios;
use Illuminate\Http\Request;

class HorariosController extends Controller
{
    public function index() {
        try {
            
            $horarios = EscHorarios::all();

            return response($horarios);


        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function show(int $id) {
        try {
            
            $horario = EscHorarios::whereNull('deleted_at')
                        ->where('id',$id)
                        ->first();

            return response($horario);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function store(Request $request) {
        $request->validate([
            'dia' => 'required',
            'hora_inicial' => 'required|string',
            'hora_final' => 'required|string',
        ]);

        try {
            
            $horario = EscHorarios::create([
                'dia' => $request->dia,
                'hora_inicial' => $request->hora_inicial,
                'hora_final' => $request->hora_final,
                
            ]);

            if($horario){
                return response([
                    'status' => 'ok',
                    'message' => 'Horario creado exitosamente'
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

    public function update(EscHorarios $horario, Request $request) {

        $request->validate([
            'dia' => 'required',
            'hora_inicial' => 'required|string',
            'hora_final' => 'required|string',
        ]);

        try {
            
            $horario->dia = $request->dia;
            $horario->hora_inicial = $request->hora_inicial;
            $horario->hora_final = $request->hora_final;
            $horario->deleted_at = is_null($request->deleted_at) ? null : $request->deleted_at;
            
            $horario->save();

            return response('Horario actualizado exitosamente');

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function destroy(EscHorarios $horario) {
        
        try {
            
            $horario->deleted_at = now();
            $horario->save();

            return response('Horario eliminado exitosamente');

        } catch (\Throwable $th) {

            return response($th->getMessage());
        }
    }
}

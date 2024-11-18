<?php

namespace App\Http\Controllers\Escuelas;

use App\Http\Controllers\Controller;
use App\Models\Gds\EscPortafolio;
use Illuminate\Http\Request;

class PortafolioController extends Controller
{
    public function index() {
        try {

            $portafolios = EscPortafolio::with([
                                'programa.escuela',
                                'nivel:id,nombre',
                                'seccion:id,nombre',
                                'curso',
                                'instructor:id,nombre',
                                'horario:id,dia,hora_inicial,hora_final',
                                'sede.zona'
                            ])->get();
            return response($portafolios);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function show(int $id) {
        try {
            $portafolio = EscPortafolio::with([
                    'programa.escuela',
                    'nivel:id,nombre',
                    'seccion:id,nombre',
                    'curso',
                    'instructor:id,nombre',
                    'horario:id,dia,hora_inicial,hora_final',
                    'sede.zona'
                ])->where('id',$id)->first();

            return response($portafolio);
            
        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function store(Request $request) {

        $request->validate([
            'programa_id' => 'required|numeric',
            'nivel_id' => 'required|numeric',
            'seccion_id' => 'required|numeric',
            'curso_id' => 'required|numeric',
            'instructor_id' => 'required|numeric',
            'horario_id' => 'required|numeric',
            'modalidad' => 'required|string',
            'sede_id' => 'required|numeric',
        ]);

        try {
            
            $asignacion = EscPortafolio::create([
                'programa_id' => $request->programa_id,
                'nivel_id' => $request->nivel_id,
                'seccion_id' => $request->seccion_id,
                'curso_id' => $request->curso_id,
                'instructor_id' => $request->instructor_id,
                'horario_id' => $request->horario_id,
                'modalidad' => $request->modalidad,
                'sede_id' => $request->sede_id,
            ]);

            if($asignacion) {
                return response([
                    'status' => 'ok',
                    'message' => 'Asignacion existosa'
                ]);
            }
            

            return response([
                'status' => 'error',
                'message' => 'Error en la asignacion de recursos'
            ]);
            
        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }
    
    public function update(Request $request) {
        $request->validate([
            'data.programa_id' => 'required|numeric|exists:esc_programas,id',
            'data.nivel_id' => 'required|numeric|exists:esc_niveles,id',
            'data.seccion_id' => 'required|numeric|exists:esc_secciones,id',
            'data.curso_id' => 'required|numeric|exists:esc_cursos,id',
            'data.instructor_id' => 'required|numeric|exists:esc_instructores,id',
            'data.horario_id' => 'required|numeric|exists:esc_horarios,id',
            'data.modalidad' => 'required|string',
        ]);

        try {

            $portafolio = EscPortafolio::where('programa_id',$request->llave['programa_id'])
                            ->where('nivel_id',$request->llave['nivel_id'])
                            ->where('seccion_id',$request->llave['seccion_id'])
                            ->where('curso_id',$request->llave['curso_id'])
                            ->where('instructor_id',$request->llave['instructor_id'])
                            ->where('horario_id',$request->llave['horario_id'])
                            ->where('modalidad',$request->llave['modalidad'])
                            ->update([
                                'programa_id' => $request->data['programa_id'],
                                'nivel_id' => $request->data['nivel_id'],
                                'seccion_id' => $request->data['seccion_id'],
                                'curso_id' => $request->data['curso_id'],
                                'instructor_id' => $request->data['instructor_id'],
                                'horario_id' => $request->data['horario_id'],
                                'modalidad' => $request->data['modalidad'],
                                'deleted_at' => is_null($request->data['deleted_at']) ? null : $request->data['deleted_at'],
                            ]);

            return response('Registro actualizado exitosamente');

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function destroy(Request $request) {
        try {
            
            $portafolio = EscPortafolio::where('programa_id',$request->programa_id)
                            ->where('nivel_id',$request->nivel_id)
                            ->where('seccion_id',$request->seccion_id)
                            ->where('curso_id',$request->curso_id)
                            ->where('instructor_id',$request->instructor_id)
                            ->where('horario_id',$request->horario_id)
                            ->where('modalidad',$request->modalidad)
                            ->update([
                                'deleted_at' => now(),
                            ]);
            return response('Registro eliminado exitosamente');
        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }
}

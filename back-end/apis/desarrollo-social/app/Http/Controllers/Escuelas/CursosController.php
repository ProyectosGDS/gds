<?php

namespace App\Http\Controllers\Escuelas;

use App\Http\Controllers\Controller;
use App\Models\Gds\EscCursos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursosController extends Controller
{
    public function index() {
        try {
            
            $cursos = EscCursos::all();

            return response($cursos);


        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function show(int $id) {
        try {
            
            $curso = EscCursos::with(['horarios','requisitos','instructor'])
                        ->whereNull('deleted_at')
                        ->where('id',$id)
                        ->first();

            return response($curso);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function cursesDetails( $programa_id,  $nivel_id,  $seccion_id) {

        $query = "
            SELECT
                c.nombre curso,
                CONCAT(h.dia,' ',h.hora_inicial,' - ',h.hora_final) horario,
                i.nombre instructor,
                modalidad
            FROM esc_portafolio p
            INNER JOIN esc_cursos c
                on p.curso_id = c.id
            INNER JOIN esc_instructores i
                ON p.instructor_id = i.id
            INNER JOIN esc_horarios h
                ON p.horario_id = h.id
            WHERE p.programa_id = $programa_id
            AND p.nivel_id = $nivel_id
            AND p.seccion_id = $seccion_id
            AND p.deleted_at IS NULL
        ";

        $cursesDetails = DB::connection('gds')->select($query);

        return response($cursesDetails);

    }

    public function store(Request $request) {
        
        $request->validate([
            'nombre' => 'required|string|max:80'
        ]);

        try {
            
            $curso = EscCursos::create([
                'nombre' => strtoupper(trim($request->nombre)),
                'descripcion' => $request->descripcion ?? '',
            ]);

            if($curso){
                return response([
                    'status' => 'ok',
                    'message' => 'Curso creado exitosamente'
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

    public function update(EscCursos $curso, Request $request) {

        $request->validate([
            'nombre' => 'required|string|max:80'
        ]);

        try {
            
            $curso->nombre = $request->nombre;
            $curso->descripcion = $request->descripcion ?? '';
            $curso->deleted_at = is_null($request->deleted_at) ? null : $request->deleted_at;
            $curso->save();

            return response('Curso actualizado exitosamente');

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function destroy(EscCursos $curso) {
        
        try {
            
            $curso->deleted_at = now();
            $curso->save();

            return response('Curso eliminado exitosamente');

        } catch (\Throwable $th) {

            return response($th->getMessage());
        }
    }
}

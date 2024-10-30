<?php

namespace App\Http\Controllers\Escuelas;

use App\Http\Controllers\Controller;
use App\Models\Gds\EscProgramas;
use Illuminate\Http\Request;

class ProgramasController extends Controller
{
    public function index( int $direccion_id, string $escuela_id = '') {
        try {
            
            $programas = EscProgramas::where('di_direccion_id',$direccion_id)
                ->with(['direccion','escuela','niveles.secciones'])
                ->get();

            foreach ($programas as &$programa) {
                $niveles = $programa->niveles->unique('id')->values();
                unset($programa->niveles);
                $programa->niveles = $niveles;
            }

            if(!empty($escuela_id)) {
                $newProgramas = [];
                foreach ($programas as $programa) {
                    if(count($programa->escuela) > 0 ) {
                        if($programa->escuela[0]->id == $escuela_id){
                            $newProgramas[] = $programa;
                        }
                    }
                }

                $programas = $newProgramas;
            }

            return response($programas);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function show(int $id) {
        try {

            $programa = EscProgramas::with(['escuela','niveles'])
                            ->whereNull('deleted_at')
                            ->where('id',$id)
                            ->first();
            
            $niveles = collect($programa->niveles)->unique('id')->values();

            unset($programa->niveles);

            $programa->niveles = $niveles;

            return response($programa);

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

            $programa = EscProgramas::create([
                'nombre' => strtoupper(trim($request->nombre)),
                'descripcion' => $request->descripcion ?? '',
                'di_direccion_id' => $request->di_direccion_id,
            ]);

            if($programa){

                if($request->escuela_id){
                    $programa->escuela()->sync([$request->escuela_id]);
                }

                return response([
                    'status' => 'ok',
                    'message' => 'Programa creada exitosamente'
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

    public function update(EscProgramas $programa, Request $request) {

        $request->validate([
            'nombre' => 'required|string|max:80',
            'direccion.id' => 'required|exists:di_direcciones,id'
        ]);

        try {

            $programa->nombre = strtoupper(trim($request->nombre));
            $programa->deleted_at = is_null($request->deleted_at) ? null : $request->deleted_at;
            $programa->di_direccion_id = $request->direccion['id'];
            $programa->save();

            if($request->escuela_id){
                $programa->escuela()->sync([$request->escuela_id]);
            }

            return response('Programa actualizada exitosamente');

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function destroy(int $id) {
        
        try {
            
            EscProgramas::where('id',$id)
                ->update([
                    'deleted_at' => now()
                ]);

            return response('Programa eliminada exitosamente');

        } catch (\Throwable $th) {

            return response($th->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Personas;

use App\Http\Controllers\Controller;
use App\Models\Gds\PerDatosAcademicos;
use App\Models\Gds\PerDatosContacto;
use App\Models\Gds\PerDatosMedicos;
use App\Models\Gds\DireccionesDomiciliares;
use App\Models\Gds\GruposZonas;
use App\Models\Gds\PerPersonas;
use App\Rules\ValidateCui;
use Illuminate\Http\Request;

class PersonasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        try {
            
            $personas = PerPersonas::get();
            return response($personas);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        $request->validate([
            'primer_nombre'             => 'required|string',
            'primer_apellido'           => 'required|string',
            'cui'                       => ['required','numeric','digits:13',new ValidateCui,'unique:per_personas,cui'],
            'fecha_nacimiento'          => 'required|date',
            'sexo'                    => 'required|string',
            'zona_id'                   => 'required|exists:gds.zonas,id',
            'lugar_nacimiento'          => 'required',
            'grupo_habitacional_id'     => 'required|exists:gds.grupos_habitacionales,id',
            'nombre_grupo_habitacional' => 'required|string',
            'municipio_id'              => 'required|exists:gds.municipios,id',
            'direccion'                 => 'required',
            'grupo_etnico_id'           => 'required',
            'celular'                   => 'required|numeric|digits:8',
            'correo'                    => 'required|email',
        ]);

        try {

            $grupoZona = GruposZonas::create([
                'nombre' => $request->nombre_grupo_habitacional,
                'zona_id' => $request->zona_id,
                'grupo_habitacional_id' => $request->grupo_habitacional_id
            ]);

            if($grupoZona){
                
                $direccionDomiciliar = DireccionesDomiciliares::create([
                    'direccion' => $request->direccion,
                    'municipio_id' => $request->municipio_id,
                    'grupo_zona_id' => $grupoZona->id
                ]);

                if($direccionDomiciliar) {
                    $persona = PerPersonas::create([
                        'primer_nombre'     => ucfirst(strtolower(trim($request->primer_nombre))),
                        'segundo_nombre'    => ucfirst(strtolower(trim($request->segundo_nombre))) ?? '',
                        'tercer_nombre'     => ucfirst(strtolower(trim($request->tercer_nombre))) ?? '',
                        'primer_apellido'   => ucfirst(strtolower(trim($request->primer_apellido))),
                        'segundo_apellido'  => ucfirst(strtolower(trim($request->segundo_apellido))) ?? '',
                        'apellido_casada'   => ucwords(strtolower(trim($request->apellido_casada))) ?? '',
                        'fecha_nacimiento'  => $request->fecha_nacimiento,
                        'sexo'            => $request->sexo,
                        'cui'               => $request->cui,
                        'lugar_nacimiento'  => $request->lugar_nacimiento ?? '',
                        'no_interlocutor'   => $request->no_interlocutor ?? '',
                        'direccion_domiciliar_id' => $direccionDomiciliar->id,
                        'grupo_etnico_id'      => $request->grupo_etnico_id
                    ]);

                    
                    // $datos_medicos = PerDatosMedicos::create([
                    //     'alergias' => $request->alergias,
                    //     'medicamentos' => $request->medicamentos,
                    //     'dosis_medicamento' => $request->dosis_medicamento,
                    //     'tipo_sangre_id' => $request->tipo_sangre_id,
                    //     'enfermedad_id' => $request->enfermedad_id,
                    //     'persona_id' => $persona->id,
                    // ]);

                    $datos_contacto = PerDatosContacto::create([
                        'telefono' => $request->telefono ?? '',
                        'celular' => $request->celular,
                        'correo' => $request->correo,
                        'facebook' => $request->facebook ?? '',
                        'instagram' => $request->instagram ?? '',
                        'tiktok' => $request->tiktok ?? '',
                        'persona_id' => $persona->id
                    ]);

                    // $datos_academicos = PerDatosAcademicos::create([
                    //     'establecimiento' => $request->establecimiento,
                    //     'grado' => $request->grado,
                    //     'titulo' => $request->titulo, 
                    //     'escolaridad_id' => $request->escolaridad_id,
                    //     'persona_id' => $persona->id,
                    // ]);

                    return response($persona);
                }
            }

            return response(
                [
                'status' => 'error',
                'message' => 'Error al intentar crear el registro',
                ], 422
            );
            
        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerPersonas $persona) {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        //
    }
}

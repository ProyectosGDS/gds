<?php

namespace App\Http\Controllers\Personas;

use App\Http\Controllers\Controller;
use App\Models\Gds\CamposRegistro;
use App\Models\Gds\PerDatosAcademicos;
use App\Models\Gds\PerDatosContacto;
use App\Models\Gds\PerDatosMedicos;
use App\Models\Gds\PerDireccionesDomiciliares;
use App\Models\Gds\EscIncripciones;
use App\Models\Gds\GruposZonas;
use App\Models\Gds\PerContactoEmergencia;
use App\Models\Gds\PerContactoResponsables;
use App\Models\Gds\PerPersonas;
use App\Rules\ValidateCui;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PersonasController extends Controller
{

    public $bagValidations = [];

    public function camposRegistro() {
        try {
            $camposRegistro = CamposRegistro::all();
            return response($camposRegistro);
        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function index() {
        try {
            
            $personas = PerPersonas::get();
            return response($personas);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function inscripcion(Request $request) {
        
        DB::connection('gds')->beginTransaction();
        
        try {
            
            $persona = $this->createPersona($request);
            $this->createDatosContacto($request, $persona->id ?? 0);
            
            $grupoZona = $this->createGrupoZona($request);            
            $this->createDireccionDomiciliar($request, $grupoZona->id ?? 0 ,$persona->id ?? 0);

            $this->createDatosAcademicos($request,$persona_id ?? 0);

            if($request->has('alergias') || $request->has('medicamento')) {
                $this->createDatosMedicos($request,$persona_id ?? 0);
            }

            $this->createContactoEmergencia($request,$persona->id ?? 0);
            $this->createDatosResponsable($request,$persona->id ?? 0);

            if(!empty($this->bagValidations)){
                DB::connection('gds')->rollBack();
                return response(['errors' => $this->bagValidations],422);
            }

            DB::connection('gds')->commit();
            
            return response('todo se credo de forma exitosa');

        } catch (\Throwable $th) {

            DB::connection('gds')->rollBack();
            return response($th->getMessage(),422);

        }

    }

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
                
                $direccionDomiciliar = PerDireccionesDomiciliares::create([
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

    public function preInscripcion (Request $request) {
        $request->validate([
            'primer_nombre' => 'required|string|max:45',
            'primer_apellido' => 'required|string|max:45',
            'cui' => ['required','numeric','digits:13',new ValidateCui,'unique:per_personas,cui'],
            'correo' => 'required|email',
            'celular' => 'required|numeric|digits:8',
            'portafolio_id' => 'required|exists:esc_portafolio,id'
        ]);

        try {
            
            $persona = PerPersonas::create([
                'primer_nombre'     => ucfirst(strtolower(trim($request->primer_nombre))),
                'segundo_nombre'    => ucfirst(strtolower(trim($request->segundo_nombre))) ?? '',
                'tercer_nombre'     => ucfirst(strtolower(trim($request->tercer_nombre))) ?? '',
                'primer_apellido'   => ucfirst(strtolower(trim($request->primer_apellido))),
                'segundo_apellido'  => ucfirst(strtolower(trim($request->segundo_apellido))) ?? '',
                'apellido_casada'   => ucwords(strtolower(trim($request->apellido_casada))) ?? '',
                'cui' => $request->cui,
                'status_id' => 1  
            ]);

            if($persona){

                $datos_contacto = $persona->datosContacto()->create([
                    'celular' => $request->celular,
                    'correo' => $request->correo
                ]);

                if($datos_contacto){

                    $inscripcion = EscIncripciones::create([
                        'persona_id' => $persona->id,
                        'portafolio_id' => $request->portafolio_id,
                    ]);

                    if($inscripcion){

                        return response([
                            'status' => 'ok',
                            'message' => 'Preincripcion realizada correctamente'
                        ]);
                    }


                } else{
                    return response([
                        'status' => 'error',
                        'message' => 'Error al intentar crear el registro de datos contacto'
                    ]);
                    
                }
            }

            return response([
                        'status' => 'error',
                        'message' => 'Error al intentar crear el registro de persona'
                    ]);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function createPersona(Request $request) {

        $validations = Validator::make($request->all(),[
            'cui' => ['required','numeric','digits:13',new ValidateCui,'unique:per_personas,cui'],
            'primer_nombre' => 'required|string|max:80',
            'primer_apellido' => 'required|string|max:80',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|string|max:1',
            'lugar_nacimiento' => 'string|max:80',
            'di_direccion_id' => 'required',
        ]);

        if($validations->fails()){
            $this->bagValidations = array_merge($this->bagValidations, $validations->errors()->toArray());
            return;
        }

        $persona = PerPersonas::create([
            'cui'               => $request->cui,
            'primer_nombre'     => ucfirst(strtolower(trim($request->primer_nombre))),
            'segundo_nombre'    => ucfirst(strtolower(trim($request->segundo_nombre))) ?? '',
            'tercer_nombre'     => ucfirst(strtolower(trim($request->tercer_nombre))) ?? '',
            'primer_apellido'   => ucfirst(strtolower(trim($request->primer_apellido))),
            'segundo_apellido'  => ucfirst(strtolower(trim($request->segundo_apellido))) ?? '',
            'apellido_casada'   => ucwords(strtolower(trim($request->apellido_casada))) ?? '',
            'fecha_nacimiento'  => $request->fecha_nacimiento,
            'sexo'              => $request->sexo,
            'lugar_nacimiento'  => $request->lugar_nacimiento ?? '',
            'nit'               => $request->nit ?? '',
            'pasaporte'         => $request->pasaporte ?? '',
            'grupo_etnico_id'   => $request->etnia_id ?? '',
            'no_interlocutor'   => $request->no_interlocutor ?? '',
            'di_direccion_id'   => $request->di_direccion_id,
        ]);

        return $persona;

    }

    public function createGrupoZona(Request $request) {

        $validations = Validator::make($request->all(),[
            'nombre_grupo_habitacional' => 'required|string|max:80',
            'zona_id' => 'required',
            'grupo_habitacional_id' => 'required',
        ]);

        if($validations->fails()){
            $this->bagValidations = array_merge($this->bagValidations,$validations->errors()->toArray());
            return;
        }

        $grupoZona = GruposZonas::create([
            'nombre' => strtoupper(trim($request->nombre_grupo_habitacional)),
            'zona_id' => $request->zona_id,
            'grupo_habitacional_id' => $request->grupo_habitacional_id,
        ]);

        
        return $grupoZona;
    }

    public function createDireccionDomiciliar (Request $request, int $grupo_zona_id, int $persona_id) {
        $validations = Validator::make($request->all(),[
            'calle' => 'string|max:80',
            'avenida' => 'string|max:80',
            'domicilio' => 'required|string|max:80',
            'complemento' => 'string|max:80',
            'municipio_id' => 'required',
        ]);

        if($validations->fails()){
            $this->bagValidations = array_merge($this->bagValidations, $validations->errors()->toArray());
            return;
        }

        $direccionDomiciliar = PerDireccionesDomiciliares::create([
            'calle' => $request->calle ?? '',
            'avenida' => $request->avenida ?? '',
            'direccion' => strtoupper(trim($request->domicilio)) ?? '',
            'complemento' => strtoupper(trim($request->complemento)) ?? '',
            'municipio_id' => $request->municipio_id,
            'grupo_zona_id' => $grupo_zona_id,
            'persona_id' => $persona_id,

        ]);

        if($direccionDomiciliar){
            return $direccionDomiciliar;
        }

    }

    public function createDatosContacto(Request $request, int $persona_id = 0) {

        $validations = Validator::make($request->all(),[
            'telefono' => 'numeric|digits:8',
            'celular' => 'required|numeric|digits:8',
            'correo' => 'required|email',
            'facebook' => 'string|max:80',
            'instagram' => 'string|max:80',
            'tiktok' => 'string|max:80',
        ]);

        if($validations->fails()){
            $this->bagValidations = array_merge($this->bagValidations,$validations->errors()->toArray());
            return;
        }

        $datosContacto = PerDatosContacto::create([
            'telefono' => $request->telefono ?? '',
            'celular' => trim($request->celular),
            'correo' => $request->correo,
            'facebook' => trim($request->facebook) ?? '',
            'instagram' => trim($request->instagram) ?? '',
            'tiktok' => trim($request->tiktok) ?? '',
            'persona_id' => $persona_id,
        ]);

        if($datosContacto){
            return $datosContacto;
        }

    }

    public function createDatosMedicos(Request $request, int $persona_id) {

        $validations = Validator::make($request->all(),[
            'alergias' => 'string|max:80',
            'medicamento' => 'string|max:80',
        ]);

        if($validations->fails()){
            $this->bagValidations = array_merge($this->bagValidations, $validations->errors()->toArray());
            return;
        }

        $datosMedicos = PerDatosMedicos::create([
            'alergias' => strtoupper(trim($request->alergias)) ?? '',
            'medicamento' => strtoupper(trim($request->medicamento)) ?? '',
            'dosis_medicamento' => $request->dosis_medicamento ?? '',
            'enfermedad_id' => $request->enfermedad_id ?? '',
            'tipo_sangre_id' => $request->tipo_sangre_id ?? '',
            'persona_id' => $persona_id ?? '',
        ]);

        if($datosMedicos){
            return $datosMedicos;
        }

    }

    public function createDatosResponsable(Request $request, int $persona_id) {
        $validations = Validator::make($request->all(),[
            'responsable.parentesco_id' => 'required',
            'responsable.cui' => ['required','numeric','digits:13',new ValidateCui],
            'responsable.nombre' => 'required|string|max:150',
            'responsable.zona_id' => 'required',
            'responsable.direccion_domiciliar' => 'required|string|max:255',
            'responsable.celular' => 'required|numeric|digits:8',
            'responsable.correo' => 'string|email',
            'responsable.sexo' => 'required',
        ]);

        if($validations->fails()){
            $this->bagValidations = array_merge($this->bagValidations, $validations->errors()->toArray());
            return;
        }

        $datosResponsable = PerContactoResponsables::create([
            'persona_id' => $persona_id,
            'parentesco_id' => $request->responsable['parentesco_id'],
            'cui' => $request->responsable['cui'],
            'nombre' => ucfirst(strtolower(trim($request->responsable['nombre']))),
            'zona_id' => $request->responsable['zona_id'],
            'direccion_domiciliar' => strtoupper(trim($request->responsable['direccion_domiciliar'])),
            'celular' => trim($request->responsable['celular']),
            'correo' => strtolower(trim($request->responsable['correo'])),
            'sexo' => $request->responsable['sexo'],

        ]);

        if($datosResponsable) {
            return $datosResponsable;
        }

    }

    public function createContactoEmergencia(Request $request, int $persona_id) {
        
        $validations = Validator::make($request->all(),[
            'emergencia.cui' => ['required','numeric','digits:13',new ValidateCui],
            'emergencia.nombre' => 'required|string|max:150',
            'emergencia.zona_id' => 'required',
            'emergencia.direccion_domiciliar' => 'required|string|max:255',
            'emergencia.celular' => 'required|numeric|digits:8',
            'emergencia.correo' => 'string|email',
            'emergencia.sexo' => 'required|string',
            'emergencia.parentesco_id' => 'required',
        ]);

        if($validations->fails()){
            $this->bagValidations = array_merge($this->bagValidations, $validations->errors()->toArray());
            return;
        }

        $contactoEmergencia = PerContactoEmergencia::create([
            'persona_id' => $persona_id,
            'parentesco_id' => $request->emergencia['parentesco_id'],
            'cui' => $request->emergencia['cui'],
            'nombre' => ucfirst(strtolower(trim($request->emergencia['nombre']))),
            'zona_id' => $request->emergencia['zona_id'],
            'direccion_domiciliar' => strtoupper(trim($request->emergencia['direccion_domiciliar'])),
            'celular' => trim($request->emergencia['celular']),
            'correo' => strtolower(trim($request->emergencia['correo'])),
            'sexo' => $request->emergencia['sexo'],

        ]);

        if($contactoEmergencia) {
            return $contactoEmergencia;
        }

    }

    public function createDatosAcademicos(Request $request, int $persona_id) {
        $validations = Validator($request->all(),[
            'establecimiento_educativo' => 'required|string|max:100',
            'grado' => 'required|string|max:30',
            'escolaridad_id' => 'required',
            'titulo' => 'string|max:80',
            'tipo_establecimiento' => 'required',
        ]);

        if($validations->fails()){
            $this->bagValidations = array_merge($this->bagValidations, $validations->errors()->toArray());
            return;
        }

        $datosAcademicos = PerDatosAcademicos::create([
            'establecimiento_educativo' => strtoupper($request->establecimiento_educativo),
            'grado' => $request->grado ?? '',
            'escolaridad_id' => $request->escolaridad_id,
            'persona_id' => $persona_id,
            'titulo' => strtoupper($request->titulo) ?? '',
        ]);

        if($datosAcademicos) {
            return $datosAcademicos;
        }

    }

    public function update(Request $request, PerPersonas $persona) {

    }

    public function destroy(string $id) {
        //
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Gds\DireccionesDomiciliares;
use App\Models\Gds\EmpEmpleados;
use App\Models\Gds\GruposZonas;
use App\Models\Gds\Usuario;
use App\Rules\ValidateCui;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'primer_nombre'             => 'required|string',
            'primer_apellido'           => 'required|string',
            'cui'                       => ['required','numeric','digits:13',new ValidateCui,'unique:emp_empleados,cui'],
            'fecha_nacimiento'          => 'required|date',
            'sexo'                      => 'required|string',
            'grupo_etnico_id'           => 'required',
            'di_direccion_id'           => 'required',
            'password'                  => 'required|string|min:8|max:15|confirmed'
        ]);

        try {
            
            $empleado = EmpEmpleados::create([
                'primer_nombre'             => ucwords(strtolower(trim($request->primer_nombre))),
                'segundo_nombre'            => ucwords(strtolower(trim($request->segundo_nombre))) ?? '',
                'tercer_nombre'             => ucwords(strtolower(trim($request->tercer_nombre))) ?? '',
                'primer_apellido'           => ucwords(strtolower(trim($request->primer_apellido))),
                'segundo_apellido'          => ucwords(strtolower(trim($request->segundo_apellido))) ?? '',
                'apellido_casada'           => ucwords(strtolower(trim($request->apellido_casada))) ?? '',
                'fecha_nacimiento'          => $request->fecha_nacimiento,
                'sexo'                      => $request->sexo,
                'cui'                       => $request->cui,
                'lugar_nacimiento'          => $request->lugar_nacimiento ?? '',
                'no_interlocutor'           => $request->no_interlocutor ?? '',
                'grupo_etnico_id'           => $request->grupo_etnico_id,
                'di_direccion_id'           => $request->di_direccion_id
            ]);


            if($empleado){

                $user = Usuario::create([
                    'cui' => $request->cui,
                    'password' => Hash::make($request->password),
                    'empleado_id' => $empleado->id
                ]);

                if($user){
                    
                    return response([
                        'status' => 'ok',
                        'message' => 'Usuario creado exitosamente'
                    ]);
                }
            }
            
            return response([
                'status' => 'error',
                'message' => 'No se puedo crear registro'
            ]);
            
        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }
}

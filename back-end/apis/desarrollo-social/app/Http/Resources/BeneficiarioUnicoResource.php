<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeneficiarioUnicoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'cui' => $this->cui,
            'nit' => $this->nit_alumno,
            'pasaporte' => $this->pasaporte_alumno,
            'primer_nombre' => $this->primer_nombre,
            'segundo_nombre' => $this->segundo_nombre,
            'tercer_nombre' => $this->tercer_nombre,
            'primer_apellido' => $this->primer_apellido,
            'segundo_apellido' => $this->segundo_apellido,
            'apellido_casada' => $this->apellido_casada,
            'sexo' => $this->sexo,
            'fecha_nacimiento' => date('Y-m-d',strtotime($this->fecha_nacimiento)),
            
            'telefono' => $this->telefono,
            'celular' => $this->celular_alum,
            'correo' => $this->correo_alumno,
            'estado_civil' => $this->estado_civil,

            'escuela_tipo' => $this->escuela_tipo,
            'establecimiento_educativo' => $this->nombre_escuela,


            'nombre_responsable' => $this->responsable,
            'nombre_responsable' => $this->primer_nombre_r . ' '.$this->segundo_nombre_r. ' '.$this->segundo_nombre_r. ' '.$this->tercer_nombre_r.' '.$this->primer_apellido_r.' '.$this->segundo_apellido_r,
            'cui_responsable' => $this->dpi_responsable,
            'correo_responsable' => $this->correo_respons,
            'telefono_responsable' => $this->telefono_responsable,
            'celular_responsable' => $this->celular_resp,

            'nombre_emergencia' => $this->responsable_emergencia,

        ];
    }
}

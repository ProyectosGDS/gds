<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class PerPersonas extends Model
{
    protected $connection = 'gds';    
    protected $table = 'PER_PERSONAS';
    public $timestamps = false;
    protected $fillable = [
        'primer_nombre',
        'segundo_nombre',
        'tercer_nombre',
        'primer_apellido',
        'segundo_apellido',
        'apellido_casada',
        'cui',
        'fecha_nacimiento',
        'sexo',
        'lugar_nacimiento',
        'no_interlocutor',
        'nit',
        'pasaporte',
        'direccion_domiciliar_id',
        'grupo_etnico_id',
    ];

    // RELACIONES INVERSAS
    public function direccionDomiciliar() {
        return $this->belongsTo(DireccionesDomiciliares::class,'direccion_domiciliar_id','id');
    }

    public function grupoEtnico() {
        return $this->belongsTo(GruposEtnicos::class,'grupo_etnico_id','id');
    }

    // RELACIONES

    public function datosAcademicos() {
        return $this->hasMany(PerDatosAcademicos::class,'persona_id','id');
    }

    public function datosContacto() {
        return $this->hasMany(PerDatosContacto::class,'persona_id','id');
    }

    public function datosMedicos() {
        return $this->hasMany(PerDatosMedicos::class,'persona_id','id');
    }

    public function responsables() {
        return $this->hasMany(PerResponsables::class,'persona_id','id');
    }



}

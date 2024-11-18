<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class PerPersonas extends Model
{
    protected $connection = 'gds';    
    protected $table = 'PER_PERSONAS';
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
        'grupo_etnico_id',
        'status_id',
        'di_direccion_id'
    ];

    protected $appends = ["fullname"];

    // RELACIONES INVERSAS
    public function direccionDomiciliar() {
        return $this->hasOne(PerDireccionesDomiciliares::class,'persona_id','id');
    }

    public function grupoEtnico() {
        return $this->belongsTo(GruposEtnicos::class,'grupo_etnico_id','id');
    }

    public function status() {
        return $this->belongsTo(EscStatus::class);
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

    public function getFullNameAttribute()
    {
      return $this->primer_nombre .' ' . $this->segundo_nombre .' ' . $this->primer_apellido .' ' . $this->segundo_apellido;
    }



}

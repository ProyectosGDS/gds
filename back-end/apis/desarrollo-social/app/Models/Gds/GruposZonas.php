<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class GruposZonas extends Model
{
    protected $connection = 'gds';    
    protected $table = 'GRUPOS_ZONAS';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'zona_id',
        'grupo_habitacional_id',
    ];

    // RELACIONES INVERSAS
    public function zona() {
        return $this->belongsTo(Zonas::class,'zona_id','id');
    }

    public function gruposHabitacionales() {
        return $this->belongsTo(GruposHabitacionales::class,'grupo_habitacional_id','id');
    }

    // RELACIONES

    public function direccionDomiciliar() {
        return $this->hasMany(PerDireccionesDomiciliares::class,'grupos_zonas_id','id');
    }
}

<?php

namespace App\Models\Gds;


use Illuminate\Database\Eloquent\Model;

class PerDireccionesDomiciliares extends Model
{
    protected $connection = 'gds';    
    protected $table = 'PER_DIRECCIONES_DOMICILIARES';
    public $timestamps = false;
    protected $fillable = [
        'calle',
        'avenida',
        'complemento',
        'direccion',
        'municipio_id',
        'grupo_zona_id',
        'persona_id',
    ];

 
    // RELACIONES INVERSAS

    public function personas() {
        return $this->belongsTo(PerPersonas::class,'persona_id','id');
    }

    public function grupoZona() {
        return $this->belongsTo(GruposZonas::class,'grupo_zona_id','id');
    }
}

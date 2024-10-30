<?php

namespace App\Models\Gds;


use Illuminate\Database\Eloquent\Model;

class DireccionesDomiciliares extends Model
{
    protected $connection = 'gds';    
    protected $table = 'DIRECCIONES_DOMICILIARES';
    public $timestamps = false;
    protected $fillable = [
        'direccion',
        'municipio_id',
        'grupo_zona_id',
    ];


    // RELACIONES

    public function personas() {
        return $this->hasMany(PerPersonas::class,'direccion_domiciliar_id','id');
    }


    // RELACIONES INVERSAS

    public function grupoZona() {
        return $this->belongsTo(GruposZonas::class,'grupo_zona_id','id');
    }
}

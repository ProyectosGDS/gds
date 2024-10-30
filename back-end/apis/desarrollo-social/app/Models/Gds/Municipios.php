<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class Municipios extends Model
{
    protected $connection = 'gds';    
    protected $table = 'MUNICIPIOS';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'deleted_at',
        'departamento_id'
    ];

    // RELACIONES INVERSAS
    public function departamento() {
        return $this->belongsTo(Departamentos::class,'departamento_id','id');
    }

    // RELACIONES

    public function direccionesDomiciliares() {
        return $this->hasMany(DireccionesDomiciliares::class,'municipio_id','id');
    }
}

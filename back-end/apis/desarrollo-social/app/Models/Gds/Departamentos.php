<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class Departamentos extends Model
{
    protected $connection = 'gds';    
    protected $table = 'DEPARTAMENTOS';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'pais_id',
        'deleted_at',
    ];

    // RELACIONES INVERSAS
    public function pais() {
        return $this->belongsTo(Paises::class,'pais_id','id');
    }

    // RELACIONES

    public function municipios() {
        return $this->hasMany(Municipios::class,'departamento_id','id');
    }
}

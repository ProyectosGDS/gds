<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class PerDatosAcademicos extends Model
{
    protected $connection = 'gds';    
    protected $table = 'PER_DATOS_ACADEMICOS';
    public $timestamps = false;
    protected $fillable = [
        'establecimiento_educativo',
        'grado',
        'titulo',
        'escolaridad_id',
        'persona_id',
    ];

    public function escolaridad() {
        return $this->belongsTo(Escolaridades::class,'escolaridad_id','id');
    }

    public function persona() {
        return $this->belongsTo(PerPersonas::class,'persona_id','id');
    }
}

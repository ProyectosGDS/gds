<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class PerDatosMedicos extends Model
{
    protected $connection = 'gds';    
    protected $table = 'PER_DATOS_MEDICOS';
    public $timestamps = false;
    protected $fillable = [
        'alergias',
        'medicamentos',
        'dosis_medicamento',
        'enfermedad_id',
        'tipo_sangre_id',
        'persona_id',
    ];


    public function enfermedades() {
        return $this->belongsTo(Enfermedades::class,'enfermedad_id','id');
    }

    public function tipoSangre() {
        return $this->belongsTo(TipoSangre::class,'tipo_sangre_id','id');
    }

    public function persona() {
        return $this->belongsTo(PerPersonas::class,'persona_id','id');
    }
}

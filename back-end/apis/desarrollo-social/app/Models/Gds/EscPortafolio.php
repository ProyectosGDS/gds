<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class EscPortafolio extends Model
{
    protected $connection = 'gds';    
    protected $table = 'ESC_PORTAFOLIO';
    public $timestamps = false;
    protected $fillable = [
        'programa_id',
        'nivel_id',
        'seccion_id',
        'curso_id',
        'instructor_id',
        'horario_id',
        'sede_id',
        'modalidad',
    ];

    // RELACIONES

    public function programa() {
        return $this->belongsTo(EscProgramas::class,'programa_id','id');
    }
    public function nivel() {
        return $this->belongsTo(EscNiveles::class,'nivel_id','id');
    }
    public function seccion() {
        return $this->belongsTo(EscSecciones::class,'seccion_id','id');
    }
    public function curso() {
        return $this->belongsTo(EscCursos::class,'curso_id','id');
    }
    public function instructor() {
        return $this->belongsTo(EscInstructores::class,'instructor_id','id');
    }
    public function horario() {
        return $this->belongsTo(EscHorarios::class,'horario_id','id');
    }
    public function sede() {
        return $this->belongsTo(EscSedes::class,'sede_id','id');
    }
}

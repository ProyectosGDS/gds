<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class EscCursos extends Model
{
    protected $connection = 'gds';    
    protected $table = 'ESC_CURSOS';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'descripcion',
        'deleted_at',
    ];

    //RELACIONES

    public function instructores() {
        return $this->belongsToMany(EscInstructores::class,'esc_portafolio','curso_id','instructor_id')->withPivot('programa_id','nivel_id','seccion_id');
    }

    public function categoria() {
        return $this->belongsTo(EscCategoriaCursos::class,'categoria_id','id');
    }

    
}

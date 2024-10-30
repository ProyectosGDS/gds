<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class EscSecciones extends Model
{
    protected $connection = 'gds';    
    protected $table = 'ESC_SECCIONES';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'deleted_at',
    ];


    // RELACIONES INVERSAS

    public function cursos() {
        return $this->belongsToMany(EscCursos::class,'esc_portafolio','seccion_id','curso_id')->withPivot('nivel_id','programa_id');
    }

}

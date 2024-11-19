<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EscCursos extends Model
{
    protected $connection = 'gds';    
    protected $table = 'ESC_CURSOS';
    public $timestamps = false;
    public $appends = [
        'imageEncode'
    ];

    protected $fillable = [
        'nombre',
        'descripcion',
        'cupo',
        'categoria_id',
        'imagen',
        'deleted_at',
        'libre',
        'precio',
    ];

    //RELACIONES

    public function instructores() {
        return $this->belongsToMany(EscInstructores::class,'esc_portafolio','curso_id','instructor_id')->withPivot('programa_id','nivel_id','seccion_id');
    }

    public function categoria() {
        return $this->belongsTo(EscCategoriaCursos::class,'categoria_id','id');
    }

    public function requisitos() {
        return $this->belongsToMany(EscRequisitos::class,'esc_cursos_requisitos','curso_id','requisito_id');
    }

    public function getImageEncodeAttribute() {
        $image = Storage::get('public/escuelas/cursos/'.$this->imagen);
        return base64_encode($image);
    }

    
}

<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscRequisitos extends Model
{
    protected $connection = 'gds';    
    protected $table = 'ESC_REQUISITOS';
    public $timestamps = false;

    // RELACION

    public function cursos() {
        return $this->belongsToMany(EscCursos::class,'cursos_requisitos','requisito_id','curso_id');
    }
}

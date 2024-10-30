<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscHorarios extends Model
{
    protected $connection = 'gds';    
    protected $table = 'ESC_HORARIOS';
    public $timestamps = false;
    protected $fillable = [
        'dia',
        'hora_inicial',
        'hora_final',
        'deleted_at',
    ];

    // RELACIONES INVERSAS

    public function curso() {
        return $this->belongsTo(EscCursos::class,'curso_id','id');
    }
}

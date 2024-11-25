<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class EscEscuelas extends Model
{
    protected $connection = 'gds';    
    protected $table = 'ESC_ESCUELAS';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'descripcion',
        'deleted_at',
        'di_direccion_id',
    ];


    // RELACIONES

    public function programas() {
        return $this->belongsToMany(EscProgramas::class,'esc_escuelas_programas','escuela_id','programa_id');
    }
    
    // RELACIONES INVERSAS

    public function direccion() {
        return $this->belongsTo(DiDirecciones::class,'direccion_id','id');
    }

    public function alumnos() {
        return;
    }
}

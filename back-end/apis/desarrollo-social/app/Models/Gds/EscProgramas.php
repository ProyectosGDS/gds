<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class EscProgramas extends Model
{
    protected $connection = 'gds';    
    protected $table = 'ESC_PROGRAMAS';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'descripcion',
        'deleted_at',
        'di_direccion_id'
    ];

    // RELACIONES

    public function niveles() {
        return $this->belongsToMany(EscNiveles::class,'esc_portafolio','programa_id','nivel_id');
    }

    // RELACIONES INVERSAS

    public function escuela() {
        return $this->belongsToMany(EscEscuelas::class,'esc_escuelas_programas','programa_id','escuela_id');
    }

    public function direccion() {
        return $this->belongsTo(DiDirecciones::class,'di_direccion_id','id');
    }
}

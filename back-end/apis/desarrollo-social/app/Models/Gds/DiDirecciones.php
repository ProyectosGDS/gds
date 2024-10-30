<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class DiDirecciones extends Model
{
    protected $connection = 'gds';    
    protected $table = 'DI_DIRECCIONES';
    protected $fillable = [
        'nombre',
        'descripcion',
        'deleted_at'
    ];

    // RELACIONES
    public function escuelas() {
        return $this->hasMany(EscEscuelas::class,'di_direccion_id','id');
    }

    public function programas() {
        return $this->hasMany(EscProgramas::class,'di_direccion_id','id');
    }

}

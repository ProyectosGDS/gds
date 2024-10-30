<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSangre extends Model
{
    protected $connection = 'gds';    
    protected $table = 'TIPO_SANGRE';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
    ];

    // RELACIONES
    public function datosMedicos() {
        return $this->hasMany(PerDatosMedicos::class,'tipo_sangre_id','id');
    }
}

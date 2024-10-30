<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class Escolaridades extends Model
{
    protected $connection = 'gds';    
    protected $table = 'ESCOLARIDADES';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
    ];


    // RELACIONES

    public function datosAcademicos() {
        return $this->hasMany(PerDatosAcademicos::class,'escolaridad_id','id');
    }
}

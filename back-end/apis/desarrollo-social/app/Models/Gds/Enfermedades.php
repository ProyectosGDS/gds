<?php

namespace App\Models\Gds;


use Illuminate\Database\Eloquent\Model;

class Enfermedades extends Model
{
    protected $connection = 'gds';    
    protected $table = 'ENFERMEDADES';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
    ];


    // RELACIONES

    public function datosMedicos() {
        return $this->hasMany(PerDatosMedicos::class,'enfermedad_id','id');
    }
}

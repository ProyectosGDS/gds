<?php

namespace App\Models\Gds;


use Illuminate\Database\Eloquent\Model;

class GruposEtnicos extends Model
{
    protected $connection = 'gds';    
    protected $table = 'GRUPOS_ETNICOS';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
    ];


    // RELACIONES

    public function personas() {
        return $this->hasMany(PerPersonas::class,'grupo_etnico_id','id');
    }
}

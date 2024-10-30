<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class Parentescos extends Model
{
    protected $connection = 'gds';    
    protected $table = 'PARENTESCOS';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
    ];

    // RELACIONES INVERSAS
    public function pais() {
        return $this->belongsTo(Paises::class,'pais_id','id');
    }

    // RELACIONES
    public function responsables() {
        return $this->hasMany(PerResponsables::class,'parentesco_id','id');
    }
}

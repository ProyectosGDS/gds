<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class Paises extends Model
{
    protected $connection = 'gds';    
    protected $table = 'PAISES';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'deleted_at',
    ];


    // RELACIONES
    public function departamentos() {
        return $this->hasMany(Departamentos::class,'pais_id','id');
    }
}

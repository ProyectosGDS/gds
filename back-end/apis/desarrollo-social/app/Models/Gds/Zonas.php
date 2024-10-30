<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class Zonas extends Model
{
    protected $connection = 'gds';    
    protected $table = 'ZONAS';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
    ];


    // RELACIONES

    public function gruposZonas() {
        return $this->hasMany(GruposZonas::class,'zona_id','id');
    }
}

<?php

namespace App\Models\Gds;


use Illuminate\Database\Eloquent\Model;

class GruposHabitacionales extends Model
{
    protected $connection = 'gds';    
    protected $table = 'GRUPOS_HABITACIONALES';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'deleted_at',
    ];


    // RELACIONES

    public function grupos_zonas() {
        return $this->hasMany(GruposZonas::class,'grupo_habitacional_id','id');
    }
}

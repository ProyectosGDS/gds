<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $connection = 'gds';    
    
    protected $table = 'PERMISOS';
    
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'app'
    ];
}

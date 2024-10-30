<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class PerDatosContacto extends Model
{
    protected $connection = 'gds';    
    protected $table = 'PER_DATOS_CONTACTO';
    public $timestamps = false;
    protected $fillable = [
        'telefono',
        'celular',
        'correo',
        'facebook',
        'instagram',
        'tiktok',
        'persona_id',
    ];


    public function persona() {
        return $this->belongsTo(PerPersonas::class,'persona_id','id');
    }
}

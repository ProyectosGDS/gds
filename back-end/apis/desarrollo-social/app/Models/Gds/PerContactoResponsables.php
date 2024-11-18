<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class PerContactoResponsables extends Model
{
    protected $connection = 'gds';    
    protected $table = 'PER_CONTACTO_RESPONSABLES';
    public $timestamps = false;
    protected $fillable = [

        'persona_id',
        'parentesco_id',
        'cui',
        'nombre',
        'zona_id',
        'direccion_domiciliar',
        'celular',
        'correo',
        'sexo',

    ];

    // RELACIONES INVERSAS
    public function parentesco() {
        return $this->belongsTo(Parentescos::class,'parentesco_id','id');
    }

    public function persona() {
        return $this->belongsTo(PerPersonas::class,'persona_id','id');
    }
}

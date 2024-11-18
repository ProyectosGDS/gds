<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class PerContactoEmergencia extends Model
{
    protected $connection = 'gds';    
    protected $table = 'PER_CONTACTO_EMERGENCIA';
    public $timestamps = false;
    protected $fillable = [
        'cui',
        'nombre',
        'celular',
        'correo',
        'sexo',
        'direccion_domiciliar',
        'zona_id',
        'persona_id',
        'parentesco_id',
    ];

    // RELATIONS

    public function zona() {
        return $this->belongsTo(Zonas::class,'zona_id','id');
    }

    public function persona() {
        return $this->belongsTo(PerPersonas::class,'persona_id','id');
    }
}

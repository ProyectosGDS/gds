<?php

namespace App\Models\Gds;


use Illuminate\Database\Eloquent\Model;


class EscSedes extends Model
{
    protected $connection = 'gds';    
    protected $table = 'ESC_SEDES';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'direccion',
        'zona_id',
        'deleted_at',
    ];

    // RELATIONS REVERSE

    public function zona() {
        return $this->belongsTo(Zonas::class,'zona_id','id');
    }

}

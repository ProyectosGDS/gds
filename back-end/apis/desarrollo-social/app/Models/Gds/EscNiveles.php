<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class EscNiveles extends Model
{
    protected $connection = 'gds';    
    protected $table = 'ESC_NIVELES';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'descripcion',
        'deleted_at',
    ];

    // RELACIONES

    public function secciones() {
        return $this->belongsToMany(EscSecciones::class,'esc_portafolio','nivel_id','seccion_id')->withPivot('programa_id');
    }

}

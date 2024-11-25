<?php

namespace App\Models\Eventos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    protected $table = 'ev_eventos';
    
    protected $fillable = [
        'tipo_evento_id',
        'direccion_id',
        'titulo',
        'descripcion',
        'ubicacion',
        'fecha',
        'hora_inicial',
        'hora_final',
        'responsable',
    ];

    public function tipoEvento()
    {
        return $this->belongsTo(TipoEvento::class);
    }
}

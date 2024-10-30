<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class EscIncripciones extends Model
{
    protected $connection = 'gds';    
    protected $table = 'ESC_INSCRIPCIONES';
    protected $fillable = [
        'portafolio_id',
        'persona_id',
        'usuario_id',
    ];
}

<?php

namespace App\Models\Eventos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEvento extends Model
{
    use HasFactory;
    protected $table = 'tipo_eventos';
    protected $fillable = ['descripcion'];
    public $timestamps = false;

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }
}

<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class EscCategoriaCursos extends Model
{
    protected $connection = 'gds';    
    protected $table = 'ESC_CATEGORIA_CURSOS';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'deleted_at',
    ];

    // RELATIONS

    public function cursos() {
        return $this->hasMany(EscCursos::class,'categoria_id','id');
    }
}

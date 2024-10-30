<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class PerResponsables extends Model
{
    protected $connection = 'gds';    
    protected $table = 'PER_RESPONSABLES';
    public $timestamps = false;
    protected $fillable = [
        'persona_id',
        'parentesco_id',
        'responsable_id',
    ];

    // RELACIONES INVERSAS
    public function parentesco() {
        return $this->belongsTo(Parentescos::class,'parentesco_id','id');
    }

    public function responsable() {
        return $this->belongsTo(PerPersonas::class,'responsable_id','id');
    }

    public function persona() {
        return $this->belongsTo(PerPersonas::class,'persona_id','id');
    }
}

<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class EscStatus extends Model
{
    protected $connection = 'gds';    
    protected $table = 'ESC_STATUS';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
    ];
}

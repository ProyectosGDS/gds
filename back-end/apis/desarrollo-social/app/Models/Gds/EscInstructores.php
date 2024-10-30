<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscInstructores extends Model
{
    protected $connection = 'gds';    
    protected $table = 'ESC_INSTRUCTORES';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'deleted_at'
    ];

}

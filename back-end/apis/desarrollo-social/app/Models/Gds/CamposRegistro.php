<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class CamposRegistro extends Model
{
    protected $connection = 'gds';    
    protected $table = 'CAMPOS_REGISTRO';
    public $timestamps = false;
}

<?php

namespace App\Models\Muni;


use Illuminate\Database\Eloquent\Model;

class TbBeneficiarioUnico extends Model
{
    protected $connection = 'oracle';    
    protected $table = 'TB_BENEFICIARIO_UNICO';
    public $timestamps = false;
}

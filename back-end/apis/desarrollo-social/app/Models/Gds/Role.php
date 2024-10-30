<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $connection = 'gds';    
    
    protected $table = 'ROLES';
    
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'app'
    ];

    public function permisos() {
        return $this->belongsToMany(Permiso::class,'permisos_roles','role_id','permiso_id')->orderBy('id','desc');
    }

}

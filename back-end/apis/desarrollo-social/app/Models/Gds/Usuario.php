<?php

namespace App\Models\Gds;

use App\Traits\Jwt;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{

    use Jwt;

    protected $connection = 'gds';    
    
    protected $table = 'USUARIOS';

    protected $fillable = [
        'cui',
        'password',
        'deleted_at',
        'empleado_id',
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function roles() {
        return $this->belongsToMany(Role::class,'roles_usuarios','usuario_id','role_id');
    }

    public function empleado() {
        return $this->belongsTo(EmpEmpleados::class,'empleado_id','id');
    }

}

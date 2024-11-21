<?php

namespace App\Models\Gds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class pcCarousel extends Model
{
    protected $connection = 'gds';    
    protected $table = 'PC_CAROUSEL';
    public $timestamps = false;
    protected $appends = [
        'url'
    ];

    protected $fillable = [
        'nombre',
        'link',
        'path',
    ];

    public function getUrlAttribute() {
        $url = Storage::url($this->path);
        return $url;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adjunto extends Model
{
    protected $table = 'adm_adjuntos';
    protected $fillable = [
        'idtipoadjunto',
        'idproyecto',
        'descripcion',
        'url'
    ];
}

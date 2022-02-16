<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'cc_comentarios';
    protected $fillable = [
        'idproyecto',
        'comentario'
    ];
}

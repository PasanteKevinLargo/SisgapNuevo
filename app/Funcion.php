<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funcion extends Model
{
    protected $table = 'rol_funciones';
    protected $fillable = [
        'idcontrato',
        'detalle'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'rol_productos';
    protected $fillable = [
        'idcontrato',
        'detalle'
    ];
}

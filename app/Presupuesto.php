<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    protected $table = 'adm_presupuestos';
    protected $fillable = [
        'idproyecto',
        'idcontrato',
        'codeplan',
        'anio',
        'valor',
        'cantidad'
    ];
}

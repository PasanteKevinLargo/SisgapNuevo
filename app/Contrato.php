<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $table = 'rol_contrataciones';
    protected $primaryKey = 'ID_CONTRATACIONES';
    protected $fillable = [
        'ID_PROYECTO',
        'ID_PERSONAL',
        'CODE_PLAN',
        'TIPO_CONTRATO',
        'FECHAINICIO_CONTRATACIONES',
        'FECHAFIN_CONTRATACIONES',
        'MENSUAL_CONTRATACIONES',
        'ESTADO_CONTRATACIONES',
        'TOTAL_CONTRATACIONES',
        'FUNCIONES_CONTRATACIONES',
        'PRODUCTOS_CONTRATACIONES',
        'OBSERVACIONES_CONTRATACIONES',
        'REAL_OBSERVACIONES',
        'DIRECTOR',
        'DOCUMENT_PATH'
    ];
}

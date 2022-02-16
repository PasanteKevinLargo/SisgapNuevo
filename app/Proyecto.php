<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'cc_proyectos';
    protected $primaryKey = 'ID_PROYECTO';
    protected $fillable = [
        'ID_PERSONAL',
        'ID_FINANCIADOR',
        'ID_EJECUTOR',
        'ID_DIRECTOREXT',        
        'CODIGO_PROYECTO',
        'DESCRIPCION_PROYECTO',
        'FECHAINICIO_PROYECTO',
        'FECHAFIN_PROYECTO',
        'JUSTIFICACION_PROYECTO',
        'ALCANCE_PROYECTO',
        'COSTO_PROYECTO',
        'ADJUNTO1_PROYECTO',
        'ADJUNTO2_PROYECTO',
        'ESTADO_PROYECTO',
        'TIPO_PROYECTO',
        'TIPOINTERNO_PROYECTO',
        'AUTORIZAR',
        'ENTIDADAUTORIZA',
        'ESTADOAUTORIZA',
        'TOTALGRAND'
    ];
    public $incrementing = false;
}

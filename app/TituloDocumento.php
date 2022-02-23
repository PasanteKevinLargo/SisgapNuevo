<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TituloDocumento extends Model
{
    protected $table = 'titulodocumento';
    protected $primaryKey = 'ID_TITULODOC';
    protected $fillable = [
        'DESCRIPCION_TITULODOC',
        'CATEGORIA_TITULODOC',
    ];
    /*Se agrega el created y update para la tabla de titulodocumento*/
    const CREATED_AT = 'CREATED_TITULODOC';
    const UPDATED_AT = 'UPDATED_TITULODOC';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iva extends Model
{
    protected $table = 'lib_iva';
    protected $primaryKey = 'ID_IVA';
    protected $fillable = [
        'ID_CODSRI',
        'DESCRIPCION_IVA',
    ];
    /*Se agrega el created y update para la tabla de titulodocumento*/
    const CREATED_AT = 'CREATED_IVA';
    const UPDATED_AT = 'UPDATED_IVA';
}

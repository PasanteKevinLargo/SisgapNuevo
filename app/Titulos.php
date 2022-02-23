<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Titulos extends Model
{
    protected $table = 'adm_titulos';
    protected $primaryKey = 'ID_TITULO';
    protected $fillable = [
        'TITULO',
    ];
    /*Se agrega el created y update para la tabla de titulodocumento*/
    const CREATED_AT = 'CREATED_TITULO';
    const UPDATED_AT = 'UPDATED_TITULO';
}

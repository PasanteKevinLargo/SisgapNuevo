<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Firma extends Model
{
    protected $table = 'rh_cargos';
    protected $primaryKey = 'ID_CARGO';
    protected $fillable = [
        'NOMBRE_CARGO',
        'DESCRIPCION_CARGO',
        'TITULO_CARGO',
        'ID_UNIDAD',
    ];
    const CREATED_AT = 'CREATED_CARGO';
    const UPDATED_AT = 'UPDATED_CARGO';
}

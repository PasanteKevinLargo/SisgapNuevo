<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oficio extends Model
{
    protected $table = 'doc_oficios';
    protected $fillable = [
        'ID_PROYECTO',
        'ID_TITULODOC',
        'CONTENIDO_OFICIOS',
        'PARA_OFICIOS',
        'DE_OFICIOS',
        'CODIGO_OFICIO',
        'FECHA_OFICIO',
        'PERSONAL_OFICIO',
        'ID_CONTRATACIONES',
        'FIRMA1',
        'FIRMA2',
        'FIRMA3',
        'TIPO_OFICIO',
        'PROVEEDOR_OFICIOS',
        'NUMERO_DOCUMENTO_OFICIOS',
        'DOCUMENTO_OFICIOS',
        'ID_JUSTIFICATIONES',
        'CHECKBOX',
        'ADJUNTO_OFICIOS'
    ];
}

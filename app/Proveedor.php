<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'fin_proveedores';
    protected $primaryKey = 'ID_PROVEEDOR';
    protected $fillable = [
        'CODE_PROVEEDOR',
        'NOMBRE_PROVEEDOR',
        'APELLIDO_PROVEEDOR',
        'NOMBRETOTAL_PROVEEDOR',
        'DIRECCION1_PROVEEDOR',
        'TEL1_PROVEEDOR',
        'TEL2_PROVEEDOR',
        'TIPO_PROVEEDOR',
        'OBSERVACION_PROVEEDOR',
        'RUC_PROVEEDOR',
        'DSCTO_PROVEEDOR',
        'PLAZO_PROVEEDOR',
        'ACTIVO_PROVEEDOR',
        'SERIE_PROVEEDOR',
        'CODESPECIAL_PROVEEDOR',
        'AUTORIZACION_PROVEEDOR',
        'CADUCIDAD_PROVEEDOR',
    ];
    const CREATED_AT = 'CREATED_PROVEEDOR';
    const UPDATED_AT = 'UPDATED_PROVEEDOR';
}

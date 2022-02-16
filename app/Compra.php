<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'fin_trx';
    protected $primaryKey = 'ID_TRASTOCK';
    protected $fillable = [
        'ID_PROVEEDOR',
        'ID_PROYECTO',
        'ID_GRUPO',
        'ID_DETCENTRO',
        'ID_PERSONAL',
        'FECHA_TRASTOCK',
        'FECHAVEN_TRASTOCK',
        'SUBTOTAL_TRASTOCK',
        'SUBT0_TRASTOCK',
        'SUBT12_TRASTOCK',
        'SUBTNOIVA_TRASTOCK',
        'IVA_TRASTOCK',
        'ICE_TRASTOCK',
        'DESCUENTO_TRASTOCK',
        'TOTAL_TRASTOCK',
        'OTROS_TRASTOCK',
        'SALDO_TRASTOCK',
        'MAYORIZADO_TRASTOCK',
        'ID_JUSTIFICATIONES',
        'DESCRIPTION',
        'OBSERVACIONES_TRASTOCK',
        'AUTORIZACION_TRASTOCK',
        'ACCESSO_TRASTOCK',
        'CONCEPTO_TRASTOCK',
        'CODIGO_STOCK',
        'CUENTA_STOCK',
        'EXPORTACION_TRASTOCK',
        'REEMBOLSO_TRASTOCK'
    ];
}

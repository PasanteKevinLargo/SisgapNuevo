<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = 'rh_personal';
    protected $primaryKey = 'ID_PERSONAL';
    protected $fillable = [
        'ID_PERSONAL',
        'TIPODNI_PERSONAL',
        'NOMBRES_PERSONAL',
        'APELLIDOS_PERSONAL',
        'FOTO_PERSONAL',
        'SEXO_PERSONAL',
        'FECNAC_PERSONAL',
        'PROVDIR_PERSONAL',
        'CANTONDIR_PERSONAL',
        'PARROQDIR_PERSONAL',
        'SECTORDIR_PERSONAL',
        'DIRPRINC_PERSONAL',
        'DIRSECUND_PERSONAL',
        'NUMCASA_PERSONAL',
        'REFCASA_PERSONAL',
        'TELEFONO_PERSONAL',
        'CELULAR_PERSONAL',
        'TELINTERNAC_PERSONAL',
        'PAISNAC_PERSONAL',
        'PROVNAC_PERSONAL',
        'CANTONAC_PERSONAL',
        'PARROQUIA_PERSONAL',
        'MAILTRABAJO_PERSONAL',
        'EMAIL_PERSONAL',
        'ESTUDIO_PERSONAL',
        'PROFESION_PERSONAL',
        'TRATO_PERSONAL',
        'SUELDOREF_PERSONAL',
        'PROVEEDOR_PERSONAL',
        'CONTRATO_PERSONAL',
        'CHEQUE_PERSONAL',
        'ESTADO_PERSONAL',
        'GRUPOSANGRE_PERSONAL',
        'DISCAPACIDAD_PERSONAL',
        'PORCENTDISCAP_PERSONAL',
        'NUMCONADIS_PERSONAL',
        'ACTIVO_PERSONAL'
    ];
}

// public function user(){
//     return $this->hasOne('App\User');
// }

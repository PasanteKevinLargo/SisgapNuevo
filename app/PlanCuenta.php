<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanCuenta extends Model
{
    protected $table = 'lib_plancuentas';
    protected $primaryKey = 'CODE_PLAN';
    protected $fillable = [
        'ALTERNAT_PLAN',
        'NIVEL1_PLAN',
        'NIVEL2_PLAN',
        'NIVEL3_PLAN',
        'NIVEL4_PLAN',
        'NIVEL5_PLAN',
        'TAG_PLAN',
        'ID_PLANINTER',
        'REFERENCIA_PLAN'
    ];
}

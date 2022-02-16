<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Financiador extends Model
{
    protected $table = 'fin_financiador';
    protected $primaryKey = 'ID_FINANCIADOR';
    protected $fillable = [
        'NOMBRE_FINANCIADOR',
        'CONTACTO_FINANCIADOR',
        'TELEF1_FINANCIADOR',
        'TELEF2_FINANCIADOR',
        'TELEF3_FINANCIADOR',
        'EMAIL_FINANCIADOR'
    ];
}

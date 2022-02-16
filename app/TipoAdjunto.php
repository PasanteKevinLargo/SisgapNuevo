<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoAdjunto extends Model
{
    protected $table = 'adm_tipoadjuntos';
    protected $fillable = ['id', 'descripcion'];
}

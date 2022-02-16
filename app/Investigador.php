<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investigador extends Model
{
    protected $table = 'cc_investigadores';
    protected $fillable = [
        'idproyecto',
        'idinvestigador'
    ];
}

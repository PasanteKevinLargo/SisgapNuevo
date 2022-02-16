<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'adm_roles';
    protected $fillable = ['ID_ROLE','ROLE'];
    public $timestamps = false;
}

// public function user(){
//     return $this->hasMany('App\User');
// }

<?php

namespace App\Http\Controllers;
use App\Rol;

use Illuminate\Http\Request;

class RolController extends Controller
{
    public function selectRol(Request $request)
    {
        $roles = Rol::where('condicion', '=', '1')
        ->select('id','nombre')
        ->orderBy('id', 'asc')->get();
 
        return ['roles' => $roles];
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Producto;

class ProductoController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $registronuevo = new Producto();
        $registronuevo->id_contrato = $request->id_contrato;
        $registronuevo->detalle = $request->detalle;
        if ($registronuevo->save()) {
            return true;
        }
        else {
            return false;
        } 
    }

    public function index(Request $request)
    {
        $registros = DB::table('rol_productos AS A')
            ->select('A.id',
                'A.id_contrato',
                'A.detalle');
                $registros = $registros->where([
                    ['A.id_contrato', '=', $request->buscar],
                ]);

        $registros = $registros->get();
        return [
            'registros' => $registros,
        ];

    }
}

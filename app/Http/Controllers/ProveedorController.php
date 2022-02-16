<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    public function selectProveedor(Request $request)
    {
        $filtro = $request->filtro;
        $proveedores = DB::table('fin_proveedores AS A')
            ->select('ID_PROVEEDOR', 'NOMBRETOTAL_PROVEEDOR')
            ->where([
                ['A.NOMBRETOTAL_PROVEEDOR', 'like', '%' . $filtro . '%'],
            ])
            ->orderBy('NOMBRETOTAL_PROVEEDOR', 'asc')->get();

        return ['proveedores' => $proveedores];
    }
}

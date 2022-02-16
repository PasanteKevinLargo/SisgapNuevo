<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Compra;

class CompraController extends Controller
{

    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $ID_PROYECTO = $request->ID_PROYECTO;
        $registros = DB::table('fin_trx AS A')
            ->leftjoin('fin_proveedores as B', 'A.ID_PROVEEDOR', '=', 'B.ID_PROVEEDOR')
            ->leftjoin('cc_proyectos as C', 'A.ID_PROYECTO', '=', 'C.ID_PROYECTO')
            ->select('A.ID_TRASTOCK',
                'A.ID_JUSTIFICATIONES',
                'A.ID_PROYECTO',
                'B.NOMBRE_PROVEEDOR',
                'C.CODIGO_PROYECTO',
                'C.DESCRIPCION_PROYECTO',
                'A.AUTORIZACION_TRASTOCK',
                'A.SUBTOTAL_TRASTOCK',
                'A.FECHA_TRASTOCK')
            ->where('A.ID_PROYECTO', '=', $ID_PROYECTO)
            ->orderBy('A.ID_TRASTOCK', 'desc')->paginate(5);
        return [
            'pagination' => [
                'total' => $registros->total(),
                'current_page' => $registros->currentPage(),
                'per_page' => $registros->perPage(),
                'last_page' => $registros->lastPage(),
                'from' => $registros->firstItem(),
                'to' => $registros->lastItem(),
            ],
            'registros' => $registros,
        ];

    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $registronuevo = new Compra();
        $registronuevo->ID_PROVEEDOR = $request->ID_PROVEEDOR;
        $registronuevo->ID_PROYECTO = $request->ID_PROYECTO;
        $registronuevo->ID_PERSONAL = $request->ID_PERSONAL;
        $registronuevo->FECHA_TRASTOCK = $request->FECHA_TRASTOCK;
        $registronuevo->FECHAVEN_TRASTOCK = $request->FECHAVEN_TRASTOCK;
        $registronuevo->SUBTOTAL_TRASTOCK = $request->SUBTOTAL_TRASTOCK;
        $registronuevo->SUBT0_TRASTOCK = $request->SUBT0_TRASTOCK;
        $registronuevo->SUBT12_TRASTOCK = $request->SUBT12_TRASTOCK;
        $registronuevo->SUBTNOIVA_TRASTOCK = $request->SUBTNOIVA_TRASTOCK;
        $registronuevo->IVA_TRASTOCK = $request->IVA_TRASTOCK;
        $registronuevo->ICE_TRASTOCK = $request->ICE_TRASTOCK;
        $registronuevo->DESCUENTO_TRASTOCK = $request->DESCUENTO_TRASTOCK;
        $registronuevo->TOTAL_TRASTOCK = $request->TOTAL_TRASTOCK;
        $registronuevo->OTROS_TRASTOCK = $request->OTROS_TRASTOCK;
        $registronuevo->SALDO_TRASTOCK = $request->SALDO_TRASTOCK;
        $registronuevo->ID_JUSTIFICATIONES = $request->ID_JUSTIFICATIONES;
        $registronuevo->OBSERVACIONES_TRASTOCK = $request->OBSERVACIONES_TRASTOCK;
        $registronuevo->AUTORIZACION_TRASTOCK = $request->AUTORIZACION_TRASTOCK;
        $registronuevo->CODIGO_STOCK = $request->CODIGO_STOCK;
        $registronuevo->CUENTA_STOCK = $request->CUENTA_STOCK;
        $registronuevo->save();
        return true;

    }

    public function verRegistro(Request $request)
    {
        $registro = DB::table('fin_trx AS A')
            ->leftjoin('fin_proveedores as B', 'A.ID_PROVEEDOR', '=', 'B.ID_PROVEEDOR')
            ->leftjoin('rh_personal as C', 'A.ID_PERSONAL', '=', 'C.ID_PERSONAL')
            ->select('A.ID_TRASTOCK',
                'A.ID_PROVEEDOR',
                'A.ID_PERSONAL',
                'A.FECHA_TRASTOCK',
                'A.FECHAVEN_TRASTOCK',
                'A.SUBTOTAL_TRASTOCK',
                'A.SUBT0_TRASTOCK',
                'A.SUBT12_TRASTOCK',
                'A.SUBTNOIVA_TRASTOCK',
                'A.IVA_TRASTOCK',
                'A.ICE_TRASTOCK',
                'A.DESCUENTO_TRASTOCK',
                'A.TOTAL_TRASTOCK',
                'A.AUTORIZACION_TRASTOCK',
                'B.NOMBRETOTAL_PROVEEDOR',
                'C.NOMBRES_PERSONAL',
                'C.APELLIDOS_PERSONAL')
            ->where([
                ['A.ID_TRASTOCK', '=', $request->buscar],
            ])
            ->get();
        return [
            'registro' => $registro,
        ];

    }
}

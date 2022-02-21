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

    /*Se esta agregando la funcion index*/
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $registros = DB::table('fin_proveedores AS A')
            ->select('A.ID_PROVEEDOR',
                'A.CODE_PROVEEDOR',
                'A.NOMBRE_PROVEEDOR',
                'A.APELLIDO_PROVEEDOR',
                'A.NOMBRETOTAL_PROVEEDOR',
                'A.DIRECCION1_PROVEEDOR',
                'A.TEL1_PROVEEDOR',
                'A.TEL2_PROVEEDOR',
                'A.TIPO_PROVEEDOR',
                'A.OBSERVACION_PROVEEDOR',
                'A.RUC_PROVEEDOR',
                'A.DSCTO_PROVEEDOR',
                'A.PLAZO_PROVEEDOR',
                'A.ACTIVO_PROVEEDOR',
                'A.SERIE_PROVEEDOR',
                'A.CODESPECIAL_PROVEEDOR',
                'A.AUTORIZACION_PROVEEDOR',
                'A.CADUCIDAD_PROVEEDOR');

        if ($buscar != '') {
            $registros = $registros->whereRaw('(A.NOMBRE_PROVEEDOR LIKE "%' . $buscar . '%"
                        OR A.APELLIDO_PROVEEDOR LIKE "%' . $buscar . '%"
                        OR A.RUC_PROVEEDOR LIKE "%' . $buscar . '%")');
        }
        $registros = $registros->orderBy('A.NOMBRE_PROVEEDOR', 'asc')->paginate(10);
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

    /*Se esta agregando la funcion store*/
    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $registronuevo = new Proveedor();
        $registronuevo->NOMBRETOTAL_PROVEEDOR= $request-> NOMBRETOTAL_PROVEEDOR;
        $registronuevo->DIRECCION1_PROVEEDOR= $request-> DIRECCION1_PROVEEDOR;
        $registronuevo->TEL1_PROVEEDOR= $request-> TEL1_PROVEEDOR;
        $registronuevo->TEL2_PROVEEDOR= $request-> TEL2_PROVEEDOR;
        $registronuevo->TIPO_PROVEEDOR= $request-> TIPO_PROVEEDOR;
        $registronuevo->OBSERVACION_PROVEEDOR= $request-> OBSERVACION_PROVEEDOR;
        $registronuevo->RUC_PROVEEDOR= $request-> RUC_PROVEEDOR;
        $registronuevo->ACTIVO_PROVEEDOR= $request-> ACTIVO_PROVEEDOR;
        $registronuevo->save();
        return true;   
    }

     /*Se esta agregando la funcion update*/
    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $actualizar = Proveedor::findOrFail($request->id);
        $actualizar->NOMBRETOTAL_PROVEEDOR= $request-> NOMBRETOTAL_PROVEEDOR;
        $actualizar->DIRECCION1_PROVEEDOR= $request-> DIRECCION1_PROVEEDOR;
        $actualizar->TEL1_PROVEEDOR= $request-> TEL1_PROVEEDOR;
        $actualizar->TEL2_PROVEEDOR= $request-> TEL2_PROVEEDOR;
        $actualizar->TIPO_PROVEEDOR= $request-> TIPO_PROVEEDOR;
        $actualizar->OBSERVACION_PROVEEDOR= $request-> OBSERVACION_PROVEEDOR;
        $actualizar->RUC_PROVEEDOR= $request-> RUC_PROVEEDOR;
        $actualizar->ACTIVO_PROVEEDOR= $request-> ACTIVO_PROVEEDOR;
        $actualizar->save();
        return true;
    }

    /*Se esta agregando la funcion destroy*/
    public function destroy(Request $request)
    {
        $registro = Proveedor::findOrFail($request->id);
        $ok=$registro->delete();
        return ['borrado' => $ok];
    }
}



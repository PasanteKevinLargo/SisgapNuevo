<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Iva;
use Illuminate\Support\Facades\DB;

class IvaController extends Controller
{
    public function selectIva(Request $request)
    {
        $filtro = $request->filtro;
        $iva = DB::table('lib_iva AS A')
            ->select('ID_IVA', 'DESCRIPCION_IVA')
            ->where([
                ['A.DESCRIPCION_IVA', 'like', '%' . $filtro . '%'],
            ])
            ->orderBy('DESCRIPCION_IVA', 'asc')->get();

        return ['iva' => $iva];
    }

    /*Se esta agregando la funcion index*/
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $registros = DB::table('lib_iva AS A')
            ->select('A.ID_IVA',
                'A.DESCRIPCION_IVA',);

        if ($buscar != '') {
            $registros = $registros->whereRaw('(A.DESCRIPCION_IVA LIKE "%' . $buscar . '%"
                         OR A.ID_CODSRI LIKE "%' . $buscar . '%")');
        }
        $registros = $registros->orderBy('A.DESCRIPCION_IVA', 'asc')->paginate(10);
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

        $registronuevo = new Iva();
        $registronuevo->ID_CODSRI= $request-> ID_CODSRI;
        $registronuevo->DESCRIPCION_IVA= $request-> DESCRIPCION_IVA;
        $registronuevo->save();
        return true;   
    }

     /*Se esta agregando la funcion update*/
    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $actualizar = Iva::findOrFail($request->id);
        $actualizar->ID_CODSRI= $request->ID_CODSRI;
        $actualizar->DESCRIPCION_IVA= $request->DESCRIPCION_IVA;
        $actualizar->save();
        return true;
    }

    /*Se esta agregando la funcion destroy*/
    public function destroy(Request $request)
    {
        $registro = Iva::findOrFail($request->id);
        $ok=$registro->delete();
        return ['borrado' => $ok];
    } 
}

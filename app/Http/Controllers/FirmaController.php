<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Firma;
use Illuminate\Support\Facades\DB;

class FirmaController extends Controller
{
    public function selectFirma(Request $request)
    {
        $filtro = $request->filtro;
        $firma = DB::table('rh_cargos AS A')
            ->select('ID_CARGO', 'NOMBRE_CARGO')
            ->where([
                ['A.NOMBRE_CARGO', 'like', '%' . $filtro . '%'],
            ])
            ->orderBy('NOMBRE_CARGO', 'asc')->get();

        return ['firma' => $firma];
    }

    /*Se esta agregando la funcion index*/
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $registros = DB::table('rh_cargos AS A')
            ->select('A.ID_CARGO',
                'A.NOMBRE_CARGO',
                'A.DESCRIPCION_CARGO',
                'A.TITULO_CARGO',
                'A.ID_UNIDAD',);

        if ($buscar != '') {
            $registros = $registros->whereRaw('(A.NOMBRE_CARGO LIKE "%' . $buscar . '%"
                        OR A.DESCRIPCION_CARGO LIKE "%' . $buscar . '%"
                        OR A.TITULO_CARGO LIKE "%' . $buscar . '%")');
        }
        $registros = $registros->orderBy('A.NOMBRE_CARGO', 'asc')->paginate(10);
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

        $registronuevo = new Firma();
        $registronuevo->NOMBRE_CARGO= $request-> NOMBRE_CARGO;
        $registronuevo->DESCRIPCION_CARGO= $request-> DESCRIPCION_CARGO;
        $registronuevo->TITULO_CARGO= $request-> TITULO_CARGO;
        $registronuevo->ID_UNIDAD= $request-> ID_UNIDAD;
        $registronuevo->save();
        return true;   
    }

     /*Se esta agregando la funcion update*/
    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $actualizar = Firma::findOrFail($request->id);
        $actualizar->NOMBRE_CARGO= $request-> NOMBRE_CARGO;
        $actualizar->DESCRIPCION_CARGO= $request-> DESCRIPCION_CARGO;
        $actualizar->TITULO_CARGO= $request-> TITULO_CARGO;
        $actualizar->ID_UNIDAD= $request-> ID_UNIDAD;
        $actualizar->save();
        return true;
    }

    /*Se esta agregando la funcion destroy*/
    public function destroy(Request $request)
    {
        $registro = Firma::findOrFail($request->id);
        $ok=$registro->delete();
        return ['borrado' => $ok];
    }
}

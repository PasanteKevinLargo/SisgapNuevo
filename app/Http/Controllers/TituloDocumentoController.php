<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TituloDocumento;
use Illuminate\Support\Facades\DB;

class TituloDocumentoController extends Controller
{
    public function selectTituloDocumento(Request $request)
    {
        $filtro = $request->filtro;
        $titulodocumento = DB::table('titulodocumento AS A')
            ->select('ID_TITULODOC', 'DESCRIPCION_TITULODOC')
            ->where([
                ['A.DESCRIPCION_TITULODOC', 'like', '%' . $filtro . '%'],
            ])
            ->orderBy('DESCRIPCION_TITULODOC', 'asc')->get();

        return ['titulodocumento' => $titulodocumento];
    }

    /*Se esta agregando la funcion index*/
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $registros = DB::table('titulodocumento AS A')
            ->select('A.ID_TITULODOC',
                'A.DESCRIPCION_TITULODOC',
                'A.CATEGORIA_TITULODOC',);

        if ($buscar != '') {
            $registros = $registros->whereRaw('(A.DESCRIPCION_TITULODOC LIKE "%' . $buscar . '%"
                        OR A.CATEGORIA_TITULODOC "%' . $buscar . '%"');
        }
        $registros = $registros->orderBy('A.DESCRIPCION_TITULODOC', 'asc')->paginate(10);
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

        $registronuevo = new TituloDocumento();
        $registronuevo->DESCRIPCION_TITULODOC= $request-> DESCRIPCION_TITULODOC;
        $registronuevo->CATEGORIA_TITULODOC= $request-> CATEGORIA_TITULODOC;
        $registronuevo->save();
        return true;   
    }

     /*Se esta agregando la funcion update*/
    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $actualizar = TituloDocumento::findOrFail($request->id);
        $actualizar->DESCRIPCION_TITULODOC= $request-> DESCRIPCION_TITULODOC;
        $actualizar->CATEGORIA_TITULODOC= $request-> CATEGORIA_TITULODOC;
        $actualizar->save();
        return true;
    }

    /*Se esta agregando la funcion destroy*/
    public function destroy(Request $request)
    {
        $registro = TituloDocumento::findOrFail($request->id);
        $ok=$registro->delete();
        return ['borrado' => $ok];
    }
}

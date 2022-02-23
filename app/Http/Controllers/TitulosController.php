<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Titulos;
use Illuminate\Support\Facades\DB;

class TitulosController extends Controller
{
    public function selectTitulos(Request $request)
    {
        $filtro = $request->filtro;
        $titulos = DB::table('adm_titulos AS A')
            ->select('ID_TITULO', 'TITULO')
            ->where([
                ['A.TITULO', 'like', '%' . $filtro . '%'],
            ])
            ->orderBy('TITULO', 'asc')->get();

        return ['titulos' => $titulos];
    }

    /*Se esta agregando la funcion index*/
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $registros = DB::table('adm_titulos AS A')
            ->select('A.ID_TITULO',
                'A.TITULO',);

        if ($buscar != '') {
            $registros = $registros->whereRaw('(A.TITULO LIKE "%' . $buscar . '%")');
        }
        $registros = $registros->orderBy('A.TITULO', 'asc')->paginate(10);
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

        $registronuevo = new Titulos();
        $registronuevo->TITULO= $request-> TITULO;
        $registronuevo->save();
        return true;   
    }

     /*Se esta agregando la funcion update*/
    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $actualizar = Titulos::findOrFail($request->id);
        $actualizar->TITULO= $request->TITULO;
        $actualizar->save();
        return true;
    }

    /*Se esta agregando la funcion destroy*/
    public function destroy(Request $request)
    {
        $registro = Titulos::findOrFail($request->id);
        $ok=$registro->delete();
        return ['borrado' => $ok];
    } 
}

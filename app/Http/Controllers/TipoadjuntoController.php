<?php

namespace App\Http\Controllers;

use App\TipoAdjunto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoadjuntoController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $TipoAdjuntos = DB::table('adm_tipoadjuntos AS A')
            ->select('A.id',
                'A.descripcion');
        if ($buscar != '') {
            $TipoAdjuntos = $TipoAdjuntos->where('A.descripcion', 'like', '%' . $buscar . '%');
        }
        $TipoAdjuntos = $TipoAdjuntos->orderBy('A.id', 'asc')->paginate(10);
        return [
            'pagination' => [
                'total' => $TipoAdjuntos->total(),
                'current_page' => $TipoAdjuntos->currentPage(),
                'per_page' => $TipoAdjuntos->perPage(),
                'last_page' => $TipoAdjuntos->lastPage(),
                'from' => $TipoAdjuntos->firstItem(),
                'to' => $TipoAdjuntos->lastItem(),
            ],
            'datos' => $TipoAdjuntos,
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $registronuevo = new TipoAdjunto();
        $registronuevo->descripcion = $request->descripcion;
        $registronuevo->save();
        return true;

    }

    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $actualizar = TipoAdjunto::findOrFail($request->id);
        $actualizar->descripcion = $request->descripcion;
        $actualizar->save();
        return true;

    }

    public function select(Request $request)
    {
        $TipoAdjuntos = DB::table('adm_tipoadjuntos AS A')
            ->select('A.id',
                'A.descripcion');
        $TipoAdjuntos = $TipoAdjuntos->orderBy('A.id', 'asc')->get();
        return ['TipoAdjuntos' => $TipoAdjuntos];
    }
}

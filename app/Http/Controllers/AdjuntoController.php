<?php

namespace App\Http\Controllers;

use App\Adjunto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdjuntoController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $registronuevo = new Adjunto();
        $registronuevo->idtipoadjunto = $request->idtipoadjunto;
        $registronuevo->idproyecto = $request->idproyecto;
        $registronuevo->descripcion = $request->descripcion;
        $registronuevo->url = $request->url;
        $ok = $registronuevo->save();
        return $ok;

    }

    public function index(Request $request)
    {
        $registros = DB::table('adm_adjuntos AS A')
            ->leftjoin('adm_tipoadjuntos as B', 'A.idtipoadjunto', '=', 'B.id')
            ->select('A.id',
                'A.idtipoadjunto',
                'A.descripcion',
                'A.url',
                'B.descripcion as nombreadjunto')
            ->where([
                ['A.idproyecto', '=', $request->buscar],
            ])
            ->get();
        return [
            'adjuntos' => $registros,
        ];

    }

    public function destroy(Request $request)
    {
        $registro = Adjunto::findOrFail($request->id);
        $ok = $registro->delete();
        return ['borrado' => $ok];
    }
}

<?php

namespace App\Http\Controllers;

use App\Investigador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvestigadorController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $registronuevo = new Investigador();
        $registronuevo->idproyecto = $request->idproyecto;
        $registronuevo->idinvestigador = $request->idinvestigador;
        $registronuevo->save();
        return true;

    }

    public function verRegistro(Request $request)
    {
        $registros = DB::table('cc_investigadores AS A')
            ->leftjoin('rh_personal as B', 'A.idinvestigador', '=', 'B.ID_PERSONAL')
            ->select('A.id',
                'A.idinvestigador',
                'B.NOMBRES_PERSONAL',
                'B.APELLIDOS_PERSONAL')
            ->where([
                ['A.idproyecto', '=', $request->buscar],
            ])
            ->get();
        return [
            'participantes' => $registros,
        ];

    }

    public function destroy(Request $request)
    {
        $registro = Investigador::findOrFail($request->id);
        $ok=$registro->delete();
        return ['borrado' => $ok];
    }
}

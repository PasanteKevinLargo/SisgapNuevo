<?php

namespace App\Http\Controllers;

use App\Presupuesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PresupuestoController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $registronuevo = new Presupuesto();
        $registronuevo->idproyecto = $request->idproyecto;
        $registronuevo->idcontrato = $request->idcontrato;
        $registronuevo->codeplan = $request->CODE_PLAN;
        $registronuevo->anio = $request->anio;
        $registronuevo->valor = $request->valor;
        $ok = $registronuevo->save();
        return true;

    }

    public function index(Request $request)
    {
        $registros = DB::table('adm_presupuestos AS A')
        ->leftjoin('lib_plancuentas as B', 'A.codeplan', '=', 'B.CODE_PLAN')
            ->select('A.id',
                'A.idproyecto',
                'A.idcontrato',
                'A.codeplan',
                'B.TAG_PLAN',
                'A.anio',
                'A.valor');
        if ($request->idcontrato == 0) {
            $registros = $registros->where([
                ['A.idproyecto', '=', $request->buscar],
            ]);
        } else {
            $registros = $registros->where([
                ['A.idcontrato', '=', $request->idcontrato],
            ]);
        }

        $registros = $registros->get();
        return [
            'presupuestos' => $registros,
        ];

    }

    public function destroy(Request $request)
    {
        $registro = Presupuesto::findOrFail($request->id);
        $ok = $registro->delete();
        return ['borrado' => $ok];
    }
}

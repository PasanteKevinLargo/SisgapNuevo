<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Financiador;

class FinanciadorController extends Controller
{
    public function selectFinanciador(Request $request)
    {
        $filtro = $request->filtro;
        $financiadores = DB::table('fin_financiador AS A')
            ->select('ID_FINANCIADOR', 'NOMBRE_FINANCIADOR AS NOMBRE')
            ->where([
                ['A.NOMBRE_FINANCIADOR', 'like', '%' . $filtro . '%'],
            ])
            ->orderBy('NOMBRE_FINANCIADOR', 'asc')->get();

            return ['financiadores' => $financiadores];
    }

    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $registros = DB::table('fin_financiador AS A')
            ->select('A.ID_FINANCIADOR',
                'A.NOMBRE_FINANCIADOR',
                'A.CONTACTO_FINANCIADOR',
                'A.TELEF1_FINANCIADOR',
                'A.TELEF2_FINANCIADOR',
                'A.TELEF3_FINANCIADOR',
                'A.EMAIL_FINANCIADOR');
        if ($buscar != '') {
            $registros = $registros->whereRaw('(A.NOMBRE_FINANCIADOR LIKE "%' . $buscar . '%"
                        OR A.CONTACTO_FINANCIADOR LIKE "%' . $buscar . '%"
                        OR A.EMAIL_FINANCIADOR LIKE "%' . $buscar . '%")');
        }
        $registros = $registros->orderBy('A.NOMBRE_FINANCIADOR', 'asc')->paginate(10);
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

        $registronuevo = new Financiador();
        $registronuevo->NOMBRE_FINANCIADOR = $request->NOMBRE_FINANCIADOR;
        $registronuevo->CONTACTO_FINANCIADOR = $request->CONTACTO_FINANCIADOR;
        $registronuevo->TELEF1_FINANCIADOR = $request->TELEF1_FINANCIADOR;
        $registronuevo->TELEF2_FINANCIADOR = $request->TELEF2_FINANCIADOR;
        $registronuevo->TELEF3_FINANCIADOR = $request->TELEF3_FINANCIADOR;
        $registronuevo->EMAIL_FINANCIADOR = $request->EMAIL_FINANCIADOR;
        $registronuevo->save();
        return true;

    }

    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $actualizar = Financiador::findOrFail($request->id);
        $actualizar->NOMBRE_FINANCIADOR = $request->NOMBRE_FINANCIADOR;
        $actualizar->CONTACTO_FINANCIADOR = $request->CONTACTO_FINANCIADOR;
        $actualizar->TELEF1_FINANCIADOR = $request->TELEF1_FINANCIADOR;
        $actualizar->TELEF2_FINANCIADOR = $request->TELEF2_FINANCIADOR;
        $actualizar->TELEF3_FINANCIADOR = $request->TELEF3_FINANCIADOR;
        $actualizar->EMAIL_FINANCIADOR = $request->EMAIL_FINANCIADOR;
        $actualizar->save();
        return true;
    }

    public function destroy(Request $request)
    {
        $registro = Financiador::findOrFail($request->id);
        $ok=$registro->delete();
        return ['borrado' => $ok];
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Contrato;

class ContratoController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $ID_PROYECTO = $request->ID_PROYECTO;
        $registros = DB::table('rol_contrataciones AS A')
            ->leftjoin('rh_personal as B', 'A.ID_PERSONAL', '=', 'B.ID_PERSONAL')
            ->select('A.ID_CONTRATACIONES',
                'A.ID_PROYECTO',
                'A.ID_PERSONAL',
                'A.TIPO_CONTRATO',
                'B.NOMBRES_PERSONAL',
                'B.APELLIDOS_PERSONAL',
                'A.FECHAINICIO_CONTRATACIONES',
                'A.FECHAFIN_CONTRATACIONES',
                'A.ESTADO_CONTRATACIONES')
            ->where('A.ID_PROYECTO', '=', $ID_PROYECTO)
            ->orderBy('A.ID_CONTRATACIONES', 'desc')->paginate(10);
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

    public function verRegistro(Request $request)
    {
        $registro = DB::table('rol_contrataciones AS A')
            ->leftjoin('rh_personal as B', 'A.ID_PERSONAL', '=', 'B.ID_PERSONAL')
            ->select('A.ID_CONTRATACIONES',
                'A.ID_PERSONAL',
                'A.CODE_PLAN',
                'A.TIPO_CONTRATO',
                'A.FECHAINICIO_CONTRATACIONES',
                'A.FECHAFIN_CONTRATACIONES',
                'A.MENSUAL_CONTRATACIONES',
                'A.ESTADO_CONTRATACIONES',
                'A.TOTAL_CONTRATACIONES',
                'A.FUNCIONES_CONTRATACIONES',
                'A.PRODUCTOS_CONTRATACIONES',
                'A.OBSERVACIONES_CONTRATACIONES',
                'A.REAL_OBSERVACIONES',
                'A.DIRECTOR',
                'A.DOCUMENT_PATH',
                'B.NOMBRES_PERSONAL',
                'B.APELLIDOS_PERSONAL')
            ->where([
                ['A.ID_CONTRATACIONES', '=', $request->buscar],
            ])
            ->get();
        return [
            'registro' => $registro,
        ];

    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $registronuevo = new Contrato();
        $registronuevo->ID_PROYECTO = $request->ID_PROYECTO;
        $registronuevo->ID_PERSONAL = $request->ID_PERSONAL;
        $registronuevo->TIPO_CONTRATO = $request->TIPO_CONTRATO;
        $registronuevo->ESTADO_CONTRATACIONES = $request->ESTADO_CONTRATACIONES;
        $registronuevo->FECHAINICIO_CONTRATACIONES = $request->FECHAINICIO_CONTRATACIONES;
        $registronuevo->FECHAFIN_CONTRATACIONES = $request->FECHAFIN_CONTRATACIONES;
        $registronuevo->OBSERVACIONES_CONTRATACIONES = $request->OBSERVACIONES_CONTRATACIONES;
        $registronuevo->TOTAL_CONTRATACIONES = $request->TOTAL_CONTRATACIONES;
        $registronuevo->MENSUAL_CONTRATACIONES = $request->MENSUAL_CONTRATACIONES;
        $registronuevo->save();
        return true;

    }
}

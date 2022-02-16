<?php

namespace App\Http\Controllers;

use App\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProyectoController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $paginate = $request->paginate;

        $proyectos = DB::table('cc_proyectos AS A')
            ->leftjoin('fin_financiador as B', 'A.ID_FINANCIADOR', '=', 'B.ID_FINANCIADOR')
            ->leftjoin('rh_personal as C', 'A.ID_PERSONAL', '=', 'C.ID_PERSONAL')
            ->select('A.ID_PROYECTO',
                'A.ID_PERSONAL',
                'A.ID_FINANCIADOR',
                'A.CODIGO_PROYECTO',
                'A.DESCRIPCION_PROYECTO',
                'A.FECHAINICIO_PROYECTO',
                'A.FECHAFIN_PROYECTO',
                'A.COSTO_PROYECTO',
                'A.ESTADO_PROYECTO',
                'B.NOMBRE_FINANCIADOR',
                'C.NOMBRES_PERSONAL',
                'C.APELLIDOS_PERSONAL');
        if ($buscar != '') {
            $proyectos = $proyectos->whereRaw('(A.CODIGO_PROYECTO LIKE "%' . $buscar . '%"
                OR A.DESCRIPCION_PROYECTO LIKE "%' . $buscar . '%")');
        }
        $proyectos = $proyectos->orderBy('A.ID_PROYECTO', 'desc')->paginate($paginate);
        return [
            'pagination' => [
                'total' => $proyectos->total(),
                'current_page' => $proyectos->currentPage(),
                'per_page' => $proyectos->perPage(),
                'last_page' => $proyectos->lastPage(),
                'from' => $proyectos->firstItem(),
                'to' => $proyectos->lastItem(),
            ],
            'proyectos' => $proyectos,
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $registronuevo = new Proyecto();
        $registronuevo->CODIGO_PROYECTO = $request->CODIGO_PROYECTO;
        $registronuevo->DESCRIPCION_PROYECTO = $request->DESCRIPCION_PROYECTO;
        $registronuevo->TIPO_PROYECTO = $request->TIPO_PROYECTO;
        $registronuevo->TIPOINTERNO_PROYECTO = $request->TIPOINTERNO_PROYECTO;
        $registronuevo->JUSTIFICACION_PROYECTO = $request->JUSTIFICACION_PROYECTO;
        $registronuevo->FECHAINICIO_PROYECTO = $request->FECHAINICIO_PROYECTO;
        $registronuevo->FECHAFIN_PROYECTO = $request->FECHAFIN_PROYECTO;
        $registronuevo->COSTO_PROYECTO = $request->COSTO_PROYECTO;
        $registronuevo->ESTADO_PROYECTO = $request->ESTADO_PROYECTO;
        $registronuevo->AUTORIZAR = $request->AUTORIZAR;
        $registronuevo->ENTIDADAUTORIZA = $request->ENTIDADAUTORIZA;
        $registronuevo->ESTADOAUTORIZA = $request->ESTADOAUTORIZA;
        $registronuevo->ID_PROYECTO = $this->getUltimoIDProyecto();
        $registronuevo->save();
        return true;

    }

    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $actualizar = Proyecto::findOrFail($request->ID_PROYECTO);
        $actualizar->ID_FINANCIADOR = $request->ID_FINANCIADOR;
        $actualizar->ID_EJECUTOR = $request->ID_EJECUTOR;
        $actualizar->ID_PERSONAL = $request->ID_PERSONAL;
        $actualizar->ID_DIRECTOREXT = $request->ID_DIRECTOREXT;
        $actualizar->CODIGO_PROYECTO = $request->CODIGO_PROYECTO;
        $actualizar->DESCRIPCION_PROYECTO = $request->DESCRIPCION_PROYECTO;
        $actualizar->TIPO_PROYECTO = $request->TIPO_PROYECTO;
        $actualizar->TIPOINTERNO_PROYECTO = $request->TIPOINTERNO_PROYECTO;
        $actualizar->JUSTIFICACION_PROYECTO = $request->JUSTIFICACION_PROYECTO;
        $actualizar->FECHAINICIO_PROYECTO = $request->FECHAINICIO_PROYECTO;
        $actualizar->FECHAFIN_PROYECTO = $request->FECHAFIN_PROYECTO;
        $actualizar->COSTO_PROYECTO = $request->COSTO_PROYECTO;
        $actualizar->ESTADO_PROYECTO = $request->ESTADO_PROYECTO;
        $actualizar->AUTORIZAR = $request->AUTORIZAR;
        $actualizar->ENTIDADAUTORIZA = $request->ENTIDADAUTORIZA;
        $actualizar->ESTADOAUTORIZA = $request->ESTADOAUTORIZA;
        $actualizar->TOTALGRAND = $request->TOTALGRAND;
        $actualizar->save();
        return true;

    }

    private function getUltimoIDProyecto()
    {
        $ultimoid = DB::table('cc_proyectos')->max('ID_PROYECTO');
        return $ultimoid + 1;
    }

    public function verRegistro(Request $request)
    {
        $proyecto = DB::table('cc_proyectos AS A')
            ->leftjoin('fin_financiador as B', 'A.ID_FINANCIADOR', '=', 'B.ID_FINANCIADOR')
            ->leftjoin('rh_personal as C', 'A.ID_PERSONAL', '=', 'C.ID_PERSONAL')
            ->leftjoin('fin_financiador as D', 'A.ID_EJECUTOR', '=', 'D.ID_FINANCIADOR')
            ->leftjoin('rh_personal as E', 'A.ID_DIRECTOREXT', '=', 'E.ID_PERSONAL')
            ->select('A.ID_PROYECTO',
                'A.ID_PERSONAL',
                'A.ID_FINANCIADOR',
                'A.ID_EJECUTOR',
                'A.ID_DIRECTOREXT',
                'A.CODIGO_PROYECTO',
                'A.DESCRIPCION_PROYECTO',
                'A.TIPO_PROYECTO',
                'A.TIPOINTERNO_PROYECTO',
                'A.JUSTIFICACION_PROYECTO',
                'A.FECHAINICIO_PROYECTO',
                'A.FECHAFIN_PROYECTO',
                'A.COSTO_PROYECTO',
                'A.ESTADO_PROYECTO',
                'A.AUTORIZAR',
                'A.ENTIDADAUTORIZA',
                'A.ESTADOAUTORIZA',
                'A.TOTALGRAND',
                'B.NOMBRE_FINANCIADOR',
                'C.NOMBRES_PERSONAL',
                'C.APELLIDOS_PERSONAL',
                'D.NOMBRE_FINANCIADOR AS NOMBRE_EJECUTOR',
                'E.NOMBRES_PERSONAL AS NOMBRE_DIRECTOREXT',
                'E.APELLIDOS_PERSONAL AS APELLIDO_DIRECTOREXT')
            ->where([
                ['A.ID_PROYECTO', '=', $request->buscar],
            ])
            ->get();
        return [
            'proyecto' => $proyecto,
        ];

    }

}

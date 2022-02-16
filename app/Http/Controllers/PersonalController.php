<?php

namespace App\Http\Controllers;

use App\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonalController extends Controller
{
    public function selectPersonal(Request $request)
    {
        $filtro = $request->filtro;
        $personales = DB::table('rh_personal AS A')
            ->select('ID_PERSONAL', DB::raw('CONCAT(A.NOMBRES_PERSONAL, " ", A.APELLIDOS_PERSONAL) AS NOMBRE'))
            ->where([
                ['A.NOMBRES_PERSONAL', 'like', '%' . $filtro . '%'],
                ['A.ACTIVO_PERSONAL', 'like', '%' . $filtro . '%'],
            ])
            ->orwhere([
                ['A.APELLIDOS_PERSONAL', 'like', '%' . $filtro . '%'],
            ])
            ->orderBy('NOMBRES_PERSONAL', 'asc')->get();

        return ['personales' => $personales];
    }

    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $registros = DB::table('rh_personal AS A')
            ->select('A.ID_PERSONAL',
                'A.DNI_PERSONAL',
                'A.NOMBRES_PERSONAL',
                'A.APELLIDOS_PERSONAL',
                'A.TELEFONO_PERSONAL',
                'A.CELULAR_PERSONAL',
                'A.EMAIL_PERSONAL',
                'A.ACTIVO_PERSONAL');
        if ($buscar != '') {
            $registros = $registros->whereRaw('(A.DNI_PERSONAL LIKE "%' . $buscar . '%"
                        OR A.NOMBRES_PERSONAL LIKE "%' . $buscar . '%"
                        OR A.APELLIDOS_PERSONAL LIKE "%' . $buscar . '%")');
        }
        $registros = $registros->orderBy('A.APELLIDOS_PERSONAL', 'asc')->paginate(10);
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

        $registronuevo = new Personal();
        $registronuevo->TIPODNI_PERSONAL = $request->TIPODNI_PERSONAL;
        $registronuevo->DNI_PERSONAL = $request->DNI_PERSONAL;
        $registronuevo->NOMBRES_PERSONAL = $request->NOMBRES_PERSONAL;
        $registronuevo->APELLIDOS_PERSONAL = $request->APELLIDOS_PERSONAL;
        $registronuevo->SEXO_PERSONAL = $request->SEXO_PERSONAL;
        $registronuevo->FECNAC_PERSONAL = $request->FECNAC_PERSONAL;
        $registronuevo->TELEFONO_PERSONAL = $request->TELEFONO_PERSONAL;
        $registronuevo->CELULAR_PERSONAL = $request->CELULAR_PERSONAL;
        $registronuevo->EMAIL_PERSONAL = $request->EMAIL_PERSONAL;
        $registronuevo->ACTIVO_PERSONAL = $request->ACTIVO_PERSONAL;
        $registronuevo->save();
        return true;
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $actualizar = Personal::findOrFail($request->id);
        $actualizar->TIPODNI_PERSONAL = $request->TIPODNI_PERSONAL;
        $actualizar->DNI_PERSONAL = $request->DNI_PERSONAL;
        $actualizar->NOMBRES_PERSONAL = $request->NOMBRES_PERSONAL;
        $actualizar->APELLIDOS_PERSONAL = $request->APELLIDOS_PERSONAL;
        $actualizar->SEXO_PERSONAL = $request->SEXO_PERSONAL;
        $actualizar->FECNAC_PERSONAL = $request->FECNAC_PERSONAL;
        $actualizar->TELEFONO_PERSONAL = $request->TELEFONO_PERSONAL;
        $actualizar->CELULAR_PERSONAL = $request->CELULAR_PERSONAL;
        $actualizar->EMAIL_PERSONAL = $request->EMAIL_PERSONAL;
        $actualizar->ACTIVO_PERSONAL = $request->ACTIVO_PERSONAL;
        $actualizar->save();
        return true;
    }
}

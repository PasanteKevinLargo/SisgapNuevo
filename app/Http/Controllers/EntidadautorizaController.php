<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidadautoriza;
use Illuminate\Support\Facades\DB;

class EntidadautorizaController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $IndexDatos = DB::table('adm_entidadautoriza AS A')
            ->select('A.id',
                'A.nombre');
        if ($buscar != '') {
            $IndexDatos = $IndexDatos->where('A.nombre', 'like', '%' . $buscar . '%');
        }
        $IndexDatos = $IndexDatos->orderBy('A.id', 'asc')->paginate(10);
        return [
            'pagination' => [
                'total' => $IndexDatos->total(),
                'current_page' => $IndexDatos->currentPage(),
                'per_page' => $IndexDatos->perPage(),
                'last_page' => $IndexDatos->lastPage(),
                'from' => $IndexDatos->firstItem(),
                'to' => $IndexDatos->lastItem(),
            ],
            'IndexDatos' => $IndexDatos,
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $registronuevo = new Entidadautoriza();
        $registronuevo->nombre = $request->nombre;
        $registronuevo->save();
        return true;

    }

    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $actualizar = Entidadautoriza::findOrFail($request->id);
        $actualizar->nombre = $request->nombre;
        $actualizar->save();
        return true;

    }

    public function select(Request $request)
    {
        $Entidades = DB::table('adm_entidadautoriza AS A')
            ->select('A.id',
                'A.nombre');
        $Entidades = $Entidades->orderBy('A.id', 'asc')->get();
        return ['Entidades' => $Entidades];
    }
}

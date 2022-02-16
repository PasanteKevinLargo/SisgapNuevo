<?php

namespace App\Http\Controllers;

use App\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComentarioController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $registronuevo = new Comentario();
        $registronuevo->idproyecto = $request->idproyecto;
        $registronuevo->idcontrato = $request->idcontrato;
        $registronuevo->comentario = $request->comentario;
        if ($registronuevo->save()) {
            return true;
        }else {
            return false;
        }

    }

    public function index(Request $request)
    {
        $registros = DB::table('cc_comentarios AS A')
            ->select('A.id',
                'A.comentario',
                'A.created_at');
        switch ($request->tipo) {
            case 1:
                $registros = $registros->where([
                    ['A.idproyecto', '=', $request->id],
                ]);
                break;
            case 2:
                $registros = $registros->where([
                    ['A.idcontrato', '=', $request->id],
                ]);
                break;

            default:
                # code...
                break;
        }        
        $registros = $registros->orderBy('A.created_at', 'desc')
            ->get();
        return [
            'registros' => $registros,
        ];

    }

    public function destroy(Request $request)
    {
        $registro = Comentario::findOrFail($request->id);
        $ok = $registro->delete();
        return ['borrado' => $ok];
    }
}

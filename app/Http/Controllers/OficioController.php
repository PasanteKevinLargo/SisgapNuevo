<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OficioController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        //$buscar = $request->buscar;
        
        $oficios = DB::table('doc_oficios AS A')
        ->join('cc_proyectos as B','A.ID_PROYECTO','=','B.ID_PROYECTO')
        ->join('titulodocumento as C','A.ID_TITULODOC','=','C.ID_TITULODOC')
        ->select('A.ID_OFICIOS',
                'A.ID_PROYECTO',
                'A.CODIGO_OFICIO',
                'B.DESCRIPCION_PROYECTO',
                'C.DESCRIPCION_TITULODOC',
                'A.FECHA_OFICIO');
        // if ($buscar<>''){
        //     $contratos=$contratos->where('personas.nombre','like','%'. $buscar . '%');
        // }   
        $oficios=$oficios->orderBy('A.ID_PROYECTO','desc')->paginate(10);
        return [
            'pagination' => [
                'total'        => $oficios->total(),
                'current_page' => $oficios->currentPage(),
                'per_page'     => $oficios->perPage(),
                'last_page'    => $oficios->lastPage(),
                'from'         => $oficios->firstItem(),
                'to'           => $oficios->lastItem(),
            ],
            'oficios' => $oficios
        ];
    }
}

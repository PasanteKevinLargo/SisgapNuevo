<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanCuentaController extends Controller
{
    public function selectPlan(Request $request)
    {
        $filtro = $request->filtro;
        $plan = DB::table('lib_plancuentas AS A')
            ->select('CODE_PLAN', 'ALTERNAT_PLAN', 'TAG_PLAN')
            ->where([
                ['A.TAG_PLAN', 'like', '%' . $filtro . '%'],
                ['A.NIVEL5_PLAN', '>', 0],
            ])
            ->orderBy('CODE_PLAN', 'asc')->get();

        return ['plan' => $plan];
    }
}

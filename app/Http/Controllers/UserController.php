<?php

namespace App\Http\Controllers;

use App\Doc_electronico;
use App\Personal;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $tipo_cliente = $request->tipo_cliente;
        $personas = DB::table('users AS A')
            ->leftjoin('rh_personal as B', 'A.ID_PERSONAL', '=', 'B.ID_PERSONAL')
            ->leftjoin('adm_roles as C', 'A.ID_ROLE', '=', 'C.ID_ROLE')
            ->select('A.id','A.ID_PERSONAL','A.usuario','A.ID_ROLE','B.EMAIL_PERSONAL','B.NOMBRES_PERSONAL',
            'B.APELLIDOS_PERSONAL','C.ROLE')
            ->orderBy('A.id', 'desc');
        if ($buscar != '') {
            $personas = $personas->where('B.APELLIDOS_PERSONAL', 'like', '%' . $buscar . '%')
                ->orwhere('B.NOMBRES_PERSONAL', 'like', '%' . $buscar . '%')
                ->orwhere('A.usuario', 'like', '%' . $buscar . '%');
        }
        if ($tipo_cliente > 0) {
            $personas = $personas->where('A.idrol', '=', $tipo_cliente);
        }
        $personas = $personas->paginate(10);
        return [
            'pagination' => [
                'total' => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page' => $personas->perPage(),
                'last_page' => $personas->lastPage(),
                'from' => $personas->firstItem(),
                'to' => $personas->lastItem(),
            ],
            'personas' => $personas,
        ];
    }
    public function store(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        try {
            DB::beginTransaction();
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->tipo_dni = $request->tipo_dni;
            $persona->direccion = $request->direccion;
            $persona->email = $request->email;
            $persona->save();

            $user = new User();
            $user->usuario = $request->usuario;
            $user->password = bcrypt($request->password);
            $user->idrol = $request->idrol;
            $user->sis_activo = $request->sis_activo;
            $user->id = $persona->id;

            $user->save();

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        try {
            DB::beginTransaction();

            //Buscar primero el proveedor a modificar
            $user = User::findOrFail($request->id);
            $persona = Persona::findOrFail($user->id);

            $persona->nombre = $request->nombre;
            $persona->tipo_dni = $request->tipo_dni;
            $persona->direccion = $request->direccion;
            $persona->email = $request->email;
            $persona->save();

            $user->usuario = $request->usuario;
            //$user->password = bcrypt( $request->password);
            $user->idrol = $request->idrol;
            $user->sis_activo = $request->sis_activo;
            $user->plazo = $request->plazo;
            $user->id = $persona->id;
            $user->save();
            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
        }
    }
    public function getPerfilUsuario(Request $request)
    {
        $nombrePersona = $this->getNombrPersona();
        return [
            'perfil' => \Auth::user()->ID_ROLE,
            'nombreusuario' => $nombrePersona[0]->APELLIDOS_PERSONAL . '' . $nombrePersona[0]->NOMBRES_PERSONAL,
        ];
    }

    public function selectUser(Request $request)
    {
        $filtro = $request->filtro;
        $clientes = Persona::leftjoin('users', 'personas.id', '=', 'users.id')
            ->where([
                ['personas.nombre', 'like', '%' . $filtro . '%'],
                ['users.idrol', '=', 2],
            ])
            ->select('personas.id', 'personas.nombre')
            ->orderBy('personas.nombre', 'asc')
            ->get();

        return ['clientes' => $clientes];
    }

    private function getNombrPersona()
    {
        $personas = Personal::where('ID_PERSONAL', '=', \Auth::user()->ID_PERSONAL)
            ->select('NOMBRES_PERSONAL', 'APELLIDOS_PERSONAL')
            ->get();
        return $personas;
    }

    public function destroy(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        try {
            DB::beginTransaction();

            //Buscar primero el proveedor a modificar
            $user = User::findOrFail($request->id);
            $persona = Persona::findOrFail($user->id);

            $persona->delete();
            $user->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function procesousuarioempresa()
    {
        $doc_electronicos = Doc_electronico::select(
            'id_electronico',
            'nombre_proveedor',
            'ruc_proveedor',
            'nombre_cliente'
        )
            ->where([
                ['id_electronico', '>=', 1],
                ['id_electronico', '<=', 80000],
                ['ambiente_electronico', '=', 1],
            ])
            ->orderBy('id_electronico')->get();

        foreach ($doc_electronicos as $doc) {
            if (!$this->existeusuario($doc->ruc_proveedor)) {
                $myRequest = new Request();
                $myRequest->setMethod('POST');
                $myRequest->request->add(['nombre' => $doc->nombre_proveedor]);
                $myRequest->request->add(['tipo_dni' => 2]);
                $myRequest->request->add(['direccion' => '']);
                $myRequest->request->add(['email' => '']);
                $myRequest->request->add(['usuario' => $doc->ruc_proveedor]);
                $myRequest->request->add(['password' => $doc->ruc_proveedor]);
                $myRequest->request->add(['idrol' => 2]);
                $myRequest->request->add(['sis_activo' => 1]);
                $this->store($myRequest);
            }
        }

        return [
            'doc_electronicos' => 'ok',
            'usuario' => 'aa',
        ];
    }

    public function procesousuarionormal()
    {
        $doc_electronicos = Doc_electronico::select(
            'id_electronico',
            'nombre_proveedor',
            'ruc_proveedor',
            'nombre_cliente',
            'ruc_cliente',
            'ambiente_electronico'
        )
            ->where([
                ['id_electronico', '>=', 40000],
                ['id_electronico', '<=', 41000],
                ['ambiente_electronico', '=', 1],
            ])
            ->orderBy('id_electronico')->get();

        foreach ($doc_electronicos as $doc) {
            $tipo_dni = $this->tipodni($doc->ruc_cliente);
            if (!$this->existeusuario($doc->ruc_cliente)) {
                $myRequest = new Request();
                $myRequest->setMethod('POST');
                $myRequest->request->add(['nombre' => $doc->nombre_cliente]);
                $myRequest->request->add(['tipo_dni' => $tipo_dni]);
                $myRequest->request->add(['direccion' => '']);
                $myRequest->request->add(['email' => '']);
                $myRequest->request->add(['usuario' => $doc->ruc_cliente]);
                $myRequest->request->add(['password' => $doc->ruc_cliente]);
                $myRequest->request->add(['idrol' => 3]);
                $myRequest->request->add(['sis_activo' => 0]);
                $this->store($myRequest);
            }
        }

        return [
            'doc_electronicos' => 'ok',
            'usuario' => 'aa',
        ];
    }

    public function wsclientestatus(Request $request)
    {
        if ($request->key != 'NCgkJPHRpcG9Fb') {
            return 'Error';
        }

        $user = User::select(
            'sis_activo'
        )->where('usuario', '=', $request->RUC_PROVEEDOR)
            ->get();

        if (count($user) == 0) {
            return 'No existe usuario';
        } else {
            if (($user[0]->sis_activo) == 0 || ($user[0]->sis_activo) == 3) {
                return 0;
            } elseif (($user[0]->sis_activo) == 1 || ($user[0]->sis_activo) == 2) {
                return 1;
            }
        }
    }

    public function existeusuario($usuario)
    {
        $user = User::select(
            'id'
        )->where('usuario', '=', $usuario)
            ->get();
        if (count($user) == 0) {
            return 0;
        } else {
            return 1;
        }
    }

    public function wsclienteplazo(Request $request)
    {
        if ($request->key != 'NCgkJPHRpcG9Fb') {
            return 'N/A';
        }

        $user = User::select(
            'sis_activo',
            'plazo'
        )->where('usuario', '=', $request->ruc_proveedor)
            ->get();

        if (count($user) == 0) {
            return 'N/A';
        } else {
            return $user[0]->plazo;
        }
    }

    public function changepass(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->password = bcrypt($request->password);
        $user->save();
        return 1;
    }

    private function tipodni($dni)
    {
        if (strlen($dni) == 10) {
            return 1;
        } elseif (strlen($dni) == 13) {
            return 2;
        } else {
            return 3;
        }
    }

}

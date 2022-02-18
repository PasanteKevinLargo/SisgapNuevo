<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>['guest']],function(){
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});

Route::group(['middleware'=>['auth']],function(){
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/home', function(){
        return view('application');
    })->name('home');


    Route::get('/roles/selectRol', 'RolController@selectRol');
    Route::get('/documentos/procesoXML', 'Doc_electronicoController@procesoXML');
    Route::get('/documentos/downloadXML', 'Doc_electronicoController@downloadXML');

    //Users
    Route::get('/user', 'UserController@index');
    Route::post('/user/registrar', 'UserController@store');
    Route::put('/user/actualizar', 'UserController@update');
    Route::post('/user/destroy', 'UserController@destroy');
    Route::get('/user/selectUser', 'UserController@selectUser');
    Route::put('/user/changepass', 'UserController@changepass');

    //Proyectos
    Route::get('/proyecto', 'ProyectoController@index');
    Route::get('/proyecto/verRegistro', 'ProyectoController@verRegistro');
    Route::post('/proyecto/registrar', 'ProyectoController@store');
    Route::put('/proyecto/actualizar', 'ProyectoController@update');
    Route::post('/proyecto/destroy', 'ProyectoController@destroy');

    //Investigadores
    Route::get('/investigador', 'InvestigadorController@index');
    Route::get('/investigador/verRegistro', 'InvestigadorController@verRegistro');
    Route::post('/investigador/registrar', 'InvestigadorController@store');
    Route::post('/investigador/destroy', 'InvestigadorController@destroy');

    //Adjuntos
    Route::get('/adjunto', 'AdjuntoController@index');
    Route::get('/adjunto/index', 'AdjuntoController@index');
    Route::post('/adjunto/registrar', 'AdjuntoController@store');
    Route::post('/adjunto/destroy', 'AdjuntoController@destroy');

    //Comentarios
    Route::get('/comentario/index', 'ComentarioController@index');
    Route::post('/comentario/registrar', 'ComentarioController@store');
    Route::post('/comentario/destroy', 'ComentarioController@destroy');

    //Presupuestos
    Route::get('/presupuesto', 'PresupuestoController@index');
    Route::get('/presupuesto/index', 'PresupuestoController@index');
    Route::post('/presupuesto/registrar', 'PresupuestoController@store');
    Route::post('/presupuesto/destroy', 'PresupuestoController@destroy');

    //Funciones
    Route::get('/funcion/index', 'FuncionController@index');
    Route::post('/funcion/registrar', 'FuncionController@store');
    Route::post('/funcion/destroy', 'FuncionController@destroy');

    //Productos
    Route::get('/producto/index', 'ProductoController@index');
    Route::post('/producto/registrar', 'ProductoController@store');
    Route::post('/producto/destroy', 'ProductoController@destroy');
      
    //Rol
    Route::get('/rol/selectRol', 'RolController@selectRol');
    Route::get('/user/getPerfilUsuario', 'UserController@getPerfilUsuario');

    //Financiador
    Route::get('/financiador/selectFinanciador', 'FinanciadorController@selectFinanciador');
    Route::get('/financiador/index', 'FinanciadorController@index');
    Route::post('/financiador/registrar', 'FinanciadorController@store');
    Route::put('/financiador/actualizar', 'FinanciadorController@update');
    Route::post('/financiador/destroy', 'FinanciadorController@destroy');

    //Proveedor agregado por el pasante
    Route::get('/proveedor/selectFinanciador', 'ProveedorController@selectFinanciador');
    Route::get('/proveedor/index', 'ProveedorController@index');
    Route::post('/proveedor/registrar', 'ProveedorController@store');
    Route::put('/proveedor/actualizar', 'ProveedorController@update');
    Route::post('/proveedor/destroy', 'ProveedorController@destroy');

    //Personal
    Route::get('/personal/selectPersonal', 'PersonalController@selectPersonal');
    Route::get('/personal/index', 'PersonalController@index');
    Route::post('/personal/registrar', 'PersonalController@store');
    Route::put('/personal/actualizar', 'PersonalController@update');
    Route::post('/personal/destroy', 'PersonalController@destroy');

    //Proveedor
    Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');
    Route::get('/proveedor/index', 'ProveedorController@index');
    Route::post('/proveedor/registrar', 'ProveedorController@store');
    Route::put('/proveedor/actualizar', 'ProveedorController@update');
    Route::post('/proveedor/destroy', 'ProveedorController@destroy');

    //Oficios
    Route::get('/oficio', 'OficioController@index');
    Route::post('/oficio/registrar', 'OficioController@store');
    Route::put('/oficio/actualizar', 'OficioController@update');
    Route::post('/oficio/destroy', 'OficioController@destroy');

    //PDF
    Route::get('/pdfreader', 'PdfController@PdfReader');

    //Tipo Adjuntos
    Route::get('/tipoadjunto', 'TipoadjuntoController@index');
    Route::post('/tipoadjunto/registrar', 'TipoadjuntoController@store');
    Route::put('/tipoadjunto/actualizar', 'TipoadjuntoController@update');
    Route::get('/tipoadjunto/select', 'TipoadjuntoController@select');

    //Entidad que Autoriza
    Route::get('/entidadautoriza', 'EntidadautorizaController@index');
    Route::post('/entidadautoriza/registrar', 'EntidadautorizaController@store');
    Route::put('/entidadautoriza/actualizar', 'EntidadautorizaController@update');
    Route::get('/entidadautoriza/select', 'EntidadautorizaController@select');

    //Contratos
    Route::get('/contrato', 'ContratoController@index');
    Route::post('/contrato/registrar', 'ContratoController@store');
    Route::put('/contrato/actualizar', 'ContratoController@update');
    Route::get('/contrato/select', 'ContratoController@select');
    Route::get('/contrato/verRegistro', 'ContratoController@verRegistro');

    //Compras
    Route::get('/compra/index', 'CompraController@index');
    Route::post('/compra/registrar', 'CompraController@store');
    Route::put('/compra/actualizar', 'CompraController@update');
    Route::get('/compra/verRegistro', 'CompraController@verRegistro');

    //Plan de Cuentas
    Route::get('/plan', 'PlanCuentaController@index');
    Route::post('/plan/registrar', 'PlanCuentaController@store');
    Route::put('/plan/actualizar', 'PlanCuentaController@update');
    Route::get('/plan/selectPlan', 'PlanCuentaController@selectPlan');
});

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('auth.login');
    }
 
    protected function login(Request $request){
     $this->validate($request,[
         'usuario' => 'required|string',
         'password' => 'required|string'
     ]);
 
     if (Auth::attempt(['usuario' => $request->usuario,'password' => $request->password,'condicion'=>1])){
         return redirect()->route('home');
     }
     //return back()->withErrors(['usuario' => trans('auth.failed')]);
     return redirect('/');
     }
 
     public function logout(Request $request){
        Auth::logout();
        return response([
                'status' => 'success',
                'msg' => 'Logged out Successfully.'
            ], 200);
     }
}

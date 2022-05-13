<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\GeneralModel;
use App\Models\Login;

class Login_Controller extends BaseController
{

    public function index(Request $req)
    {
        DB::connection()->getPdo();

        if( !$req->session()->get('nombre') || !$req->session()->get('fk_rol') ){
            return view('login.index', [
                'error' => '',
                'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            ]);
        }else{

            if($req->session()->get('fk_rol')=='CLIENTE'){
                return redirect('/eco_index');
            }
            else{
                return redirect('home');
            }
        }
    }

    public function LoginFeria(Request $req) {  $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        $Datos = Login::ValidateUsuario($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['user'], MD5($data['password']));

        if( count($Datos)<=0 )
        {
            return "ERROR";
        }
        else
        {
            $Cliente = GeneralModel::GetCLientes($DatosGen['NombreEmpresa'][0]->bdbackoffice, $Datos[0]->id);
            if(count($Cliente)==1){
                $req->session()->put('cliente_codigo',$Cliente[0]->codigo);

            }else{
                $req->session()->put('cliente_codigo','0');
            }
            $req->session()->put('id',$Datos[0]->id);
            $req->session()->put('nombre',$Datos[0]->usuario);
            $req->session()->put('fk_rol',$Datos[0]->fk_rol);
            $req->session()->put('rol',$Datos[0]->rol_nombre);
            $req->session()->put('email',$Datos[0]->email);
            $req->session()->put('permisos',Login::GetPermisos($DatosGen['NombreEmpresa'][0]->bdbackoffice, $Datos[0]->fk_rol));

            if($Datos[0]->fk_rol=='6'){
                return "OK";
            }
            else{
                return "ERROR";
            }
        }
    }

    public function userLogin(Request $req) {  $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        $Datos = Login::ValidateUsuario($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['user'], MD5($data['password']));

        if( count($Datos)<=0 )
        {
            return view('login.index', [
                'error' => 'LAS CREDENCIALES INGRESADAS NO SON VALIDAS',
                'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            ]);
        }
        else
        {
            $Cliente = GeneralModel::GetCLientes($DatosGen['NombreEmpresa'][0]->bdbackoffice, $Datos[0]->id);
            if(count($Cliente)==1){
                $req->session()->put('cliente_codigo',$Cliente[0]->codigo);

            }else{
                $req->session()->put('cliente_codigo','0');
            }
            $req->session()->put('id',$Datos[0]->id);
            $req->session()->put('nombre',$Datos[0]->usuario);
            $req->session()->put('fk_rol',$Datos[0]->fk_rol);
            $req->session()->put('rol',$Datos[0]->rol_nombre);
            $req->session()->put('email',$Datos[0]->email);
            $req->session()->put('permisos',Login::GetPermisos($DatosGen['NombreEmpresa'][0]->bdbackoffice, $Datos[0]->fk_rol));

            if($Datos[0]->fk_rol=='CLIENTE'){
                return redirect('/eco_index');
            }
            else{
                return redirect('home');
            }
        }
    }

    public function userLogout(Request $req)
    {
        $req->session()->flush();

        return redirect('/');
    }

    public function LogOutFeria(Request $req)
    {
        $req->session()->flush();

        return "OK";
    }
}

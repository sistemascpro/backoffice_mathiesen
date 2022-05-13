<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\GeneralModel;
use App\Models\Login;
use App\Models\UsuarioPerfil;

class UsuarioPerfil_Controller extends BaseController
{

    public function index(Request $req) { if(!$req->session()->get('nombre') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        return view('usuarioPerfil.index', [
            'NombreEmpresa' => GeneralModel::GetNombreEmpresa('backoffice_mathiesen')
            , 'usuario' =>  UsuarioPerfil::GetUsuario($req->session()->get('id'))
        ]);

    }}

    public function updateContrasenia(Request $req) { if(!$req->session()->get('nombre') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();

        if(!isset($data['contrasenia1'])){

            return "DEBE INGRESAR TODA LA INFORMACIÓN SOLICITADA";

        }
        else if(!isset($data['contrasenia2'])){

            return "DEBE INGRESAR TODA LA INFORMACIÓN SOLICITADA";

        }
        else if(strtolower(trim($data['contrasenia1']))!=strtolower(trim($data['contrasenia2']))) {

            return "LAS CONTRASEÑAS NO COINCIDEN";

        }
        else{

            $DataModel = [
                'contrasenia'     =>  md5(strtolower(trim($data['contrasenia1']))),
            ];

            try {

                UsuarioPerfil::UpdateContrasenia($DataModel, $req->session()->get('id'));
                return "OK";

            } catch (Exception $e) {
                var_dump($e);
                return $e->getMessage();
            }
        }
    }}

    public function updateInformacion(Request $req) { if(!$req->session()->get('nombre') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();

        if(
            !isset($data['rut']) || strlen(trim($data['rut']))==0
            || !isset($data['nombres']) || strlen(trim($data['nombres']))==0
            || !isset($data['apellidos']) || strlen(trim($data['apellidos']))==0
            || !isset($data['telefono1']) || strlen(trim($data['telefono1']))==0
            || !isset($data['email']) || strlen(trim($data['email']))==0
        )
        {
            return "DEBE INGRESAR TODA LA INFORMACIÓN SOLICITADA";
        }
        else{

            $Archivo    = '';
            $rut        = strtoupper(trim($data['rut']));
            $nombres    = strtoupper(trim($data['nombres']));
            $apellidos  = strtoupper(trim($data['apellidos']));
            $telefono1  = strtoupper(trim($data['telefono1']));
            $email      = strtoupper(trim($data['email']));
            if( !isset($data['telefono2']) || strlen(trim($data['telefono2']))==0 ) { $telefono2 = ''; } else { $telefono2  = strtoupper(trim($data['telefono2'])); }

            $DataModel = [
                'rut'           => $rut,
                'nombres'       => $nombres,
                'apellidos'     => $apellidos,
                'telefono1'     => $telefono1,
                'telefono2'     => $telefono2,
                'email'         => $email,
            ];

            if ( UsuarioPerfil::UpdateInformacion($DataModel, $req->session()->get('id')) )
            {
                $req->session()->put('email',$email);
                return json_encode( UsuarioPerfil::GetUsuario($req->session()->get('id')) );
            }
            else
            {
                return "ERROR";
            }
        }
    }}

}

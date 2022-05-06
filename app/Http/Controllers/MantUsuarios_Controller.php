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
use App\Models\MantUsuarios;

class MantUsuarios_Controller extends BaseController
{
    public function Guardar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_usuarios') || session()->get('fk_rol')==3) { $req->session()->flush(); $req->session()->flush();  return redirect('login'); } else {

        function limpiar_texto ($valor) { $valor = str_replace("'","",$valor); $valor = str_replace("\"","",$valor); return trim($valor); }

        $data = $req->input();

        if(
            !isset($data['usuario']) || strlen(trim($data['usuario']))==0
            || !isset($data['fk_rol']) || $data['fk_rol']==0
            || !isset($data['rut']) || strlen(trim($data['rut']))==0
            || !isset($data['nombres']) || strlen(trim($data['nombres']))==0
            || !isset($data['apellidos']) || strlen(trim($data['apellidos']))==0
            || !isset($data['telefono1']) || strlen(trim($data['telefono1']))==0
            || !isset($data['email']) || strlen(trim($data['email']))==0
        ){
            return "FALTA INFORMACION";
        }
        else if ( md5(md5('0'))!=$data['UsuarioId'] && ( strtolower(trim($data['contrasenia1']))!=strtolower(trim($data['contrasenia2'])) ) ){
            return "LAS CONTRASEÑAS NO COINCIDEN";
        }
        else if( md5(md5('0'))==$data['UsuarioId'] && ( !isset($data['contrasenia1']) || strlen(trim($data['contrasenia1']))==0 || !isset($data['contrasenia2']) || strlen(trim($data['contrasenia2']))==0) ) {
            return "DEBE INGRESAR LAS CONTRASEÑAS";
        }
        else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return "EL EMAIL NO ES VÁLIDO";
        }
        else{

            $UsuarioId = $data['UsuarioId'];
            $estado = $data['estado'];
            $usuario = limpiar_texto($data['usuario']);
            $contrasenia =  md5($data['contrasenia1']);
            $fk_rol = $data['fk_rol'];
            $rut = limpiar_texto($data['rut']);
            $nombres = limpiar_texto($data['nombres']);
            $apellidos = limpiar_texto($data['apellidos']);
            $telefono1 = limpiar_texto($data['telefono1']);
            $telefono2 = limpiar_texto($data['telefono2']);
            $email = strtolower(limpiar_texto($data['email']));

            if ( MantUsuarios::ExisteUsuario($usuario, $UsuarioId) ) {
                return "EL USUARIO YA ESTÁ REGISTRADO";
            }
            else if ( MantUsuarios::ExisteEmail($email, $UsuarioId) ) {
                return "EL EMAIL YA ESTÁ REGISTRADO";
            }
            else if ( MantUsuarios::ExisteRut($rut, $UsuarioId) ) {
                return "EL RUT YA ESTÁ REGISTRADO";
            }
            else {

                $nombreFinal = null;
                if($req->file()) {

                    $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\img\usuarios\\".date("YmdHism").".".$req->avatar->extension();
                    $nombreFinal = "img/usuarios/".date("YmdHism").".".$req->avatar->extension();
                    $tempFile = $req->avatar;

                    $Arvhivo = move_uploaded_file($tempFile, $nombreTemp);
                }

                if( md5(md5('0'))==$data['UsuarioId'] ){
                    try {

                        $DataModel = [
                            'estado'        => $estado,
                            'usuario'       => $usuario,
                            'contrasenia'   => $contrasenia,
                            'fk_rol'        => $fk_rol,
                            'rut'           => $rut,
                            'nombres'       => $nombres,
                            'apellidos'     => $apellidos,
                            'telefono1'     => $telefono1,
                            'telefono2'     => $telefono2,
                            'email'         => $email,
                            'avatar'        => $nombreFinal,
                            'fechaCreacion'       => app('App\Http\Controllers\Home_Controller')->GetDateTime(),
                            'fechaActualizacion'    => app('App\Http\Controllers\Home_Controller')->GetDateTime(),
                            'fk_responsable'    => $req->session()->get('id'),
                        ];

                        MantUsuarios::GuardarUsuario($DataModel);
                        return "OK";
                    } catch (Exception $e) {
                        return "ERROR";
                    }
                }
                else {
                    if(!MantUsuarios::ExisteId($UsuarioId)){
                        return "NO EXISTE EL ID A ACTUALIZAR";
                    }
                    else {
                        try {

                            $DataModel = [
                                'estado'        => $estado,
                                'usuario'       => $usuario,
                                'fk_rol'        => $fk_rol,
                                'rut'           => $rut,
                                'nombres'       => $nombres,
                                'apellidos'     => $apellidos,
                                'telefono1'     => $telefono1,
                                'telefono2'     => $telefono2,
                                'email'         => $email,
                                'habiliatdo'         => $email,
                                'fechaCreacion'       => app('App\Http\Controllers\Home_Controller')->GetDateTime(),
                                'fechaActualizacion'    => app('App\Http\Controllers\Home_Controller')->GetDateTime(),
                                'fk_responsable'    => $req->session()->get('id'),
                            ];
                            MantUsuarios::UpdateUsuario($DataModel, $UsuarioId);

                            if ( strlen(trim($data['contrasenia1']))>0 ){
                                $DataModel = [
                                    'contrasenia'   => md5(trim($data['contrasenia1'])),
                                ];
                                MantUsuarios::UpdateUsuario($DataModel, $UsuarioId);
                            }

                            if ( $nombreFinal!=null ){
                                $DataModel = [
                                    'avatar'   => $nombreFinal,
                                ];
                                MantUsuarios::UpdateUsuario($DataModel, $UsuarioId);
                            }

                            return "OK";
                        } catch (Exception $e) {
                            return "ERROR";
                        }
                    }
                }

            }

        }
    }}

    public function crearEditar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_usuarios') || session()->get('fk_rol')==3) { $req->session()->flush(); $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();
        $Usuario = MantUsuarios::GetUsuario($data['id']);
        if( count($Usuario)<=0 ){

            $Usuario[0] = (object)array(
                'usuarioid'=>md5(md5('0'))
                , 'estado'=>true
                , 'rut'=>''
                , 'nombres'=>''
                , 'apellidos'=>''
                , 'telefono1'=>''
                , 'telefono2'=>''
                , 'email'=>''
                , 'contrasenia'=>''
                , 'fk_rol'=>0
                , 'usuario'=>''
                , 'habilitado'=>''
                , 'avatar'=>'img/usuarios/NoneUser.jpg'
            );
        }
        return view('mant_usuarios.crearEditar', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Usuario' => $Usuario
            , 'Roles' =>  MantUsuarios::GetRoles($data['id'])
        ]);

    }}

    public function updateEstado(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_usuarios') || session()->get('fk_rol')==3) { $req->session()->flush(); $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();

        $DataModel = [
            'estado'    =>  $data['estado'],
        ];

        if ( MantUsuarios::updateEstado($DataModel, $data['id']) )
        {
            return "OK";
        }
        else
        {
            return "ERROR";
        }

    }}

    public function index(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_usuarios') || session()->get('fk_rol')==3) { $req->session()->flush(); $req->session()->flush();  return redirect('login'); } else {

        return view('mant_usuarios.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Usuarios_List' =>  MantUsuarios::GetList(),
        ]);

    }}

}

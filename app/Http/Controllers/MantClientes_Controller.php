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
use App\Models\MantClientes;
use Illuminate\Support\Facades\Http;

class MantClientes_Controller extends BaseController
{
    public function GuardarUsuarioExistente(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_clientes') || session()->get('fk_rol')==3) {  $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();

        $Fk_Usuario = MantClientes::GetUsuarioMd5($data['UsuarioId']);

        $DataModel = [
            'fk_cliente'        => $data['ClienteId'],
            'fk_usuario'       => $Fk_Usuario[0]->id,
        ];

        MantClientes::GuardarRelacionUsuario($DataModel);

        return "OK";
    }}

    public function UpdateEstadoUsuario(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_clientes') || session()->get('fk_rol')==3) {  $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();

        $DataModel = [
            'estado'    =>  $data['estado'],
        ];

        try{

            if ( MantClientes::UpdateUsuario($DataModel, $data['id']) )
            {
                return "OK";
            }
            else
            {
                return "ERROR";
            }

        } catch (Exception $e) {
            return "ERROR";
        }
    }}

    public function EditarUsuario(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_clientes') || session()->get('fk_rol')==3) {  $req->session()->flush();  return redirect('login'); } else {

        function limpiar_texto ($valor) { $valor = str_replace("'","",$valor); $valor = str_replace("\"","",$valor); return trim($valor); }

        $data = $req->input();
        return (MantClientes::GetUsuarioMd5($data['id']));

    }}

    public function GuardarUsuario(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_clientes') || session()->get('fk_rol')==3) {  $req->session()->flush();  return redirect('login'); } else {

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
        )
        {
            return "FALTA INFORMACION";
        }
        else if ( '0'!=$data['UsuarioId'] && ( strtolower(trim($data['contrasenia1']))!=strtolower(trim($data['contrasenia2'])) ) )
        {
            return "LAS CONTRASEÑAS NO COINCIDEN";
        }
        else if( '0'==$data['UsuarioId'] && ( !isset($data['contrasenia1']) || strlen(trim($data['contrasenia1']))==0 || !isset($data['contrasenia2']) || strlen(trim($data['contrasenia2']))==0) ) 
        {
            return "DEBE INGRESAR LAS CONTRASEÑAS";
        }
        else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
        {
            return "EL EMAIL NO ES VÁLIDO";
        }
        else
        {
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

            if ( MantClientes::ExisteUsuario($usuario, $UsuarioId) )
            {
                return "EL USUARIO YA ESTÁ REGISTRADO";
            }
            else if ( MantClientes::ExisteRut($rut, $UsuarioId) )
            {
                return "EL RUT YA ESTÁ REGISTRADO";
            }
            else
            {
                $nombreFinal = null;
                if( '0'==$data['UsuarioId'] ){
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
                            'fechacreacion'         => app('App\Http\Controllers\Home_Controller')->GetDateTime(),
                            'fechaactualizacion'    =>  app('App\Http\Controllers\Home_Controller')->GetDateTime(),
                            'fk_responsable'        => $req->session()->get('id'),
                        ];

                        MantClientes::GuardarUsuario($DataModel);

                        $Fk_Usuario = MantClientes::GetUsuarioRut($rut);

                        $DataModel = [
                            'fk_cliente'       => $data['ClienteId'],
                            'fk_usuario'       => $Fk_Usuario[0]->id,
                        ];

                        MantClientes::GuardarRelacionUsuario($DataModel);

                        return "OK";
                    }
                    catch (Exception $e)
                    {
                        return "ERROR";
                    }
                }
                else {
                    if(!MantClientes::ExisteId($UsuarioId))
                    {
                        return "NO EXISTE EL ID A ACTUALIZAR";
                    }
                    else
                    {
                        try
                        {
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
                                'fechaactualizacion'    =>  app('App\Http\Controllers\Home_Controller')->GetDateTime(),
                                'fk_responsable'        => $req->session()->get('id'),
                            ];
                            MantClientes::UpdateUsuario($DataModel, $UsuarioId);

                            if ( strlen(trim($data['contrasenia1']))>0 )
                            {
                                $DataModel = [
                                    'contrasenia'   => md5(trim($data['contrasenia1'])),
                                ];
                                MantClientes::UpdateUsuario($DataModel, $UsuarioId);
                            }

                            return "OK";
                        }
                        catch (Exception $e)
                        {
                            return "ERROR";
                        }
                    }
                }

            }

        }
    }}

    public function crearEditar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_clientes') || session()->get('fk_rol')==3) {  $req->session()->flush();  return redirect('login'); } else { $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);
        $data = $req->input();

        return view('mant_clientes.crearEditar', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Cliente' =>  MantClientes::GetCliente($DatosGen['NombreEmpresa'][0]->bd, $data['id'])
            , 'Rol' =>      MantClientes::GetRolCliente($DatosGen['NombreEmpresa'][0]->bd)
            , 'Usuarios_List' =>  MantClientes::GetUsuariosCliente($data['id'])
            , 'UsuariosNo_List' =>  MantClientes::GetUsuariosNoCliente($data['id'])
            , 'UsuarioId' =>  '0'

        ]);
    }}

    public function index(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_clientes') || session()->get('fk_rol')==3) {  $req->session()->flush();  return redirect('login'); } else { $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        return view('mant_clientes.index', [
            'DatosGen' =>  $DatosGen
            , 'Clientes_List' =>  MantClientes::GetList($DatosGen['NombreEmpresa'][0]->bd),
        ]);
    }}
}

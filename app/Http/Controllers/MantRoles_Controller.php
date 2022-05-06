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
use App\Models\MantRoles;

class MantRoles_Controller extends BaseController
{
    public function Eliminar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_roles') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();
        $Rol = MantRoles::GetUsuariosConRol($data['id']);
        if( count($Rol)>0 ){
            return "NO SE PUEDE ELIMINAR EL ROL, POR QUE TIENE USUARIOS ASOCIADOS";
        }
        else {
            MantRoles::DeletePermisos($data['id']);
            MantRoles::DeleteRol($data['id']);
            return "OK";
        }

    }}

    public function Guardar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_roles') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        function limpiar_texto ($valor) { $valor = str_replace("'","",$valor); $valor = str_replace("\"","",$valor); return trim($valor); }

        $data = $req->input();

        if( !isset($data['nombre']) || strlen(trim($data['nombre']))==0 ){
            return "FALTA INFORMACION";
        }
        else{

            $RolId = $data['RolId'];
            $estado = $data['estado'];
            $nombre = limpiar_texto($data['nombre']);

            if ( MantRoles::ExisteNombre($nombre, $RolId) ) {
                return "EL NOMBRE YA ESTÁ REGISTRADO";
            }
            else {

                if( md5(md5('0'))==$data['RolId'] ){
                    try {

                        $DataModel = [
                            'estado'        => $estado,
                            'nombre'       => $nombre,
                        ];

                        $LastId = MantRoles::GuardarRol($DataModel);
                        MantRoles::DeletePermisos($LastId);
                        MantRoles::DeleteVendedores($LastId);

                        if(isset($data['chkRol'])){
                            for( $i=0; $i<count($data['chkRol']); $i++)
                            {
                                $DataModel = [
                                    'fk_menu'       => $data['chkRol'][$i],
                                    'fk_rol'        => $LastId,
                                ];
                                MantRoles::GuardarPermisos($DataModel);
                            }
                        }

                        if(isset($data['chkVend'])){
                            for( $i=0; $i<count($data['chkVend']); $i++)
                            {
                                $DataModel = [
                                    'fk_vendedor'   => $data['chkVend'][$i],
                                    'fk_rol'        => $LastId,
                                ];
                                MantRoles::GuardarVendedor($DataModel);
                            }
                        }

                        return "OK";
                    } catch (Exception $e) {
                        return "ERROR";
                    }
                }
                else {
                    if(!MantRoles::ExisteId($RolId)){
                        return "NO EXISTE EL ID A ACTUALIZAR";
                    }
                    else if ( MantRoles::ExisteNombre($nombre, $RolId) ) {
                        return "EL NOMBRE YA ESTÁ REGISTRADO";
                    }
                    else {
                        try {

                            $DataModel = [
                                'estado'        => $estado,
                                'nombre'       => $nombre,
                            ];
                            MantRoles::UpdateRol($DataModel, $RolId);

                            MantRoles::DeletePermisosMd5($RolId);
                            MantRoles::DeleteVendedoresMd5($RolId);

                            $LastId = MantRoles::DecryptMd5Rol($RolId);

                            if(isset($data['chkRol'])){
                                for( $i=0; $i<count($data['chkRol']); $i++)
                                {
                                    $DataModel = [
                                        'fk_menu'       => $data['chkRol'][$i],
                                        'fk_rol'        => $LastId[0]->id,
                                    ];
                                    MantRoles::GuardarPermisos($DataModel);
                                }
                            }

                            if(isset($data['chkVend'])){
                                for( $i=0; $i<count($data['chkVend']); $i++)
                                {
                                    $DataModel = [
                                        'fk_vendedor'   => $data['chkVend'][$i],
                                        'fk_rol'        => $LastId[0]->id,
                                    ];
                                    MantRoles::GuardarVendedor($DataModel);
                                }
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

    public function crearEditar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_roles') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();
        $Rol = MantRoles::GetRol($data['id']);
        if( count($Rol)<=0 ){

            $Rol[0] = (object)array(
                'rolid'=>md5(md5('0'))
                , 'estado'=>true
                , 'nombre'=>''
            );
        }
        return view('mant_roles.crearEditar', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Rol' => $Rol
            , 'Permisos' =>  MantRoles::GetPermisos($data['id'])
            , 'Vendedores' =>  MantRoles::GetVendedores($data['id'])
        ]);

    }}

    public function updateEstado(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_roles' || session()->get('fk_rol')==3)) { $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();

        $DataModel = [
            'estado'    =>  $data['estado'],
        ];

        if ( MantRoles::updateEstado($DataModel, $data['id']) )
        {
            return "OK";
        }
        else
        {
            return "ERROR";
        }

    }}

    public function index(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_roles') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        return view('mant_roles.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Roles_List' =>  MantRoles::GetList()
        ]);

    }}

}

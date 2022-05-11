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
use App\Models\MantProdPromosRegalos;

class MantProdPromosRegalos_Controller extends BaseController
{
    public function Eliminar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_prodpromosregalos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();
        $Rol = MantProdPromosRegalos::GetUsuariosConRol($data['id']);
        if( count($Rol)>0 ){
            return "NO SE PUEDE ELIMINAR EL ROL, POR QUE TIENE USUARIOS ASOCIADOS";
        }
        else {
            MantProdPromosRegalos::DeletePermisos($data['id']);
            MantProdPromosRegalos::DeleteRol($data['id']);
            return "OK";
        }

    }}

    public function Guardar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_prodpromosregalos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        function limpiar_texto ($valor) { $valor = str_replace("'","",$valor); $valor = str_replace("\"","",$valor); return trim($valor); }

        $data = $req->input();

        if( 
            !isset($data['prod1']) || strlen(trim($data['prod1']))==0 
            || !isset($data['desc1']) || strlen(trim($data['desc1']))==0 
            || !isset($data['cant1']) || strlen(trim($data['cant1']))==0 || $data['cant1']==0
            || !isset($data['prod2']) || strlen(trim($data['prod2']))==0 
            || !isset($data['desc2']) || strlen(trim($data['desc2']))==0 
            || !isset($data['cant2']) || strlen(trim($data['cant2']))==0 || $data['cant2']==0
            || !isset($data['precio2']) || strlen(trim($data['precio2']))==0 || $data['precio2']==0
        ){
            return "FALTA INFORMACION";
        }
        else if( date($data['fecha2']) < date($data['fecha1']) ){
            return "ERROR EN EL RANGO DE FECHAS";
        }        
        else{

            $Fecha1 = substr($data['fecha1'],8,2)."-".substr($data['fecha1'],5,2)."-".substr($data['fecha1'],0,4);
            $Fecha2 = substr($data['fecha2'],8,2)."-".substr($data['fecha2'],5,2)."-".substr($data['fecha2'],0,4);

            if ( MantProdPromosRegalos::ExistePromo($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['prod1'], $data['cant1'], $Fecha1, $Fecha2, $data['promoid']) ) {
                return "EL PRODUCTO YA TIENE UNA PROMO INGRESADA 1";
            }
            else {

                if( '0'==$data['promoid'] ){
                    try {

                        $DataModel = [
                            'prod1'     => $data['prod1'],
                            'cant1'     => $data['cant1'],
                            'prod2'     => $data['prod2'],
                            'cant2'     => $data['cant2'],
                            'precio2'   => $data['precio2'],
                            'fecha1'    => $Fecha1,
                            'fecha2'    => $Fecha2,
                        ];
                        MantProdPromosRegalos::Guardar($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                        return "OK";

                    } catch (Exception $e) {
                        return "ERROR";
                    }
                }
                else {

                    if ( MantProdPromosRegalos::ExistePromo($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['prod1'], $data['cant1'], $Fecha1, $Fecha2, $data['promoid']) ) {
                        return "EL PRODUCTO YA TIENE UNA PROMO INGRESADA 2";
                    }
                    else {
                        try {

                            $DataModel = [
                                'prod1'     => $data['prod1'],
                                'cant1'     => $data['cant1'],
                                'prod2'     => $data['prod2'],
                                'cant2'     => $data['cant2'],
                                'precio2'   => $data['precio2'],
                                'fecha1'    => $Fecha1,
                                'fecha2'    => $Fecha2,
                            ];
                            MantProdPromosRegalos::UpdatePromo($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $data['promoid']);
                            return "OK";

                        } catch (Exception $e) {
                            return "ERROR";
                        }
                    }
                }
            }
        }
    }}

    public function CargarProducto(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_prodpromosregalos') || session()->get('fk_rol')==3) {  $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);
        $data = $req->input();
        return (MantProdPromosRegalos::CargarProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['Codigo']));
    }}

    public function crearEditar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_prodpromosregalos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        $Detalle = MantProdPromosRegalos::GetDetalle($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['id']);
        if( count($Detalle)<=0 ){

            $Detalle[0] = (object)array(
                'promoid'=>'0'
                , 'prod1'=>''
                , 'desc1'=>''
                , 'cant1'=>0
                , 'prod2'=>''
                , 'desc2'=>''
                , 'cant2'=>0
                , 'precio2'=>0
                , 'fecha1'=>app('App\Http\Controllers\Home_Controller')->GetDate()
                , 'fecha2'=>app('App\Http\Controllers\Home_Controller')->GetDate()
            );
        }
        return view('mant_prodpromosregalos.crearEditar', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Detalle' => $Detalle
        ]);

    }}

    public function index(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_prodpromosregalos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        return view('mant_prodpromosregalos.index', [
            'DatosGen' => $DatosGen
            , 'Lista' =>  MantProdPromosRegalos::GetList($DatosGen['NombreEmpresa'][0]->bdbackoffice)
        ]);

    }}

}

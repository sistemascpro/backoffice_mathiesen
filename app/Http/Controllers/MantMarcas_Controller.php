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
use App\Models\MantMarcas;

class MantMarcas_Controller extends BaseController
{
    public function Guardar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_marcas') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        function limpiar_texto ($valor) { $valor = str_replace("'","",$valor); $valor = str_replace("\"","",$valor); return trim($valor); }

        $data = $req->input();

        if(
            !isset($data['nombre']) || strlen(trim($data['nombre']))==0
            ){
            return "FALTA INFORMACION";
        }
        else{

            $nombre = limpiar_texto($data['nombre']);
            $estado = $data['estado'];

            if( count(MantMarcas::ExisteNombre($DatosGen['NombreEmpresa'][0]->bd, $nombre, $data['id']))>0 )
            {
                return "EL NOMBRE YA ESTA EN USO";
            }
            else if( $data['posicion']!=0 && count(MantMarcas::ExistePosicion($DatosGen['NombreEmpresa'][0]->bd, $data['posicion'], $data['id']))>0 )
            {
                return "LA POSICION YA ESTA ASIGNADA";
            }
            else
            {

                $nombreFinal    = null;
                $nombreFinal2   = null;

                if( empty($req->archivo)!='1' )
                {
                    $TempName       = date("YmdHisu");
                    $nombreTemp     = $_SERVER['DOCUMENT_ROOT']."\img\marcas\\".$TempName.".".$req->archivo->extension();
                    $nombreFinal    = "img/marcas/".$TempName.".".$req->archivo->extension();
                    $tempFile       = $req->archivo;
                    $Archivo        = move_uploaded_file($tempFile, $nombreTemp);
                }

                if( empty($req->cabecera)!='1' )
                {
                    $TempName       = date("YmdHisu");
                    $nombreTemp     = $_SERVER['DOCUMENT_ROOT']."\img\marcas\\".$TempName.".".$req->cabecera->extension();
                    $nombreFinal2   = "img/marcas/".$TempName.".".$req->cabecera->extension();
                    $tempFile       = $req->cabecera;
                    $Archivo        = move_uploaded_file($tempFile, $nombreTemp);
                }

                if( $data['id']==0)
                {
                    $DataModel = [
                        'nombre'    => $data['nombre'],
                        'posicion'    => $data['posicion'],
                        'ruta'      => $nombreFinal,
                        'estado'      => $estado,
                    ];
                    return MantMarcas::GuardarMarca($DataModel);
                }
                else
                {
                    if($nombreFinal!=null && $nombreFinal2!=null)
                    {
                        $DataModel = [
                            'nombre'        => $data['nombre'],
                            'posicion'      => $data['posicion'],
                            'ruta'          => $nombreFinal,
                            'cabecera'      => $nombreFinal2,
                            'estado'        => $estado,
                        ];
                    }
                    else if($nombreFinal!=null && $nombreFinal2==null)
                    {
                        $DataModel = [
                            'nombre'        => $data['nombre'],
                            'posicion'      => $data['posicion'],
                            'ruta'          => $nombreFinal,
                            'estado'        => $estado,
                        ];
                    }
                    else if($nombreFinal==null && $nombreFinal2!=null)
                    {
                        $DataModel = [
                            'nombre'        => $data['nombre'],
                            'posicion'      => $data['posicion'],
                            'cabecera'      => $nombreFinal2,
                            'estado'        => $estado,
                        ];
                    }

                    MantMarcas::UpdateMarca($DataModel, $data['id']);
                    return "OK";
                }

            }
        }
    }}

    public function UpdateEstado(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_marcas') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();

        $DataModel = [
            'estado'    =>  $data['estado'],
        ];

        if ( MantMarcas::updateEstado($DataModel, $data['id']) )
        {
            return "OK";
        }
        else
        {
            return "ERROR";
        }

    }}

    public function CrearEditar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_marcas') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        $Detalle = MantMarcas::GetDetalle($DatosGen['NombreEmpresa'][0]->bd, $data['id']);
        if( count($Detalle)<=0 ){

            $Detalle[0] = (object)array(
                'id'=>0
                , 'estado'=>1
                , 'nombre'=>''
                , 'ruta'=>''
                , 'cabecera'=>''
                , 'posicion'=>0
            );
        }
        return view('mant_marcas.crearEditar', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Detalle' => $Detalle
        ]);

    }}

    public function index(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_marcas') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        return view('mant_marcas.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Lista' =>  MantMarcas::GetList($DatosGen['NombreEmpresa'][0]->bd)
        ]);

    }}
}

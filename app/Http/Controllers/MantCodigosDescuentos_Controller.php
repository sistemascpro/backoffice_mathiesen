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
use App\Models\MantCodigosDescuentos;

class MantCodigosDescuentos_Controller extends BaseController
{
    public function EliminarCliente(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_codigosdescuentos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();
        
        MantCodigosDescuentos::EliminarCliente($data['Id']);
        return "OK";

    }}
    
    public function AgregarCliente(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_codigosdescuentos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        function limpiar_texto ($valor) { $valor = str_replace("'","",$valor); $valor = str_replace("\"","",$valor); return trim($valor); }

        $data = $req->input();

        if( 
            !isset($data['codigo']) || strlen(trim($data['codigo']))==0 
            || !isset($data['Id']) || strlen(trim($data['Id']))==0 || $data['Id']=='0'
        ){
            return "FALTA INFORMACION";
        }
        else{

            if ( MantCodigosDescuentos::ExisteCliente($data['codigo'], $data['Id']) ) {
                return "EL CLIENTE YA ESTA ASOCIADO";
            }
            else {
                try {

                    $DataModel = [
                        'fk_codigo'     => $data['Id'],
                        'fk_cliente'    => $data['codigo'],
                        'usado'         => 'NO',
                    ];
                    return MantCodigosDescuentos::GuardarCliente($DataModel);

                } catch (Exception $e) {
                    return "ERROR";
                }
            }
        }
    }}

    public function BuscarClientes(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_codigosdescuentos') || session()->get('fk_rol')==3) {  $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);
        $data = $req->input();
        return (MantCodigosDescuentos::BuscarClientes($DatosGen['NombreEmpresa'][0]->bd, $data['codigo']));
    }}

    public function CargarDetalle(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_codigosdescuentos') || session()->get('fk_rol')==3) {  $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);
        $data = $req->input();
        return (MantCodigosDescuentos::CargarDetalle($DatosGen['NombreEmpresa'][0]->bd, $data['Id']));
    }}

    public function Guardar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_codigosdescuentos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        function limpiar_texto ($valor) { $valor = str_replace("'","",$valor); $valor = str_replace("\"","",$valor); return trim($valor); }

        $data = $req->input();

        if( 
            !isset($data['codigo']) || strlen(trim($data['codigo']))==0 
            || !isset($data['descripcion']) || strlen(trim($data['descripcion']))==0 
            || !isset($data['valor']) || strlen(trim($data['valor']))==0 
        ){
            return "FALTA INFORMACION";
        }
        else if( date($data['fecha2']) < date($data['fecha1']) ){
            return "ERROR EN EL RANGO DE FECHAS";
        }        
        else{

            $Fecha1 = substr($data['fecha1'],8,2)."-".substr($data['fecha1'],5,2)."-".substr($data['fecha1'],0,4);
            $Fecha2 = substr($data['fecha2'],8,2)."-".substr($data['fecha2'],5,2)."-".substr($data['fecha2'],0,4);

            if ( MantCodigosDescuentos::ExisteCodigo($data['codigo'], $data['id']) ) {
                return "EL CODIGO YA ESTA EN USO";
            }
            else {

                if(0==$data['id']){
                    try {

                        $DataModel = [
                            'codigo'        => $data['codigo'],
                            'descripcion'   => $data['descripcion'],
                            'valor'         => $data['valor'],
                            'fecha1'        => $Fecha1,
                            'fecha2'        => $Fecha2,
                        ];
                        return MantCodigosDescuentos::Guardar($DataModel);

                    } catch (Exception $e) {
                        return "ERROR";
                    }
                }
                else {

                    try {

                        $DataModel = [
                            'codigo'        => $data['codigo'],
                            'descripcion'   => $data['descripcion'],
                            'valor'         => $data['valor'],
                            'fecha1'        => $Fecha1,
                            'fecha2'        => $Fecha2,
                        ];
                        MantCodigosDescuentos::UpdateCodigo($DataModel, $data['id']);
                        return $data['id'];

                    } catch (Exception $e) {
                        return "ERROR";
                    }
                }
            }
        }
    }}

    public function crearEditar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_codigosdescuentos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        $Detalle = MantCodigosDescuentos::GetDetalle($data['id']);
        if( count($Detalle)<=0 ){

            $Detalle[0] = (object)array(
                'id'=>0
                , 'codigo'=>''
                , 'descripcion'=>''
                , 'valor'=>0
                , 'fecha1'=>app('App\Http\Controllers\Home_Controller')->GetDate()
                , 'fecha2'=>app('App\Http\Controllers\Home_Controller')->GetDate()
            );
        }
        return view('mant_codigosdescuentos.crearEditar', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Detalle' => $Detalle
        ]);

    }}

    public function index(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_codigosdescuentos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        return view('mant_codigosdescuentos.index', [
            'DatosGen' => $DatosGen
            , 'Lista' =>  MantCodigosDescuentos::GetList()
        ]);

    }}

}

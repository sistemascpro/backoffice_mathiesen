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
use App\Models\MantBanners;

class MantBanners_Controller extends BaseController
{
    public function EliminarBanner(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_banners') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        try {
            
            MantBanners::EliminarProductos($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['id']);
            MantBanners::EliminarBanners($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['id']);
            return "OK";
            
        } catch (Exception $e) {
            return "NO SE PUEDE ELIMINAR, TIENE INFORMACIÓN RELACIONADA";
        }
    }}

    public function EliminarProducto(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_banners') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);
        
        $data = $req->input();
        try {
            
            MantBanners::EliminarProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['id']);
            return "OK";
            
        } catch (Exception $e) {
            return "NO SE PUEDE ELIMINAR, TIENE INFORMACIÓN RELACIONADA";
        }
    }}

    public function CargarDetalleBanner(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_banners') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        try {
            
            return (MantBanners::CargarProductosBanners($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['Id']));
            
        } catch (Exception $e) {
            return "NO SE PUEDE ELIMINAR, TIENE INFORMACIÓN RELACIONADA";
        }
    }}

    public function AgregarProducto(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_banners') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);
        
        $data = $req->input();
        try {
            
            if( !MantBanners::ExisteProductoBanner($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['CodProd'], $data['Id']) ){
                
                $DataModel = [
                    'banner'    => $data['Id'],
                    'CodProd'   => $data['CodProd'],
                ];
                MantBanners::AgregarProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                return "OK";
            
            }else{

                return "EL PRODUCTO YA ESTA AGREGADO";

            }

        } catch (Exception $e) {
            return "NO SE PUEDE ELIMINAR, TIENE INFORMACIÓN RELACIONADA";
        }
    }}

    public function Eliminar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_banners') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);
        
        $data = $req->input();
        try {
            MantBanners::DeleteProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['id']);
            return "OK";
        } catch (Exception $e) {
            return "NO SE PUEDE ELIMINAR, TIENE INFORMACIÓN RELACIONADA";
        }
    }}

    public function Guardar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_banners') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        function limpiar_texto ($valor) { $valor = str_replace("'","",$valor); $valor = str_replace("\"","",$valor); return trim($valor); }

        $data = $req->input();

        if(
            !isset($data['nombre']) || strlen(trim($data['nombre']))==0
            || !isset($data['posicion']) || $data['posicion']==0
            ){
            return "FALTA INFORMACION";
        }
        else{

            $nombre = limpiar_texto($data['nombre']);
            $posicion = $data['posicion'];

            if( !MantBanners::ExistePosicion($DatosGen['NombreEmpresa'][0]->bdbackoffice, $posicion, $data['id']) ){

                $nombreFinal = null;
                if($req->file()) {

                    $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\img\banners\\".date("YmdHism").".".$req->archivo->extension();
                    $nombreFinal = "img/banners/".date("YmdHism").".".$req->archivo->extension();
                    $tempFile = $req->archivo;
                    $Archivo = move_uploaded_file($tempFile, $nombreTemp);
                }

                if( $data['id']==0 && $nombreFinal!=null){
                    $DataModel = [
                        'nombre'    => $data['nombre'],
                        'ruta'      => $nombreFinal,
                        'posicion'  => $data['posicion'],
                    ];
                    return MantBanners::GuardarBanner($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                }else if( $data['id']==0 && $nombreFinal==null){
                    return "LA IMAGEN PARA EL BANNER ES OBLIGATORIA";
                }else{
                    if($nombreFinal!=null){
                        $DataModel = [
                            'nombre'    => $data['nombre'],
                            'ruta'      => $nombreFinal,
                            'posicion'  => $data['posicion'],
                        ];
                    }else{
                        $DataModel = [
                            'nombre'    => $data['nombre'],
                            'posicion'  => $data['posicion'],
                        ];
                    }
                    MantBanners::UpdateBanner($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $data['id']);
                    return $data['id'];
                }

            }else{
                return "LA POSICION YA ESTA UTILIZADA";
            }
            
        }
    }}

    public function updateEstado(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_banners') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();

        $DataModel = [
            'estado'    =>  $data['estado'],
        ];

        if ( MantBanners::updateEstado($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $data['id']) )
        {
            return "OK";
        }
        else
        {
            return "ERROR";
        }

    }}

    public function crearEditar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_banners') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        $Detalle = MantBanners::GetDetalle($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['id']);
        if( count($Detalle)<=0 ){

            $Detalle[0] = (object)array(
                'id'=>0
                , 'nombre'=>''
                , 'posicion'=>0
                , 'ruta'=>''
            );
        }
        return view('mant_banners.crearEditar', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Detalle' => $Detalle
        ]);

    }}

    public function index(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_banners') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        return view('mant_banners.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Lista' =>  MantBanners::GetList($DatosGen['NombreEmpresa'][0]->bdbackoffice)
        ]);

    }}
}

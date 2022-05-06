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
use App\Models\MantProductosSinCanje;

class MantProductosSinCanje_Controller extends BaseController
{
    public function Eliminar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_prodsincanje') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $data = $req->input();
        try {
            MantProductosSinCanje::Eliminar($data['id']);
            return "OK";
        } catch (Exception $e) {
            return "NO SE PUEDE ELIMINAR, TIENE INFORMACIÓN RELACIONADA";
        }
    }}

    public function Agregar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_prodsincanje') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        function limpiar_texto ($valor) { $valor = str_replace("'","",$valor); $valor = str_replace("\"","",$valor); return trim($valor); }

        $data = $req->input();

        if(
            !isset($data['CodProd']) || strlen(trim($data['CodProd']))==0
            ){
            return "FALTA INFORMACION";
        }
        else{

            $CodProd = $data['CodProd'];

            if( !MantProductosSinCanje::ExisteAgregado($data['CodProd']) ){

                if( !MantProductosSinCanje::ExisteProducto($DatosGen['NombreEmpresa'][0]->bd, $data['CodProd']) ){
                    return "NO EXISTE EL PRODUCTO";
                }else{
                    $DataModel = [
                        'CodProd'   => $CodProd,
                    ];
                    MantProductosSinCanje::Guardar($DataModel);
                    return "OK";
                }
                
            }else{
                return "EL PRODUCTO YA ESTABA INGRESADO";
            }
            
        }
    }}

    public function index(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_prodsincanje') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        return view('mant_prodsincanje.index', [
            'DatosGen' => $DatosGen
            , 'Lista' =>  MantProductosSinCanje::GetList($DatosGen['NombreEmpresa'][0]->bd)
        ]);

    }}
}

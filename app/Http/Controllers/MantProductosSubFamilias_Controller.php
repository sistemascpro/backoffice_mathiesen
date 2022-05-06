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
use App\Models\MantProductosSubFamilias;
use Illuminate\Support\Facades\Http;

class MantProductosSubFamilias_Controller extends BaseController
{
    public function Eliminar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productossubfamilias') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();
        /* LALO */
        $Rol = MantProductosSubFamilias::GetInformacionRelacionada($data['id']);
        if( count($Rol)>0 ){
            return "NO SE PUEDE ELIMINAR, TIENE INFORMACIÓN RELACIONADA";
        }
        else {
            MantProductosSubFamilias::DeleteFamilia($data['id']);
            return "OK";
        }

    }}

    public function Guardar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productossubfamilias') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        function limpiar_texto ($valor) { $valor = str_replace("'","",$valor); $valor = str_replace("\"","",$valor); return trim($valor); }

        $data = $req->input();

        if( !isset($data['nombre']) || strlen(trim($data['codigo']))==0 || $data['fk_familia']==0 ){
            return "FALTA INFORMACION";
        }
        else{

            $subfamiliaid = $data['subfamiliaid'];
            $estado = $data['estado'];
            $nombre = limpiar_texto($data['nombre']);
            $codigo = limpiar_texto($data['codigo']);
            $fk_familia = $data['fk_familia'];

            if ( MantProductosSubFamilias::ExisteNombre($nombre, $subfamiliaid) ) {
                return "EL NOMBRE YA ESTÁ REGISTRADO";
            }
            else if ( MantProductosSubFamilias::ExisteCodigo($codigo, $subfamiliaid) ) {
                return "EL CÓDIGO YA ESTÁ REGISTRADO";
            }
            else {

                if( 0==$subfamiliaid ){
                    try {
                        $DataModel = [
                            'estado'        => $estado,
                            'codigo'       => $codigo,
                            'nombre'       => $nombre,
                            'fk_familia'       => $fk_familia,
                        ];
                        $LastId = MantProductosSubFamilias::GuardarSubFamilia($DataModel);
                        return "OK";
                    } catch (Exception $e) {
                        return "ERROR";
                    }
                }
                else {
                    if(!MantProductosSubFamilias::ExisteId($subfamiliaid)){
                        return "NO EXISTE EL ID A ACTUALIZAR";
                    }
                    else if ( MantProductosSubFamilias::ExisteNombre($nombre, $subfamiliaid) ) {
                        return "EL NOMBRE YA ESTÁ REGISTRADO";
                    }
                    else if ( MantProductosSubFamilias::ExisteCodigo($codigo, $subfamiliaid) ) {
                        return "EL CÓDIGO YA ESTÁ REGISTRADO";
                    }
                    else {
                        try {

                            $DataModel = [
                                'estado'        => $estado,
                                'codigo'        => $codigo,
                                'nombre'       => $nombre,
                                'fk_familia'       => $fk_familia,
                            ];
                            MantProductosSubFamilias::UpdateSubFamilia($DataModel, $subfamiliaid);

                            return "OK";
                        } catch (Exception $e) {
                            return "ERROR";
                        }
                    }
                }
            }
        }
    }}

    public function crearEditar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productossubfamilias') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();
        $SubFamilia = MantProductosSubFamilias::GetSubFamilia($data['id']);
        if( count($SubFamilia)<=0 ){

            $SubFamilia[0] = (object)array(
                'id'=>0
                , 'codigo'=>''
                , 'nombre'=>''
                , 'fk_familia'=>0
                , 'estado'=>1
                , 'familiaid'=>0
                , 'familianombre'=>''
            );
        }
        return view('mant_productossubfamilias.crearEditar', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'SubFamilia' => $SubFamilia
            , 'Familias' =>  MantProductosSubFamilias::GetFamilias($data['id'])
        ]);

    }}

    public function updateEstado(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productossubfamilias') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();

        $DataModel = [
            'estado'    =>  $data['estado'],
        ];

        if ( MantProductosSubFamilias::updateEstado($DataModel, $data['id']) )
        {
            return "OK";
        }
        else
        {
            return "ERROR";
        }

    }}

    public function index(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productossubfamilias') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        $Familias_List = MantProductosSubFamilias::GetList();

        return view('mant_productossubfamilias.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'SubFamilias_List' =>  $Familias_List
        ]);

    }}

}

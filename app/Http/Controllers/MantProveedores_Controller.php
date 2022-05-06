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
use App\Models\MantProveedores;

class MantProveedores_Controller extends BaseController
{
    public function Guardar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_proveedores') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();

        if(
            !isset($data['nombre']) || strlen(trim($data['nombre']))==0 
            || !isset($data['codigo']) || strlen(trim($data['codigo']))==0 
            ){
            return "FALTA INFORMACION";
        }
        else{

            $nombre = app('App\Http\Controllers\Home_Controller')->LimpiarTexto($data['nombre']);
            $codigo = app('App\Http\Controllers\Home_Controller')->LimpiarTexto($data['codigo']);
            $estado = $data['estado'];

            if( MantProveedores::ExisteNombre($DatosGen['NombreEmpresa'][0]->bdbackoffice, $nombre, $data['id']) ){
                return "EL NOMBRE YA ESTA EN USO";
            }else if( MantProveedores::ExisteCodigo($DatosGen['NombreEmpresa'][0]->bdbackoffice, $codigo, $data['id']) ){
                return "EL CODIGO YA ESTA EN USO";
            }else{
                if( $data['id']==0){
                    $DataModel = [
                        'nombre'    => $nombre,
                        'codigo'    => $codigo,
                        'estado'    => $estado,
                    ];
                    MantProveedores::Guardar($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                }else{
                    $DataModel = [
                        'nombre'    => $nombre,
                        'codigo'    => $codigo,
                        'estado'    => $estado,
                    ];
                    MantProveedores::MakeUpdate($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $data['id']);
                }
                return "OK";
            }
            
        }
    }}

    public function UpdateEstado(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_proveedores') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();

        $DataModel = [
            'estado'    =>  $data['estado'],
        ];

        if ( MantProveedores::MakeUpdate($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $data['id']) )
        {
            return "OK";
        }
        else
        {
            return "ERROR";
        }

    }}

    public function CrearEditar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_proveedores') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        $Detalle = MantProveedores::GetDetalle($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['id']);
        if( count($Detalle)<=0 ){

            $Detalle[0] = (object)array(
                'id'=>0
                , 'estado'=>1
                , 'codigo'=>''
                , 'nombre'=>''
            );
        }
        return view('mant_proveedores.crearEditar', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Detalle' => $Detalle
            , 'ModuloTitulo1' => 'MANTENEDOR DE PROVEEDORES'
            , 'ModuloTitulo2' => 'CREAR/EDITAR PROVEEDORES'
            , 'ModuloRuta' => 'mant_proveedores'
            , 'ModuloRequired' => 'ProveedoresRequired'
        ]);

    }}

    public function index(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_proveedores') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        return view('mant_proveedores.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Lista' =>  MantProveedores::GetList($DatosGen['NombreEmpresa'][0]->bdbackoffice)
            , 'ModuloTitulo1' => 'MANTENEDOR DE PROVEEDORES'
            , 'ModuloTitulo2' => 'CREAR/EDITAR PROVEEDORES'
            , 'ModuloRuta' => 'mant_proveedores'
            , 'ModuloRequired' => 'ProveedoresRequired'
        ]);

    }}
}

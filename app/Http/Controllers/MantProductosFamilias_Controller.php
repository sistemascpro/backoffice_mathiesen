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
use App\Models\MantProductosFamilias;
use Illuminate\Support\Facades\Http;

class MantProductosFamilias_Controller extends BaseController
{
    public function EliminarArchivo2(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productosfamilias') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $data = $req->input();
        if (file_exists($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/", "\\", $data['ruta'])))
        {
            unlink($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/", "\\", $data['ruta']));
        }
        $DataModel = [
            'ruta2'  => null,
        ];
        MantProductosFamilias::UpdateFamilia($DataModel, $data['id']);
        return "OK";
    }}

    public function EliminarArchivo1(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productosfamilias') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $data = $req->input();
        if (file_exists($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/", "\\", $data['ruta'])))
        {
            unlink($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/", "\\", $data['ruta']));
        }
        $DataModel = [
            'ruta'  => null,
        ];
        MantProductosFamilias::UpdateFamilia($DataModel, $data['id']);
        return "OK";
    }}

    public function EliminarCaracteristica(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productosfamilias') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();

        /* $Rol = MantProductosFamilias::GetCaracteristicasInformacionRelacionada($data['id']); */

        MantProductosFamilias::DeleteCaracteristica($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['id']);
        return "OK";
    }}

    public function CargarCaracteristicasFamilias(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        return json_encode(MantProductosFamilias::CargarCaracteristicasFamilias($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['id']));

    }}

    public function GuardarCaracteristica(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productosfamilias') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();

        $Tipo = MantProductosFamilias::GetTipoCaracteristica($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['IdSelectCaracteristica']);
        if(count($Tipo)<=0)
        {
            return "NO SE DETECTO EL TIPO DE CARACTERISTICA";
        }
        else if( !isset($data['codigo']) || strlen(trim($data['codigo']))==0 || !isset($data['nombre']) || strlen(trim($data['nombre']))==0 )
        {
            return "FALTA INFORMACION";
        }
        else
        {

            $Tipo = $Tipo[0]->tipo;
            $familiaid = $data['familiaid'];
            $estado = $data['estado'];
            $codigo = app('App\Http\Controllers\Home_Controller')->LimpiarTexto($data['codigo']);
            $descripcion = app('App\Http\Controllers\Home_Controller')->LimpiarTexto($data['descripcion']);
            $nombre = app('App\Http\Controllers\Home_Controller')->LimpiarTexto($data['nombre']);
            $fk_caracteristica = $data['IdSelectCaracteristica'];

            if ( MantProductosFamilias::ExisteNombre($nombre, $familiaid) )
            {
                return "EL NOMBRE YA ESTÁ REGISTRADO";
            }
            else if ( MantProductosFamilias::ExisteCodigo($codigo, $familiaid) )
            {
                return "EL CÓDIGO YA ESTÁ REGISTRADO";
            }
            else
            {

                if('0'==$familiaid )
                {
                    $DataModel = [
                        'estado'        => $estado,
                        'codigo'        => $codigo,
                        'descripcion'   => $descripcion,
                        'nombre'        => $nombre,
                        'es_filtro'     => $data['EsFiltro'],
                    ];
                    $familiaid = MantProductosFamilias::GuardarFamilia($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                }

                if( $Tipo==1)
                {
                    $DataModel = [
                        'fk_caracteristica' => $fk_caracteristica,
                        'valor'             => app('App\Http\Controllers\Home_Controller')->LimpiarTexto($data['solonumero']),
                        'estado'            => 1,
                        'fk_familia'        => $familiaid,
                        'es_filtro'         => $data['EsFiltro'],
                    ];
                    MantProductosFamilias::GuardarFamiliaCaracteristica($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                }
                else if( $Tipo==2)
                {
                    $DataModel = [
                        'fk_caracteristica' => $fk_caracteristica,
                        'valor'             => app('App\Http\Controllers\Home_Controller')->LimpiarTexto($data['areadetexto']),
                        'estado'            => 1,
                        'fk_familia'        => $familiaid,
                        'es_filtro'         => $data['EsFiltro'],
                    ];
                    MantProductosFamilias::GuardarFamiliaCaracteristica($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                }
                else if( $Tipo==3)
                {
                    $DataModel = [
                        'fk_caracteristica' => $fk_caracteristica,
                        'valor'             => app('App\Http\Controllers\Home_Controller')->LimpiarTexto($data['campodetexto']),
                        'estado'            => 1,
                        'fk_familia'        => $familiaid,
                        'es_filtro'         => $data['EsFiltro'],
                    ];
                    MantProductosFamilias::GuardarFamiliaCaracteristica($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                }
                else if( $Tipo==4 || $Tipo==5)
                {
                    $DataModel = [
                        'fk_caracteristica' => $fk_caracteristica,
                        'valor'             => '',
                        'estado'            => 1,
                        'fk_familia'        => $familiaid,
                        'es_filtro'         => $data['EsFiltro'],
                    ];
                    MantProductosFamilias::GuardarFamiliaCaracteristica($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                }

                return $familiaid;
            }
        }

    }}

    public function CargarFormaCaracteristica(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        return json_encode(MantProductosFamilias::CargarFormaCaracteristica($DatosGen['NombreEmpresa'][0]->bd, $data['id']));

    }}

    public function Eliminar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productosfamilias') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();
        /* LALO */
        $Rol = MantProductosFamilias::GetInformacionRelacionada($data['id']);
        if( count($Rol)>0 ){
            return "NO SE PUEDE ELIMINAR, TIENE INFORMACIÓN RELACIONADA";
        }
        else {
            MantProductosFamilias::DeleteFamilia($data['id']);
            return "OK";
        }

    }}

    public function Guardar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productosfamilias') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        function limpiar_texto ($valor) { $valor = str_replace("'","",$valor); $valor = str_replace("\"","",$valor); return trim($valor); }

        $data = $req->input();

        if( !isset($data['nombre']) || strlen(trim($data['codigo']))==0 ){
            return "FALTA INFORMACION";
        }
        else{

            $familiaid = $data['familiaid'];
            $estado = $data['estado'];
            $nombre = limpiar_texto($data['nombre']);
            $codigo = limpiar_texto($data['codigo']);
            $descripcion = limpiar_texto($data['descripcion']);

            if ( MantProductosFamilias::ExisteNombre($nombre, $familiaid) ) {
                return "EL NOMBRE YA ESTÁ REGISTRADO";
            }
            else if ( MantProductosFamilias::ExisteCodigo($codigo, $familiaid) ) {
                return "EL CÓDIGO YA ESTÁ REGISTRADO";
            }
            else {

                $nombreFinalIcono = null;
                $nombreFinalCabecera = null;
                if($req->file()) {

                    if(isset($req->archivo))
                    {
                        $Random = date("YmdHism").substr(md5(mt_rand()), 0, 7);
                        $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\img\\familias\\".$Random.".".$req->archivo->extension();
                        $nombreFinalIcono = "img/familias/".$Random.".".$req->archivo->extension();
                        $tempFile = $req->archivo;
                        $Archivo = move_uploaded_file($tempFile, $nombreTemp);
                    }

                    if(isset($req->cabecera))
                    {
                        $Random = date("YmdHism").substr(md5(mt_rand()), 0, 9);
                        $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\img\\familias\\".$Random.".".$req->cabecera->extension();
                        $nombreFinalCabecera = "img/familias/".$Random.".".$req->cabecera->extension();
                        $tempFile = $req->cabecera;
                        $Archivo = move_uploaded_file($tempFile, $nombreTemp);
                    }


                }

                if('0'==$data['familiaid'] ){
                    try {
                        $DataModel = [
                            'estado'       => $estado,
                            'codigo'       => $codigo,
                            'descripcion'        => $descripcion,
                            'nombre'       => $nombre,
                            'ruta'         => $nombreFinalIcono,
                            'ruta2'         => $nombreFinalCabecera,
                        ];
                        MantProductosFamilias::GuardarFamilia($DataModel);
                        return "OK";
                    } catch (Exception $e) {
                        return "ERROR";
                    }
                }
                else {
                    if(!MantProductosFamilias::ExisteId($familiaid)){
                        return "NO EXISTE EL ID A ACTUALIZAR";
                    }
                    else if ( MantProductosFamilias::ExisteNombre($nombre, $familiaid) ) {
                        return "EL NOMBRE YA ESTÁ REGISTRADO";
                    }
                    else if ( MantProductosFamilias::ExisteCodigo($codigo, $familiaid) ) {
                        return "EL CÓDIGO YA ESTÁ REGISTRADO";
                    }
                    else {
                        try {

                            $DataModel = [
                                'estado'        => $estado,
                                'codigo'        => $codigo,
                                'descripcion'        => $descripcion,
                                'nombre'        => $nombre,
                            ];
                            MantProductosFamilias::UpdateFamilia($DataModel, $familiaid);


                            if($nombreFinalIcono!=null)
                            {
                                $DataModel = [
                                    'ruta'          => $nombreFinalIcono,
                                ];
                                MantProductosFamilias::UpdateFamilia($DataModel, $familiaid);
                            }

                            if($nombreFinalCabecera!=null)
                            {
                                $DataModel = [
                                    'ruta2'          => $nombreFinalCabecera,
                                ];
                                MantProductosFamilias::UpdateFamilia($DataModel, $familiaid);
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

    public function UpdateEstado(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productosfamilias') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();
        $DataModel = [
            'estado'    =>  $data['estado'],
        ];
        if ( MantProductosFamilias::UpdateEstado($DataModel, $data['id']) )
        {
            return "OK";
        }
        else
        {
            return "ERROR";
        }

    }}

    public function crearEditar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productosfamilias') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        $Familia = MantProductosFamilias::GetFamilia($data['id']);
        if( count($Familia)<=0 ){

            $Familia[0] = (object)array(
                'id'=>0
                , 'estado'=>true
                , 'codigo'=>''
                , 'descripcion'=>''
                , 'nombre'=>''
                , 'ruta'=>null
                , 'ruta2'=>null
            );
        }
        return view('mant_productosfamilias.crearEditar', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Familia' => $Familia
            , 'Caracteristicas' => MantProductosFamilias::GetCaracteristicas($DatosGen['NombreEmpresa'][0]->bdbackoffice)
            , 'ModuloTitulo1' => 'MANTENEDOR DE FAMILIAS'
            , 'ModuloTitulo2' => 'CREAR/EDITAR FAMILIAS'
            , 'ModuloRuta' => 'mant_productosfamilias'
            , 'ModuloRequired' => 'FamiliaRequired'
        ]);
    }}

    public function index(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productosfamilias') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $Familias_List = MantProductosFamilias::GetList($DatosGen['NombreEmpresa'][0]->bdbackoffice);

        return view('mant_productosfamilias.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Lista' =>  $Familias_List
            , 'ModuloTitulo1' => 'MANTENEDOR DE FAMILIAS'
            , 'ModuloTitulo2' => 'FAMILIAS'
            , 'ModuloRuta' => 'mant_productosfamilias'
            , 'ModuloRequired' => 'FamiliaRequired'
        ]);

    }}

}

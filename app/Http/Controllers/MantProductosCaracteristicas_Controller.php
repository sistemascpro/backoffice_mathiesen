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
use App\Models\MantProductosCaracteristicas;
use Illuminate\Support\Facades\Http;

class MantProductosCaracteristicas_Controller extends BaseController
{
    public function EliminarOpcion(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productoscaracteristicas') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);
        $data = $req->input();
        try {
            MantProductosCaracteristicas::EliminarOpcion($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['id']);
            return "OK";
        } catch (Exception $e) {
            return "ERROR";
        }
    }}

    public function GetOpciones(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productoscaracteristicas') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        return json_encode(MantProductosCaracteristicas::GetOpciones($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['id']));

    }}
    
    public function Guardar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productoscaracteristicas') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        $nombre = app('App\Http\Controllers\Home_Controller')->LimpiarTexto($data['nombre']);
        $id             = $data['id'];


        if ( MantProductosCaracteristicas::ExisteNombre($DatosGen['NombreEmpresa'][0]->bdbackoffice, $nombre, $id) ) 
        {
            return "EL NOMBRE YA ESTÁ REGISTRADO";
        }
        else if( !isset($data['tipo']) || strlen(trim($data['tipo']))==0 || !isset($data['libre']) || strlen(trim($data['libre']))==0 || !isset($data['tipo']) || strlen(trim($data['tipo']))==0 )
        {
            return "FALTA INFORMACION";
        } 
        else if( $data['tipo']==1 && $data['libre']=='NO' && ( !isset($data['solonumero']) || strlen($data['solonumero'])<=0 ) )
        {
            return "FALTA INGRESAR EL VALOR DEL NUMERO";
        }
        else if( $data['tipo']==2 && $data['libre']=='NO' && ( !isset($data['areadetexto']) || strlen($data['areadetexto'])<=0 ) )
        {
            return "DEBE INGRESAR UN VALOR EN EL CAMPO AREA DE TEXTO";
        }
        else if( $data['tipo']==3 && $data['libre']=='NO' && ( !isset($data['campodetexto']) || strlen($data['campodetexto'])<=0 ) )
        {
            return "DEBE INGRESAR UN VALOR EN EL CAMPO DE TEXTO";
        }
        else if( ( $data['tipo']==4 || $data['tipo']==5 ) && !isset($data['ContenidoOpcion']) )
        {
            return "DEBE INGRESAR MINIMO UNA OPCION";
        }
        else
        {
            $estado         = $data['estado'];
            $obligatorio    = $data['obligatorio'];
            $libre          = $data['libre'];
            $tipo           = $data['tipo'];

            if( $tipo==1 )
            {
                $DataModel = [
                    'estado'            => $estado,
                    'nombre'            => $nombre,
                    'obligatorio'       => $obligatorio,
                    'libre'             => $libre,
                    'tipo'              => $tipo,
                    'valor'             => app('App\Http\Controllers\Home_Controller')->LimpiarTexto($data['solonumero']),
                ];
            }
            else if( $tipo==2 )
            {
                $DataModel = [
                    'estado'            => $estado,
                    'nombre'            => $nombre,
                    'obligatorio'       => $obligatorio,
                    'libre'             => $libre,
                    'tipo'              => $tipo,
                    'valor'             => app('App\Http\Controllers\Home_Controller')->LimpiarTexto($data['areadetexto']),
                ];               
            }
            else if( $tipo==3 )
            {
                $DataModel = [
                    'estado'            => $estado,
                    'nombre'            => $nombre,
                    'obligatorio'       => $obligatorio,
                    'libre'             => $libre,
                    'tipo'              => $tipo,
                    'valor'             => app('App\Http\Controllers\Home_Controller')->LimpiarTexto($data['campodetexto']),
                ];               
            }            
            else if( $tipo==5 )
            {
                $DataModel = [
                    'estado'            => $estado,
                    'nombre'            => $nombre,
                    'obligatorio'       => $obligatorio,
                    'libre'             => $libre,
                    'tipo'              => $tipo,
                    'valor'             => '',
                ];               
            }    

            if($id==0)
            {
                $id = MantProductosCaracteristicas::Guardar($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
            }
            else
            {
                MantProductosCaracteristicas::Actualizar($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $id);
            }

            if( $tipo==5 )
            {
                $ContenidoOpcion = $data['ContenidoOpcion'];

                for($i=0; $i<count($ContenidoOpcion); $i++)
                {
                    $DataModel = [
                        'estado'            => 1,
                        'opcion'            => app('App\Http\Controllers\Home_Controller')->LimpiarTexto($ContenidoOpcion[$i]),
                        'fk_caracteristica' => $id,
                    ];    
                    MantProductosCaracteristicas::GuardarOpcion($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                }
            }

            return "OK";
        }
    }}

    public function UpdateEstado(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productoscaracteristicas') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        $DataModel = [
            'estado'    =>  $data['estado'],
        ];
        if ( MantProductosCaracteristicas::Actualizar($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $data['id']) )
        {
            return "OK";
        }
        else
        {
            return "ERROR";
        }

    }}

    public function crearEditar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productoscaracteristicas') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        $Caracteristica = MantProductosCaracteristicas::GetDetalle($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['id']);
        if( count($Caracteristica)<=0 ){
            $Caracteristica[0] = (object)array(
                'id'=>0
                , 'nombre'=>''
                , 'estado'=>true
                , 'tipo'=>0
                , 'obligatorio'=>''
                , 'libre'=>''
                , 'valor'=>''
            );
        }
        return view('mant_productoscaracteristicas.crearEditar', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Caracteristica' => $Caracteristica
            , 'Tipos' => MantProductosCaracteristicas::GetCaracteristicasTipos($DatosGen['NombreEmpresa'][0]->bdbackoffice)
            , 'ModuloTitulo1' => 'MANTENEDOR DE PRODUCTOS CARACTERISTICAS'
            , 'ModuloTitulo2' => 'CREAR/EDITAR PRODUCTOS CARACTERISTICAS'
            , 'ModuloRuta' => 'mant_productoscaracteristicas'
            , 'ModuloRequired' => 'CaracteristicasRequired'              
        ]);

    }}    
    public function index(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productoscaracteristicas') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $Lista = MantProductosCaracteristicas::GetList($DatosGen['NombreEmpresa'][0]->bdbackoffice);

        return view('mant_productoscaracteristicas.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Lista' =>  $Lista
            , 'ModuloTitulo1' => 'MANTENEDOR DE PRODUCTOS CARACTERISTICAS'
            , 'ModuloTitulo2' => 'PRODUCTOS CARACTERISTICAS'
            , 'ModuloRuta' => 'mant_productoscaracteristicas'
            , 'ModuloRequired' => 'CaracteristicasRequired'            
        ]);

    }}

}

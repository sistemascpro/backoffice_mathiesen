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
use App\Models\MantNoticias;

class MantNoticias_Controller extends BaseController
{
    public function Eliminar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_noticias') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $data = $req->input();
        try
        {
            $Noticia = MantNoticias::GetNoticia($data['id']);

            if($Noticia[0]->imagen!=null && file_exists($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->imagen) )) {
                unlink( $_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->imagen) );
            }

            MantNoticias::Eliminar($data['id']);
            return "OK";

        }
        catch (Exception $e)
        {
            return "NO SE PUEDE ELIMINAR, TIENE INFORMACIÓN RELACIONADA";
        }
    }}

    public function Guardar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_noticias') || session()->get('fk_rol')==3) { $req->session()->flush(); $req->session()->flush();  return redirect('login'); } else {

        function limpiar_texto ($valor) { $valor = str_replace("'","",$valor); $valor = str_replace("\"","",$valor); return trim($valor); }

        $data = $req->input();

        if(
            !isset($data['ImagenTitulo']) || strlen(trim($data['ImagenTitulo']))==0
            || !isset($data['ImagenContenido']) || strlen(trim($data['ImagenContenido']))==0
            || !isset($req->ImagenImagen)
            || !isset($data['ImagenPosicion']) || strlen(trim($data['ImagenPosicion']))==0
        )
        {
            return "FALTA INFORMACION";
        }
        else
        {
            $NoticiaId = $data['NoticiaId'];
            $Titulo     = limpiar_texto($data['ImagenTitulo']);
            $Contenido  = limpiar_texto($data['ImagenContenido']);
            $Posicion   = limpiar_texto($data['ImagenPosicion']);

            if ( $Posicion!=0 && MantNoticias::ExistePosicion($Posicion, $NoticiaId) )
            {
                return "LA POSICION YA ESTA EN USO";
            }
            else
            {
                $Noticia = MantNoticias::GetNoticia($data['NoticiaId']);
                if(count($Noticia)>0)
                {
                    if($Noticia[0]->imagen!=null && file_exists($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->imagen) ))
                    {
                        unlink( $_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->imagen) );
                    }

                    MantNoticias::Eliminar($Noticia[0]->id);
                }

                $nombreImagen = null;
                if($req->file()) 
                {
                    $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\img\\noticias\\".date("YmdHism").".".$req->ImagenImagen->extension();
                    $nombreImagen = "img/noticias/".date("YmdHism").".".$req->ImagenImagen->extension();
                    $tempFile = $req->ImagenImagen;
                    move_uploaded_file($tempFile, $nombreTemp);
                }

                try {

                    $DataModel = [
                        'titulo'        => $Titulo,
                        'contenido'     => $Contenido,
                        'imagen'        => $nombreImagen,
                        'posicion'      => $Posicion,
                    ];

                    MantNoticias::GuardarNoticia($DataModel);
                    return "OK";
                }
                catch (Exception $e)
                {
                    return "ERROR";
                }
            }

        }
    }}

    public function crearEditar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_noticias') || session()->get('fk_rol')==3) { $req->session()->flush(); $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();
        $Noticia = MantNoticias::GetNoticia($data['id']);
        if( count($Noticia)<=0 ){

            $Noticia[0] = (object)array(
                'id'=>'0'
                , 'titulo'=>''
                , 'contenido'=>''
                , 'imagen'=>''
                , 'posicion'=>''
            );
        }
        return view('mant_noticias.crearEditar', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Noticia' => $Noticia
        ]);

    }}

    public function index(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_noticias') || session()->get('fk_rol')==3) { $req->session()->flush(); $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        return view('mant_noticias.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Lista' =>  MantNoticias::GetList($DatosGen['NombreEmpresa'][0]->bdbackoffice),
        ]);

    }}

}

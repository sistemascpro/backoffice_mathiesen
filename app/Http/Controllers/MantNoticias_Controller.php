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
        try {
            $Noticia = MantNoticias::GetNoticia($data['id']);
            
            if($Noticia[0]->imagen!=null && file_exists($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->imagen) )) { 
                unlink( $_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->imagen) );
            }

            if($Noticia[0]->cover!=null && file_exists($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->cover) )) { 
                unlink( $_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->cover) ); 
            }

            if($Noticia[0]->video!=null && file_exists($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->video) )) { 
                unlink( $_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->video) ); 
            }            

            MantNoticias::Eliminar($data['id']);
            return "OK";
            
        } catch (Exception $e) {
            return "NO SE PUEDE ELIMINAR, TIENE INFORMACIÓN RELACIONADA";
        }
    }}

    public function Guardar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_noticias') || session()->get('fk_rol')==3) { $req->session()->flush(); $req->session()->flush();  return redirect('login'); } else {

        function limpiar_texto ($valor) { $valor = str_replace("'","",$valor); $valor = str_replace("\"","",$valor); return trim($valor); }

        $data = $req->input();

        if(
            (
                $data['Tipo']=='Imagen' && (
                    !isset($data['ImagenTitulo']) || strlen(trim($data['ImagenTitulo']))==0
                    || !isset($data['ImagenContenido']) || strlen(trim($data['ImagenContenido']))==0
                    || !isset($req->ImagenImagen)
                    || !isset($data['ImagenPosicion']) || strlen(trim($data['ImagenPosicion']))==0
                )
            ) ||
            (
                $data['Tipo']=='Video' && (
                    !isset($data['VideoTitulo']) || strlen(trim($data['VideoTitulo']))==0
                    || !isset($data['VideoContenido']) || strlen(trim($data['VideoContenido']))==0
                    || !isset($req->VideoCover)
                    || !isset($req->VideoVideo)
                    || !isset($data['VideoPosicion']) || strlen(trim($data['VideoPosicion']))==0
                )
            )
        ){
            return "FALTA INFORMACION";
        }
        else{

            $NoticiaId = $data['NoticiaId'];
            
            if($data['Tipo']=='Imagen'){
                $Titulo     = limpiar_texto($data['ImagenTitulo']);
                $Contenido  = limpiar_texto($data['ImagenContenido']);
                $Posicion   = limpiar_texto($data['ImagenPosicion']);
            }else{
                $Titulo     = limpiar_texto($data['VideoTitulo']);
                $Contenido  = limpiar_texto($data['VideoContenido']);                
                $Posicion   = limpiar_texto($data['VideoPosicion']);                
            }
            

            if ( $Posicion!=0 && MantNoticias::ExistePosicion($Posicion, $NoticiaId) ) {
                return "LA POSICION YA ESTA EN USO";
            
            } else {

                $Noticia = MantNoticias::GetNoticiaMd5($data['NoticiaId']);
            
                if(count($Noticia)>0){
                    if($Noticia[0]->imagen!=null && file_exists($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->imagen) )) { 
                        unlink( $_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->imagen) );
                    }

                    if($Noticia[0]->cover!=null && file_exists($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->cover) )) { 
                        unlink( $_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->cover) ); 
                    }

                    if($Noticia[0]->video!=null && file_exists($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->video) )) { 
                        unlink( $_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->video) ); 
                    }            

                    MantNoticias::Eliminar($Noticia[0]->id);
                }
                if($data['Tipo']=='Imagen'){
                    
                    $nombreImagen = null;
                    if($req->file()) {
    
                        $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\img\\noticias\\".date("YmdHism").".".$req->ImagenImagen->extension();
                        $nombreImagen = "img/noticias/".date("YmdHism").".".$req->ImagenImagen->extension();
                        $tempFile = $req->ImagenImagen;
                        move_uploaded_file($tempFile, $nombreTemp);

                        $coverVideo = null;
                        $videoVideo = null;
                    }

                }else{
                    
                    $coverVideo = null;
                    $videoVideo = null;
                    if($req->file()) {
    
                        $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\img\\noticias\\".date("YmdHism").".".$req->VideoCover->extension();
                        $coverVideo = "img/noticias/".date("YmdHism").".".$req->VideoCover->extension();
                        $tempFile = $req->VideoCover;
                        move_uploaded_file($tempFile, $nombreTemp);

                        $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\img\\noticias\\".date("YmdHism").".".$req->VideoVideo->extension();
                        $videoVideo = "img/noticias/".date("YmdHism").".".$req->VideoVideo->extension();
                        $tempFile = $req->VideoVideo;
                        move_uploaded_file($tempFile, $nombreTemp);

                        $nombreImagen = null;
                    }

                }

                /*
                if( md5(md5('0'))==$data['NoticiaId'] ){
                */
                    try {

                        $DataModel = [
                            'titulo'        => $Titulo,
                            'contenido'     => $Contenido,
                            'imagen'        => $nombreImagen,
                            'cover'         => $coverVideo,
                            'video'         => $videoVideo,
                            'tipo'          => $data['Tipo'],
                            'posicion'      => $Posicion,
                        ];

                        MantNoticias::GuardarNoticia($DataModel);
                        return "OK";
                    } catch (Exception $e) {
                        return "ERROR";
                    }
                /*
                }
                /*
                else 
                {

                    if(!MantNoticias::ExisteId($data['NoticiaId'])){
                        return "NO EXISTE EL ID A ACTUALIZAR";
                    }
                    else {
                        try {

                            $Noticia = MantNoticias::GetNoticiaMd5($data['NoticiaId']);
            
                            if($Noticia[0]->imagen!=null && file_exists($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->imagen) )) { 
                                unlink( $_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->imagen) );
                            }
                
                            if($Noticia[0]->cover!=null && file_exists($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->cover) )) { 
                                unlink( $_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->cover) ); 
                            }
                
                            if($Noticia[0]->video!=null && file_exists($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->video) )) { 
                                unlink( $_SERVER['DOCUMENT_ROOT']."\\".str_replace("/","\\",$Noticia[0]->video) ); 
                            }       

                            $NoticiaId = $data['NoticiaId'];
            
                            if($data['Tipo']=='Imagen'){
                                $Titulo     = limpiar_texto($data['ImagenTitulo']);
                                $Contenido  = limpiar_texto($data['ImagenContenido']);
                                $Posicion   = limpiar_texto($data['ImagenPosicion']);
                            }else{
                                $Titulo     = limpiar_texto($data['VideoTitulo']);
                                $Contenido  = limpiar_texto($data['VideoContenido']);                
                                $Posicion   = limpiar_texto($data['VideoPosicion']);                
                            }

                            $DataModel = [
                                'titulo'        => $Titulo,
                                'contenido'     => $Contenido,
                                'tipo'          => $data['Tipo'],
                                'posicion'      => $Posicion,
                            ];

                            MantNoticias::UpdateNoticia($DataModel, $NoticiaId);         

                            if($data['Tipo']=='Imagen'){
                    
                                if(isset($req->ImagenImagen)) {
                                    
                                    $tempFile = null;
                                    $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\img\\noticias\\".date("YmdHism").".".$req->ImagenImagen->extension();
                                    $nombreImagen = "img/noticias/".date("YmdHism").".".$req->ImagenImagen->extension();
                                    $tempFile = $req->ImagenImagen;
                                    move_uploaded_file($tempFile, $nombreTemp);

                                    $DataModel = [
                                        'imagen'    => $nombreImagen,
                                    ];
                                    MantNoticias::UpdateNoticia($DataModel, $NoticiaId);
            
                                }
            
                            }else{
                                
                                if(isset($req->VideoCover)) {
                                    
                                    $tempFile = null;
                                    $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\img\\noticias\\".date("YmdHism").".".$req->VideoCover->extension();
                                    $coverVideo = "img/noticias/".date("YmdHism").".".$req->VideoCover->extension();
                                    $tempFile = $req->VideoCover;
                                    move_uploaded_file($tempFile, $nombreTemp);
            
                                    $DataModel = [
                                        'cover'    => $coverVideo,
                                    ];
                                    MantNoticias::UpdateNoticia($DataModel, $NoticiaId);
                                }

                                if(isset($req->VideoVideo)) {
                                    $tempFile = null;
                                    $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\img\\noticias\\".date("YmdHism").".".$req->VideoVideo->extension();
                                    $videoVideo = "img/noticias/".date("YmdHism").".".$req->VideoVideo->extension();
                                    $tempFile = $req->VideoVideo;
                                    move_uploaded_file($tempFile, $nombreTemp);
                                    
                                    $DataModel = [
                                        'video'    => $videoVideo,
                                    ];
                                    MantNoticias::UpdateNoticia($DataModel, $NoticiaId);
                                }
            
                            }

                            return "OK";
                        } catch (Exception $e) {
                            return "ERROR";
                        }
                    }
                }
                */
            }

        }
    }}

    public function crearEditar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_noticias') || session()->get('fk_rol')==3) { $req->session()->flush(); $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();
        $Noticia = MantNoticias::GetNoticia($data['id']);
        if( count($Noticia)<=0 ){

            $Noticia[0] = (object)array(
                'noticiaid'=>md5(md5('0'))
                , 'ImagenTitulo'=>''
                , 'ImagenContenido'=>''
                , 'ImagenContenido'=>''
                , 'ImagenImagen'=>''
                , 'VideoTitulo'=>''
                , 'VideoContenido'=>''
                , 'VideoCover'=>''
                , 'VideoVideo'=>''
                , 'ImagenPosicion'=>''
                , 'VideoPosicion'=>''
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

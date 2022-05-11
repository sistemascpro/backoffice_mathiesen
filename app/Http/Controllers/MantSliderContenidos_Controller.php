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
use App\Models\MantSliderContenidos;

class MantSliderContenidos_Controller extends BaseController
{
    public function Eliminar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_slidercontenidos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $data = $req->input();
        try {
            $Slider = MantSliderContenidos::GetSlider($data['id']);
            if ($Slider[0]->imagen!='' && $Slider[0]->imagen!=null && file_exists($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/", "\\", $Slider[0]->imagen)))
            {
                unlink($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/", "\\", $Slider[0]->imagen) );
            }

            MantSliderContenidos::Eliminar($data['id']);
            return "OK";
            
        } catch (Exception $e) {
            return "NO SE PUEDE ELIMINAR, TIENE INFORMACIÓN RELACIONADA";
        }
    }}

    public function Guardar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_slidercontenidos') || session()->get('fk_rol')==3) { $req->session()->flush(); $req->session()->flush();  return redirect('login'); } else {

        function limpiar_texto ($valor) { $valor = str_replace("'","",$valor); $valor = str_replace("\"","",$valor); return trim($valor); }

        $data = $req->input();

        if(
            !isset($data['texto']) || strlen(trim($data['texto']))==0
            || !isset($req->imagen)
        )
        {
            return "FALTA INFORMACION";
        }
        else
        {

            $id         = $data['id'];
            $texto      = limpiar_texto($data['texto']);

            $nombreImagen = null;

            if($req->file())
            {
                $FileRandom = date("YmdHisu");
                $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\img\\sliderscontenidos\\".$FileRandom.".".$req->imagen->extension();
                $nombreImagen = "img/sliderscontenidos/".$FileRandom.".".$req->imagen->extension();
                $tempFile = $req->imagen;
                move_uploaded_file($tempFile, $nombreTemp);
            }

            try
            {
                if($id==0)
                {
                    $DataModel = [
                        'texto'     => $texto,
                        'imagen'    => $nombreImagen,
                    ];
                    MantSliderContenidos::Guardar($DataModel);
                }
                else
                {
                    $Slider = MantSliderContenidos::GetSlider($data['id']);
                    if ($Slider[0]->imagen!='' && $Slider[0]->imagen!=null && file_exists($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/", "\\", $Slider[0]->imagen)))
                    {
                        unlink($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/", "\\", $Slider[0]->imagen) );
                    }
                    $DataModel = [
                        'texto'     => $texto,
                        'imagen'    => $nombreImagen,
                    ];
                    MantSliderContenidos::UpdateSlider($DataModel, $id);
                }

                
                return "OK";
            }
            catch (Exception $e)
            {
                return "ERROR";
            }

        }
    }}

    public function crearEditar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_slidercontenidos') || session()->get('fk_rol')==3) { $req->session()->flush(); $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();
        $SliderContenidos = MantSliderContenidos::GetSlider($data['id']);
        if( count($SliderContenidos)<=0 )
        {
            $SliderContenidos[0] = (object)array(
                'id'=>'0'
                , 'texto'=>''
                , 'imagen'=>''
            );
        }
        return view('mant_slidercontenidos.crearEditar', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'SliderContenidos' => $SliderContenidos
        ]);

    }}

    public function index(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_slidercontenidos') || session()->get('fk_rol')==3) { $req->session()->flush(); $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        return view('mant_slidercontenidos.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Lista' =>  MantSliderContenidos::GetList($DatosGen['NombreEmpresa'][0]->bdbackoffice),
        ]);

    }}

}

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
use App\Models\MantSliders;

class MantSliders_Controller extends BaseController
{
    public function Eliminar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_sliders') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        try
        {
            if ($data['ruta']!='' && file_exists($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/", "\\", $data['ruta'])))
            {
                unlink($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/", "\\", $data['ruta']) );
            }

            MantSliders::Eliminar($data['id']);
            return "OK";

        }
        catch (Exception $e)
        {
            return "NO SE PUEDE ELIMINAR, TIENE INFORMACIÓN RELACIONADA";
        }
    }}

    public function Guardar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_sliders') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        function limpiar_texto ($valor) { $valor = str_replace("'","",$valor); $valor = str_replace("\"","",$valor); return trim($valor); }

        $data = $req->input();
        $nombreFinal = null;
        if($req->file())
        {
            $FileRandom = date("YmdHisu");
            $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\img\sliders\\".$FileRandom.".".$req->archivo->extension();
            $nombreFinal = "img/sliders/".$FileRandom.".".$req->archivo->extension();
            $tempFile = $req->archivo;
            $Archivo = move_uploaded_file($tempFile, $nombreFinal);

            $DataModel = [
                'ruta'    => $nombreFinal,
            ];

            MantSliders::Guardar($DataModel);
            return "OK";
        }
        else
        {
            return "NO SE DETECTO UN SLIDER";
        }

    }}

    public function index(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_sliders') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        return view('mant_sliders.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Lista' =>  MantSliders::GetList($DatosGen['NombreEmpresa'][0]->bdbackoffice)
        ]);

    }}
}

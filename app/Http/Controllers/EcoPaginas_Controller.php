<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\GeneralModel;
use App\Models\EcoModel;

class EcoPaginas_Controller extends BaseController
{

    public function Noticias(Request $req) {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        return view('eco_noticias.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Session' => $req->session()
            , 'Noticias' => GeneralModel::GetAllNoticias($DatosGen['NombreEmpresa'][0]->bdbackoffice)
        ]);
    }

    public function DetalleNoticias(Request $req) {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
        }
        else
        {
            $id = null;
        }
        return view('eco_detallenoticia.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Session' => $req->session()
            , 'DetalleNocitia' => GeneralModel::GetNoticiaId($DatosGen['NombreEmpresa'][0]->bdbackoffice, $id)
        ]);
    }

    public function Contacto(Request $req) {

        return view('eco_Contacto.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Session'     => $req->session()
        ]);
    }

    public function registrate(Request $req) {

        return view('eco_registrate.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Session'     => $req->session()
        ]);
    }

    public function nosotros(Request $req) {

        return view('eco_nosotros.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Session'     => $req->session()
        ]);
    }

    public function politicascomerciales(Request $req) {

        return view('eco_politicascomerciales.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Session'     => $req->session()
        ]);
    }
}

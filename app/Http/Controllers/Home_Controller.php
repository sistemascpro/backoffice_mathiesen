<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\GeneralModel;
use App\Models\Login;

class Home_Controller extends BaseController
{

    public function ecommerce(Request $req) { if($req->session()->get('fk_rol')!==null && $req->session()->get('fk_rol')!='CLIENTE' ) { return redirect('/home'); } else {

        return view('eco_home.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
        ]);

    }}

    public function index(Request $req) { if(!$req->session()->get('nombre') ) { $req->session()->flush(); return redirect('login'); } else {

        if($req->session()->get('fk_rol')=='CLIENTE'){
            return redirect('/eco_index');
        }else{
            return view('home.index', [
                'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            ]);
        }
    }}

    public function GetDate() {
        return date("Y-m-d");
    }


    public function GetDateTime() {
        return date("Y-m-d H:i");
    }

    public function MoneyChile($numero){
        $numero = (string)$numero;
        $puntos = floor((strlen($numero)-1)/3);
        $tmp = "";
        $pos = 1;
        for($i=strlen($numero)-1; $i>=0; $i--){
        $tmp = $tmp.substr($numero, $i, 1);
        if($pos%3==0 && $pos!=strlen($numero))
        $tmp = $tmp.".";
        $pos = $pos + 1;
        }
        $formateado = "$ ".strrev($tmp);
        return $formateado;
    }

    public function LimpiarTexto($valor) {
        $valor = str_replace("'","",$valor); 
        $valor = str_replace("\"","",$valor); 
        return strtoupper(trim($valor));
    }

    public function DatosGen($req) {
        
        $DatosGen['NombreEmpresa']  = GeneralModel::GetNombreEmpresa('backoffice_mathiesen');
        $Banners                    = GeneralModel::GetBanners($DatosGen['NombreEmpresa'][0]->bdbackoffice);
        $DatosGen['Sliders']        = GeneralModel::GetSliders($DatosGen['NombreEmpresa'][0]->bdbackoffice);
        $DatosGen['Familias']       = GeneralModel::GetFamiliasHome($DatosGen['NombreEmpresa'][0]->bdbackoffice);
        $DatosGen['Marcas']         = GeneralModel::GetMarcas($DatosGen['NombreEmpresa'][0]->bdbackoffice);
        $DatosGen['Banner1']        = '';   $DatosGen['Banner1Link']    = '#';
        $DatosGen['Banner2']        = '';   $DatosGen['Banner2Link']    = '#';
        $DatosGen['Banner3']        = '';   $DatosGen['Banner3Link']    = '#';
        $DatosGen['Banner4']        = '';   $DatosGen['Banner4Link']    = '#';
        $DatosGen['Banner5']        = '';   $DatosGen['Banner5Link']    = '#';
        $DatosGen['Banner6']        = '';   $DatosGen['Banner6Link']    = '#';
        $DatosGen['Banner7']        = '';   $DatosGen['Banner7Link']    = '#';
        $DatosGen['Banner8']        = '';   $DatosGen['Banner8Link']    = '#';
        $DatosGen['Banner9']        = '';   $DatosGen['Banner9Link']    = '#';
        $DatosGen['Banner10']       = '';   $DatosGen['Banner10Link']   = '#';
        $DatosGen['Banner11']       = '';   $DatosGen['Banner11Link']   = '#';
        $DatosGen['Banner12']       = '';   $DatosGen['Banner12Link']   = '#';
        $DatosGen['Banner13']       = '';   $DatosGen['Banner13Link']   = '#';
        $DatosGen['Banner14']       = '';   $DatosGen['Banner14Link']   = '#';
        $DatosGen['Banner15']       = '';   $DatosGen['Banner15Link']   = '#';
        $DatosGen['Banner16']       = '';   $DatosGen['Banner16Link']   = '#';
        $DatosGen['Banner17']       = '';   $DatosGen['Banner17Link']   = '#';
        $DatosGen['Banner18']       = '';   $DatosGen['Banner18Link']   = '#';
        $DatosGen['MenuWebPadres']  = GeneralModel::GetMenusProductosPadres($DatosGen['NombreEmpresa'][0]->bdbackoffice);
        $DatosGen['MenuBuscador']   = GeneralModel::GetMenuBuscador($DatosGen['NombreEmpresa'][0]->bdbackoffice);
        $DatosGen['Clientes']       = GeneralModel::GetClientes($DatosGen['NombreEmpresa'][0]->bdbackoffice, $req->session()->get('id'));
        $DatosGen['Noticias']       = GeneralModel::GetNoticias($DatosGen['NombreEmpresa'][0]->bdbackoffice);
        $DatosGen['Paises']         = GeneralModel::GetPaises($DatosGen['NombreEmpresa'][0]->bdbackoffice);
        $DatosGen['Session']        = $req->session();
        $DatosGen['SliderContenidos']        = GeneralModel::GetSliderContenidos($DatosGen['NombreEmpresa'][0]->bdbackoffice);
        
        $DatosGen['NombreUsuario']        = $req->session()->get('nombre');

        foreach($Banners as $lsRow){
            if($lsRow->posicion==1){
                $DatosGen['Banner1']       = $lsRow->ruta;
                $DatosGen['Banner1Link']   = " onclick=\"CargarProductos('banner', '".$lsRow->id."')\" ";
            }
            else if($lsRow->posicion==2){
                $DatosGen['Banner2']       = $lsRow->ruta;
                $DatosGen['Banner2Link']   = " onclick=\"CargarProductos('banner', '".$lsRow->id."')\" ";
            }
            else if($lsRow->posicion==3){
                $DatosGen['Banner3']       = $lsRow->ruta;
                $DatosGen['Banner3Link']   = " onclick=\"CargarProductos('banner', '".$lsRow->id."')\" ";
            }
            else if($lsRow->posicion==4){
                $DatosGen['Banner4']       = $lsRow->ruta;
                $DatosGen['Banner4Link']   = " onclick=\"CargarProductos('banner', '".$lsRow->id."')\" ";
            }
            else if($lsRow->posicion==5){
                $DatosGen['Banner5']       = $lsRow->ruta;
                $DatosGen['Banner5Link']   = " onclick=\"CargarProductos('banner', '".$lsRow->id."')\" ";
            }
            else if($lsRow->posicion==6){
                $DatosGen['Banner6']       = $lsRow->ruta;
                $DatosGen['Banner6Link']   = " onclick=\"CargarProductos('banner', '".$lsRow->id."')\" ";
            }
            else if($lsRow->posicion==7){
                $DatosGen['Banner7']       = $lsRow->ruta;
                $DatosGen['Banner7Link']   = " onclick=\"CargarProductos('banner', '".$lsRow->id."')\" ";
            }
            else if($lsRow->posicion==8){
                $DatosGen['Banner8']       = $lsRow->ruta;
                $DatosGen['Banner8Link']   = " onclick=\"CargarProductos('banner', '".$lsRow->id."')\" ";
            }
            else if($lsRow->posicion==9){
                $DatosGen['Banner9']       = $lsRow->ruta;
                $DatosGen['Banner9Link']   = " onclick=\"CargarProductos('banner', '".$lsRow->id."')\" ";
            }
            else if($lsRow->posicion==10){
                $DatosGen['Banner10']       = $lsRow->ruta;
                $DatosGen['Banner10Link']   = " onclick=\"CargarProductos('banner', '".$lsRow->id."')\" ";
            }
            else if($lsRow->posicion==11){
                $DatosGen['Banner11']       = $lsRow->ruta;
                $DatosGen['Banner11Link']   = " onclick=\"CargarProductos('banner', '".$lsRow->id."')\" ";
            }
            else if($lsRow->posicion==12){
                $DatosGen['Banner12']       = $lsRow->ruta;
                $DatosGen['Banner12Link']   = " onclick=\"CargarProductos('banner', '".$lsRow->id."')\" ";
            }
            else if($lsRow->posicion==13){
                $DatosGen['Banner13']       = $lsRow->ruta;
                $DatosGen['Banner13Link']   = " onclick=\"CargarProductos('banner', '".$lsRow->id."')\" ";
            }    
            else if($lsRow->posicion==14){
                $DatosGen['Banner14']       = $lsRow->ruta;
                $DatosGen['Banner14Link']   = " onclick=\"CargarProductos('banner', '".$lsRow->id."')\" ";
            }   
            else if($lsRow->posicion==15){
                $DatosGen['Banner15']       = $lsRow->ruta;
                $DatosGen['Banner15Link']   = " onclick=\"CargarProductos('banner', '".$lsRow->id."')\" ";
            }   
            else if($lsRow->posicion==16){
                $DatosGen['Banner16']       = $lsRow->ruta;
                $DatosGen['Banner16Link']   = " onclick=\"CargarProductos('banner', '".$lsRow->id."')\" ";
            }   
            else if($lsRow->posicion==17){
                $DatosGen['Banner17']       = $lsRow->ruta;
                $DatosGen['Banner17Link']   = " onclick=\"CargarProductos('banner', '".$lsRow->id."')\" ";
            }   
            else if($lsRow->posicion==18){
                $DatosGen['Banner18']       = $lsRow->ruta;
                $DatosGen['Banner18Link']   = " onclick=\"CargarProductos('banner', '".$lsRow->id."')\" ";
            }                                                                       
        }

        return $DatosGen;
    }

}

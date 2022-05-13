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
use App\Models\MantProductos;
use App\Models\MantProductosFamilias;

class MantProductos_Controller extends BaseController
{
    public function GetHistorialArchivos(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        return json_encode(MantProductos::GetHistorialArchivos($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['fk_producto']));

    }}

    public function CargarCaracteristicasFamilia(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();

        $Caracteristicas = MantProductos::CargarCaracteristicasFamilia($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['fk_familia'], $data['fk_producto']);

        $Salida = "";

        if( count($Caracteristicas)<=0 )
        {
            $Salida = "<div class=\"col-12 mb-3\"><h6 class=\"mb-0 text-danger\">SIN CARACTERISTICAS ESPECIALES</h6></div>";
        }
        else
        {
            foreach($Caracteristicas as $lsRow)
            {
                if($lsRow->prod_caract!=null)
                {
                    $checked=' checked ';
                }
                else
                {
                    $checked = '';
                }

                if( $lsRow->caract_tipo_id==1)
                {
                    $CaractVal = MantProductos::GetCaracteristicasValores($DatosGen['NombreEmpresa'][0]->bdbackoffice, $lsRow->caract_id, $data['fk_producto']);
                    if(count($CaractVal)>0)
                    {
                        $Valor = $CaractVal[0]->valor;
                    }
                    else
                    {
                        $Valor='';
                    }
                    if( $lsRow->libre=="NO" )
                    {
                        $ReadOnly=' readonly ';
                    }
                    else
                    {
                        $ReadOnly=' ';
                    }
                    $Salida .="
                    <div class=\"col-12 row mb-3\">
                        <div class=\"mr-5\" style=\"width:20px!important\"><input class=\"form-check-input chbk-20\" type=\"checkbox\" id=\"chkCaracteristica[]\" name=\"chkCaracteristica[]\" value=\"".$lsRow->caract_id."\" ".$checked."></div>
                        <div class=\"col-2 text-secondary\">".$lsRow->caract_nombre."</div>
                        <div class=\"col-8 text-secondary\"><input type=\"text\" class=\"ProdRequired form-control\" maxlength=\"250\" id=\"CaractVal[".$lsRow->caract_id."]\" name=\"CaractVal[".$lsRow->caract_id."]\" value=\"".$Valor."\" ".$ReadOnly."></div>
                    </div>";
                }
                else if( $lsRow->caract_tipo_id==2)
                {
                    $CaractVal = MantProductos::GetCaracteristicasValores($DatosGen['NombreEmpresa'][0]->bdbackoffice, $lsRow->caract_id, $data['fk_producto']);
                    if(count($CaractVal)>0){ $Valor = $CaractVal[0]->valor; } else { $Valor=''; }
                    if( $lsRow->libre=="NO" ) { $ReadOnly=' readonly '; } else { $ReadOnly=' '; }
                    $Salida .="
                    <div class=\"col-12 row mb-3\">
                        <div class=\"mr-5\" style=\"width:20px!important\"><input class=\"form-check-input chbk-20\" type=\"checkbox\" id=\"chkCaracteristica[]\" name=\"chkCaracteristica[]\" value=\"".$lsRow->caract_id."\" ".$checked."></div>
                        <div class=\"col-sm-2 text-secondary\">".$lsRow->caract_nombre."</div>
                        <div class=\"col-sm-8 text-secondary\"><textarea class=\"ProdRequired form-control\" maxlength=\"250\" id=\"CaractVal[".$lsRow->caract_id."]\" name=\"CaractVal[".$lsRow->caract_id."]\" ".$ReadOnly.">".$Valor."</textarea></div>
                    </div>";
                }
                else if( $lsRow->caract_tipo_id==4)
                {
                    $CaractVal = MantProductos::GetCaracteristicasValores($DatosGen['NombreEmpresa'][0]->bdbackoffice, $lsRow->caract_id, $data['fk_producto']);
                    if(count($CaractVal)>0){ $Valor = $CaractVal[0]->valor; } else { $Valor=''; }
                    if( $lsRow->libre=="NO" ) { $ReadOnly=' readonly '; } else { $ReadOnly=' '; }
                    $Salida .="
                    <div class=\"col-12 row mb-3\">
                    <div class=\"mr-5\" style=\"width:20px!important\"><input class=\"form-check-input chbk-20\" type=\"checkbox\" id=\"chkCaracteristica[]\" name=\"chkCaracteristica[]\" value=\"".$lsRow->caract_id."\" ".$checked."></div>
                        <div class=\"col-sm-2 text-secondary\">".$lsRow->caract_nombre."</div>
                        <div class=\"col-sm-8 text-secondary\"><input type=\"text\" class=\"ProdRequired form-control\" maxlength=\"250\" id=\"CaractVal[".$lsRow->caract_id."]\" name=\"CaractVal[".$lsRow->caract_id."]\" value=\"".$Valor."\" ".$ReadOnly."></div>
                    </div>";
                }
                else if( $lsRow->caract_tipo_id==3 )
                {
                    if( $lsRow->caract_tipo_id==3 )
                    {
                        $Multiple = 'multiple'; $MultipleMensaje = '<p>PARA SELECCIONAR MAS DE UNA CARACTERISTICA MANTENGA PRESIONADA LA TECLA CTRL</p>'; } else { $Multiple = ''; $MultipleMensaje = '';
                    }
                    $Opciones = MantProductos::CargarCaracteristicasFamiliaOpciones($DatosGen['NombreEmpresa'][0]->bdbackoffice, $lsRow->caract_id, $data['fk_producto']);
                    if( $lsRow->libre=="NO" )
                    {
                        $ReadOnly=' readonly ';
                    }
                    else
                    {
                        $ReadOnly=' ';
                    }
                    $Salida .="
                    <div class=\"col-12 row mb-3\">
                    <div class=\"mr-5\" style=\"width:20px!important\"><input class=\"form-check-input chbk-20\" type=\"checkbox\" id=\"chkCaracteristica[]\" name=\"chkCaracteristica[]\" value=\"".$lsRow->caract_id."\" ".$checked."></div>
                        <div class=\"col-sm-2 text-secondary\">".$lsRow->caract_nombre."</div>
                        <div class=\"col-sm-8 text-secondary\">
                            <select class=\"ProdRequired form-select\" maxlength=\"30\" id=\"SelectVal[".$lsRow->caract_id."]\" name=\"SelectVal[]\" multiple>";
                            foreach($Opciones as $lsOpt)
                            {
                                if( $lsOpt->fk_producto!=null )
                                {
                                    $selected = ' selected ';
                                }
                                else
                                {
                                    $selected = '';
                                }
                                $Salida .="<option value=\"opSelect_".$lsOpt->id."\" ".$selected.">".$lsOpt->opcion."</option>";
                            }
                    $Salida .="</select>
                            ".$MultipleMensaje."
                        </div>
                    </div>";
                }
            }
        }
        return $Salida;
    }}

    public function CargarFamiliasSecundarias(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        return json_encode(MantProductos::CargarFamiliasSecundarias($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['fk_familia'], $data['fk_producto']));

    }}

    public function EliminarArchivo(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $data = $req->input();
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        try {

            if( $data['tipo']=='fichatecnica' )
            {
                $DataModel = [
                    'fichatecnica'  => null,
                ];
                MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $data['producto']);
            }
            else if( $data['tipo']=='hojaseguridad' )
            {
                $DataModel = [
                    'hojaseguridad'  => null,
                ];
                MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $data['producto']);
            }
            else if( $data['tipo']=='archivoextra' )
            {
                $DataModel = [
                    'archivoextra'  => null,
                    'archivoextranombre'  => null,
                ];
                MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $data['producto']);
            }
            else if(unlink($_SERVER['DOCUMENT_ROOT']."\\".str_replace("/", "\\", $data['archivo']) ))
            {
                if( $data['tipo']=='imagen1' )
                {
                    $DataModel = [
                        'imagen1'  => null,
                    ];
                    MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $data['producto']);
                }
                else if( $data['tipo']=='imagen2' )
                {
                    $DataModel = [
                        'imagen2'  => null,
                    ];
                    MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $data['producto']);
                }
                else if( $data['tipo']=='imagen3' )
                {
                    $DataModel = [
                        'imagen3'  => null,
                    ];
                    MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $data['producto']);
                }
                else if( $data['tipo']=='imagen4' )
                {
                    $DataModel = [
                        'imagen4'  => null,
                    ];
                    MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $data['producto']);
                }
                else if( $data['tipo']=='imagen5' )
                {
                    $DataModel = [
                        'imagen5'  => null,
                    ];
                    MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $data['producto']);
                }
                else if( $data['tipo']=='imagen6' )
                {
                    $DataModel = [
                        'imagen6'  => null,
                    ];
                    MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $data['producto']);
                }
            }

            return "OK";
        } catch (Exception $e) {
            return "NO SE PUEDE ELIMINAR, TIENE INFORMACIÓN RELACIONADA";
        }
    }}

    public function Eliminar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $data = $req->input();
        try {
            MantProductos::DeleteProducto($data['id']);
            return "OK";
        } catch (Exception $e) {
            return "NO SE PUEDE ELIMINAR, TIENE INFORMACIÓN RELACIONADA";
        }
    }}

    public function Guardar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        function limpiar_texto1 ($valor) { $valor = str_replace("'","",$valor); $valor = str_replace("\"","",$valor); return trim($valor); }
        function limpiar_texto2 ($valor) { $valor = str_replace("'","",$valor); $valor = str_replace("\"","",$valor); return $valor; }

        $data = $req->input();

        if(
            !isset($data['productoid']) || strlen(trim($data['productoid']))==0
            || !isset($data['fk_familia']) || $data['fk_familia']==0
            || !isset($data['fk_marca']) || $data['fk_marca']==0
            ){
            return "FALTA INFORMACION";
        }
        else{

            $productoid     = $data['productoid'];
            $estado         = $data['estado'];
            $vista          = limpiar_texto1($data['vista']);
            $CodProd        = limpiar_texto1($data['CodProd']);
            $DesProd        = limpiar_texto2($data['DesProd']);
            $DesProd2       = limpiar_texto2($data['DesProd2']);
            $desextra       = limpiar_texto2($data['DesExtra']);
            $archivoextranombre       = limpiar_texto2($data['archivoextranombre']);

            if ( MantProductos::ExisteCodigo($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['CodProd'], $productoid) ) {
                return "EL CODIGO YA EXISTE";
            }
            else {

                $DataModel = [
                    'codigo'            => $CodProd,
                    'descripcion'       => $DesProd,
                    'fk_familia'        => $data['fk_familia'],
                    'fk_marca'          => $data['fk_marca'],
                    'estado'            => $estado,
                    'descripcion2'      => $DesProd2,
                    'desextra'          => $desextra,
                    'vista'             => $vista,
                ];

                if($productoid==0)
                {
                    $productoid = MantProductos::GuardarProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                }
                else
                {
                    MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $productoid);
                }

                MantProductos::EliminarCaracteristicas($DatosGen['NombreEmpresa'][0]->bdbackoffice, $productoid);
                MantProductos::EliminarFamilias($DatosGen['NombreEmpresa'][0]->bdbackoffice, $productoid);
                MantProductos::EliminarPaises($DatosGen['NombreEmpresa'][0]->bdbackoffice, $productoid);
                MantProductos::EliminarProveedores($DatosGen['NombreEmpresa'][0]->bdbackoffice, $productoid);

                if(isset($data['chkPaises']))
                {
                    for( $i=0; $i<count($data['chkPaises']); $i++)
                    {
                        $DataModel = [
                            'fk_producto'       =>  $productoid,
                            'fk_pais'           =>  $data['chkPaises'][$i],
                        ];
                        MantProductos::GuardarProductoPais($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                    }
                }

                if(isset($data['chkProveedores']))
                {
                    for( $i=0; $i<count($data['chkProveedores']); $i++)
                    {
                        $DataModel = [
                            'fk_producto'       =>  $productoid,
                            'fk_proveedor'      =>  $data['chkProveedores'][$i],
                        ];
                        MantProductos::GuardarProductoProveedor($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                    }
                }

                if(isset($data['chkFamiliaSecundaria']))
                {
                    for( $i=0; $i<count($data['chkFamiliaSecundaria']); $i++)
                    {
                        $DataModel = [
                            'fk_producto'       =>  $productoid,
                            'fk_familia'        =>  $data['chkFamiliaSecundaria'][$i],
                        ];
                        MantProductos::GuardarProductoFamilia($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                    }
                }

                if(isset($data['chkCaracteristica']))
                {
                    for( $i=0; $i<count($data['chkCaracteristica']); $i++)
                    {
                        $OpcionesSelect = MantProductos::GetOpcionesSelect($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['chkCaracteristica'][$i]);

                        if( count($OpcionesSelect)>0 )
                        {
                            for($Aux=0; $Aux<count($OpcionesSelect); $Aux++){

                                for($x=0; $x<count($data['SelectVal']); $x++)
                                {
                                    if($data['SelectVal'][$x]=="opSelect_".$OpcionesSelect[$Aux]->id)
                                    {
                                        $DataModel = [
                                            'fk_producto'       =>  $productoid,
                                            'fk_caracteristica' =>  $data['chkCaracteristica'][$i],
                                            'valor'             =>  $OpcionesSelect[$Aux]->id,
                                        ];
                                        MantProductos::GuardarCaracteristicaProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                                    }
                                }
                            }
                        }
                        else
                        {
                            $DataModel = [
                                'fk_producto'       =>  $productoid,
                                'fk_caracteristica' =>  $data['chkCaracteristica'][$i],
                                'valor'             =>  $data['CaractVal'][$data['chkCaracteristica'][$i]],
                            ];
                            MantProductos::GuardarCaracteristicaProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                        }
                    }
                }

                $fichatecnica = null;
                $imagen1 = null;
                $imagen2 = null;
                $imagen3 = null;
                $imagen4 = null;
                $imagen5 = null;
                $imagen6 = null;
                $hojaseguridad = null;

                if($req->file())
                {
                    if( empty($req->fichatecnica)!='1' )
                    {
                        $AuxName = date('YmdHisu');
                        $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\productos_files\\".$AuxName."_".$CodProd.".".$req->fichatecnica->extension();
                        $fichatecnica = "productos_files/".$AuxName."_".$CodProd.".".$req->fichatecnica->extension();
                        $tempFile = $req->fichatecnica;
                        $Archivo = move_uploaded_file($tempFile, $nombreTemp);
                        $DataModel = [
                            'fichatecnica'  => $fichatecnica,
                        ];
                        MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $productoid);

                        $DataModel = [
                            'archivo'       => $fichatecnica,
                            'tipo'          => 'FICHA TECNICA',
                            'nombre'        => null,
                            'fk_producto'   => $productoid,
                            'fecha'   => date('d-m-Y'),
                            'responsable'   => session()->get('nombre'),
                        ];
                        MantProductos::GuardarProductosArchivos($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                    }

                    if( empty($req->hojaseguridad)!='1' )
                    {
                        $AuxName = date('YmdHisu');
                        $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\productos_files\\".$AuxName."_".$CodProd.".".$req->hojaseguridad->extension();
                        $hojaseguridad = "productos_files/".$AuxName."_".$CodProd.".".$req->hojaseguridad->extension();
                        $tempFile = $req->hojaseguridad;
                        $Archivo = move_uploaded_file($tempFile, $nombreTemp);
                        $DataModel = [
                            'hojaseguridad'  => $hojaseguridad,
                        ];
                        MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $productoid);

                        $DataModel = [
                            'archivo'       => $hojaseguridad,
                            'tipo'          => 'HOJA SEGURIDAD',
                            'nombre'        => null,
                            'fk_producto'   => $productoid,
                            'fecha'   => date('d-m-Y'),
                            'responsable'   => session()->get('nombre'),
                        ];
                        MantProductos::GuardarProductosArchivos($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                    }

                    if( empty($req->archivoextra)!='1' )
                    {
                        $AuxName = date('YmdHisu');
                        $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\productos_files\\".$AuxName."_".$CodProd.".".$req->archivoextra->extension();
                        $archivoextra = "productos_files/".$AuxName."_".$CodProd.".".$req->archivoextra->extension();
                        $tempFile = $req->archivoextra;
                        $Archivo = move_uploaded_file($tempFile, $nombreTemp);
                        $DataModel = [
                            'archivoextra'          => $archivoextra,
                            'archivoextranombre'    => $archivoextranombre,
                        ];
                        MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $productoid);

                        $DataModel = [
                            'archivo'       => $archivoextra,
                            'tipo'          => 'ARCHIVO EXTRA',
                            'nombre'        => $archivoextranombre,
                            'fk_producto'   => $productoid,
                            'fecha'   => date('d-m-Y'),
                            'responsable'   => session()->get('nombre'),
                        ];
                        MantProductos::GuardarProductosArchivos($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel);
                    }

                    if( empty($req->imagen1)!='1' )
                    {
                        $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\productos_files\\IM1_".$CodProd.".".$req->imagen1->extension();
                        $imagen1 = "productos_files/IM1_".$CodProd.".".$req->imagen1->extension();
                        $tempFile = $req->imagen1;
                        $Archivo = move_uploaded_file($tempFile, $nombreTemp);
                        $DataModel = [
                            'imagen1'  => $imagen1,
                        ];
                        MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $productoid);
                    }

                    if( empty($req->imagen2)!='1' )
                    {
                        $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\productos_files\\IM2_".$CodProd.".".$req->imagen2->extension();
                        $imagen2 = "productos_files/IM2_".$CodProd.".".$req->imagen2->extension();
                        $tempFile = $req->imagen2;
                        $Archivo = move_uploaded_file($tempFile, $nombreTemp);
                        $DataModel = [
                            'imagen2'  => $imagen2,
                        ];
                        MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $productoid);
                    }

                    if( empty($req->imagen3)!='1' )
                    {
                        $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\productos_files\\IM3_".$CodProd.".".$req->imagen3->extension();
                        $imagen3 = "productos_files/IM3_".$CodProd.".".$req->imagen3->extension();
                        $tempFile = $req->imagen3;
                        $Archivo = move_uploaded_file($tempFile, $nombreTemp);
                        $DataModel = [
                            'imagen3'  => $imagen3,
                        ];
                        MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $productoid);
                    }

                    if( empty($req->imagen4)!='1' )
                    {
                        $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\productos_files\\IM4_".$CodProd.".".$req->imagen4->extension();
                        $imagen4 = "productos_files/IM4_".$CodProd.".".$req->imagen4->extension();
                        $tempFile = $req->imagen4;
                        $Archivo = move_uploaded_file($tempFile, $nombreTemp);
                        $DataModel = [
                            'imagen4'  => $imagen4,
                        ];
                        MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $productoid);
                    }

                    if( empty($req->imagen5)!='1' )
                    {
                        $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\productos_files\\IM5_".$CodProd.".".$req->imagen5->extension();
                        $imagen5 = "productos_files/IM5_".$CodProd.".".$req->imagen5->extension();
                        $tempFile = $req->imagen5;
                        $Archivo = move_uploaded_file($tempFile, $nombreTemp);
                        $DataModel = [
                            'imagen5'  => $imagen5,
                        ];
                        MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $productoid);
                    }

                    if( empty($req->imagen6)!='1' )
                    {
                        $nombreTemp = $_SERVER['DOCUMENT_ROOT']."\productos_files\\IM6_".$CodProd.".".$req->imagen6->extension();
                        $imagen6 = "productos_files/IM6_".$CodProd.".".$req->imagen6->extension();
                        $tempFile = $req->imagen6;
                        $Archivo = move_uploaded_file($tempFile, $nombreTemp);
                        $DataModel = [
                            'imagen6'  => $imagen6,
                        ];
                        MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $productoid);
                    }

                }
                return "OK";
            }
        }
    }}

    public function updateEstado(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();

        $DataModel = [
            'estado'    =>  $data['estado'],
        ];

        if ( MantProductos::UpdateProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $DataModel, $data['id']) )
        {
            return "OK";
        }
        else
        {
            return "ERROR";
        }

    }}

    public function crearEditar(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $data = $req->input();
        $Producto = MantProductos::GetProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['id']);
        if( count($Producto)<=0 ){

            $Producto[0] = (object)array(
                'id'=>0
                , 'codigo'=>''
                , 'vista'=>'PUBLICO'
                , 'descripcion'=>''
                , 'descripcion2'=>''
                , 'desextra'=>''
                , 'estado'=>1
                , 'fk_familia'=>0
                , 'fichatecnica'=>null
                , 'hojaseguridad'=>null
                , 'imagen1'=>null
                , 'imagen2'=>null
                , 'imagen3'=>null
                , 'imagen4'=>null
                , 'imagen5'=>null
                , 'imagen6'=>null
                , 'archivoextra'=>null
                , 'archivoextranombre'=>null
            );
        }

        return view('mant_productos.crearEditar', [
            'DatosGen' => $DatosGen
            , 'Producto' => $Producto
            , 'Familia' =>  MantProductos::GetFamilias($DatosGen['NombreEmpresa'][0]->bdbackoffice, $Producto[0]->id)
            , 'Marcas'  =>  MantProductos::GetMarcas($DatosGen['NombreEmpresa'][0]->bdbackoffice, $Producto[0]->id)
            , 'Proveedores' =>  MantProductos::GetProveedores($DatosGen['NombreEmpresa'][0]->bdbackoffice, $Producto[0]->id)
            , 'Paises' =>  MantProductos::GetPaises($DatosGen['NombreEmpresa'][0]->bdbackoffice, $Producto[0]->id)
            , 'ModuloTitulo1' => 'MANTENEDOR DE PRODUCTOS'
            , 'ModuloTitulo2' => 'CREAR/EDITAR PRODUCTOS'
            , 'ModuloRuta' => 'mant_productos'
            , 'ModuloRequired' => 'ProdRequired'
        ]);
    }}

    public function index(Request $req) { if(!$req->session()->get('nombre') || !Login::ValidatePermiso(session()->get('fk_rol'),'mant_productos') || session()->get('fk_rol')==3) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        return view('mant_productos.index', [
            'DatosGen' => $DatosGen
            , 'Lista' =>  MantProductos::GetList($DatosGen['NombreEmpresa'][0]->bdbackoffice)
            , 'ModuloTitulo1' => 'MANTENEDOR DE PRODUCTOS'
            , 'ModuloTitulo2' => 'PRODUCTOS'
            , 'ModuloRuta' => 'mant_productos'
            , 'ModuloRequired' => 'ProdRequired'
        ]);

    }}
}

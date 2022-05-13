<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\EcoModel;
use App\Models\GeneralModel;
use App\Models\MantUsuarios;
use App\Models\MantClientes;
use App\Models\MantProductos;
use App\Models\MantProductosFamilias;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Mail;


class Eco_Controller extends BaseController
{
    public function GetSinCorreo(Request $req) {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);
        $Pedido = EcoModel::GetSinCorreo($DatosGen['NombreEmpresa'][0]->bd, $DatosGen['NombreEmpresa'][0]->bdbackoffice);

        for ( $i=0; $i<count($Pedido); $i++){
            $DataModel = [
                'correo'  => 'SI'
            ];
            EcoModel::UpdatePedidoSoftland($DataModel, $Pedido[$i]->fk_pedido);
        }
    }

    public function RealizarPago(Request $req) { if( !$req->session()->get('nombre') || !$req->session()->get('fk_rol') ) { $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $Pedido = EcoModel::getPedidoTemporal($req->session()->get('cliente_codigo'), $DatosGen['NombreEmpresa'][0]->bdbackoffice);
        $ClienteInfo = EcoModel::getInfoClienteCotizacion($DatosGen['NombreEmpresa'][0]->bd, $req->session()->get('id'));

        if(count($Pedido)<=0){
            return "ERROR_SinPedido";
        }else{

            $Productos = EcoModel::getDetalleBolsa($Pedido[0]->id, $DatosGen['NombreEmpresa'][0]->bdbackoffice);

            if( count($Productos)<=0 ){
                return "ERROR_SinProductos";
            } else{

                $Data['ClienteInfo'] = $ClienteInfo;
                $Data['Productos'] = $Productos;
                $DataModel = [
                    'estado_terminado'  => 'SI',
                ];
                EcoModel::UpdateProductoTerminado($DataModel, $Pedido[0]->id);

                $DataModel = [
                    'estado_terminado'  => 'SI',
                ];
                EcoModel::UpdatePedido($DataModel, $Pedido[0]->id);

                $Correos[0] = 'edo.v81@gmail.com';
                $Correos[1] = 'contacto.mathiesen@grupomathiesen.com';
                $Correos[2] = trim($ClienteInfo[0]->email);
                $Correos[3] = 'ssalom@grupomathiesen.com';

                Mail::send('eco_templates.CorreoCotizacion', $Data, function($message) use ($Correos, $Data)
                {
                    $message->from('contacto.mathiesen@grupomathiesen.com', 'MATHIESEN');
                    $message->to($Correos, 'COTIZACIÓN');
                    $message->subject('COTIZACIÓN - '.date("Y-m-d H:i"));
                    $message->replyTo($Correos[2], 'Cliente');
                });

                return "OK";

            }
        }
    }}

    public function UpdateComentario(Request $req) { if( !$req->session()->get('nombre') || !$req->session()->get('fk_rol') ) { $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);
        $Pedido = EcoModel::getPedidoTemporal($req->session()->get('cliente_codigo'), $DatosGen['NombreEmpresa'][0]->bdbackoffice);

        if(count($Pedido)<=0){
            return "ERROR_SinPedido";
        }else{
            $Pedido = $Pedido[0]->id;
            $DataModel = [
                'observaciones'    => substr($data['Comentario'],0,3990)
            ];
            EcoModel::UpdatePedido($DataModel, $Pedido);
            return "OK";
        }
    }}

    public function UpdateDireccionDespacho(Request $req) { if( !$req->session()->get('nombre') || !$req->session()->get('fk_rol') ) { $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);
        $Pedido = EcoModel::getPedidoTemporal($req->session()->get('cliente_codigo'), $DatosGen['NombreEmpresa'][0]->bdbackoffice);
        $Direccion = EcoModel::GetDireccionCliente($DatosGen['NombreEmpresa'][0]->bd, $req->session()->get('cliente_codigo'), $data['id']);

        if(count($Pedido)<=0){
            return "ERROR_SinPedido";
        }else{
            $Pedido = $Pedido[0]->id;
            $DataModel = [
                'despacho_id'    => $data['id']
            ];
            EcoModel::UpdatePedido($DataModel, $Pedido);
            return $Direccion;
        }
    }}

    public function UpdateOpcionDespacho(Request $req) { if( !$req->session()->get('nombre') || !$req->session()->get('fk_rol') ) { $req->session()->flush();  return redirect('login'); } else {

        $data = $req->input();
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);
        $Pedido = EcoModel::getPedidoTemporal($req->session()->get('cliente_codigo'), $DatosGen['NombreEmpresa'][0]->bdbackoffice);

        if(count($Pedido)<=0){
            return "ERROR_SinPedido";
        }else{
            $Pedido = $Pedido[0]->id;
            $DataModel = [
                'despacho_opcion'    => $data['id']
            ];
            EcoModel::UpdatePedido($DataModel, $Pedido);
            return "OK";
        }
    }}

    public function ValidarCodigoDescuento(Request $req) { if( !$req->session()->get('nombre') || !$req->session()->get('fk_rol') ) { $req->session()->flush();  return redirect('login'); } else {
        $data = $req->input();
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);
        $ExisteDescuento = EcoModel::ValidarCodigoDescuento($data['codigo'],$req->session()->get('cliente_codigo'), $DatosGen['NombreEmpresa'][0]->bdbackoffice);
        $Pedido = EcoModel::getPedidoTemporal($req->session()->get('cliente_codigo'), $DatosGen['NombreEmpresa'][0]->bdbackoffice);

        if(count($ExisteDescuento)<=0){
            if(count($Pedido)>0){
                $Pedido = $Pedido[0]->id;
                $DataModel = [
                    'codigo_descuento'    => ''
                ];
                EcoModel::UpdatePedido($DataModel, $Pedido);
            }
            return "ERROR_Sincodigo";
        }else{

            if(count($Pedido)<=0){
                return "ERROR_SinPedido";
            }else if( $ExisteDescuento[0]->id_codigo==$Pedido[0]->codigo_descuento ){
                return "ERROR_CodigoActual";
            }else if( trim($ExisteDescuento[0]->usado)=='SI' ){
                return "ERROR_CodigoUsado";
            }else{
                $Pedido = $Pedido[0]->id;
                $DataModel = [
                    'codigo_descuento'    => $ExisteDescuento[0]->id_codigo
                ];
                EcoModel::UpdatePedido($DataModel, $Pedido);
                $DataModel = [
                    'usado'    => 'SI'
                ];
                EcoModel::UpdateCodigoDescuento($DataModel, $ExisteDescuento[0]->id_cliente);
                return "OK";
            }
        }
    }}

    public function addQuitarLinea(Request $req) { if( !$req->session()->get('nombre') || !$req->session()->get('fk_rol') ) { $req->session()->flush();  return redirect('login'); } else {
        $data = $req->input();
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        EcoModel::deleteLineaProductoActual($data['id']);
        return "OK";
    }}

    public function ModificarUno(Request $req) { if( !$req->session()->get('nombre') || !$req->session()->get('fk_rol') ) { $req->session()->flush();  return redirect('login'); } else {
        $data = $req->input();
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $ClienteCobrador = EcoModel::getClienteCobrador($DatosGen['NombreEmpresa'][0]->bd, $req->session()->get('cliente_codigo'));
        if( !$ClienteCobrador ){ $ClienteCobrador=1; } else { $ClienteCobrador=2; }

        $Actual = EcoModel::getLineaProductoActual($data['id'], $DatosGen['NombreEmpresa'][0]->bdbackoffice);
        $CantVenta = ($Actual[0]->cant_venta*1)+$data['cant'];

        if($CantVenta<=0)
        {
            EcoModel::deleteLineaProductoRegalo($data['id']);
            EcoModel::deleteLineaProductoActual($data['id']);
        }
        else
        {
            $Condicion = " prod.codprod='".$Actual[0]->codigo."'";
            $AuxCondicionCaracOpcion = '';
            $ProductoInfo = EcoModel::getProductosActivos($Condicion, $ClienteCobrador, $DatosGen['NombreEmpresa'][0]->bd, $DatosGen['NombreEmpresa'][0]->bdbackoffice, $AuxCondicionCaracOpcion);


            if( $req->session()->get('cliente_codigo')=='0' ) {
                return "ERROR_ClienteActivo";
            } else if( count($ProductoInfo)<=0 ){
                return "ERROR_InfoProducto";
            } else if( $ProductoInfo[0]->stock<=0 ) {
                return "ERROR_Stock";
            } else if( $ProductoInfo[0]->stock<1 ) {
                return "ERROR_Stock";
            } else {

                $ErrorProducto  =   0;
                $PrecioLista    =   $ProductoInfo[0]->PrecioVta;
                $Descuento      =   0;
                $PrecioVenta    =   $ProductoInfo[0]->PrecioVta;
                if(
                    $ProductoInfo[0]->soft_promodescuento1!=null
                    && $ProductoInfo[0]->soft_promodescuento1_dcto!=null
                    && $ProductoInfo[0]->soft_promodescuento1_cant!=null
                    && $ProductoInfo[0]->soft_promodescuento1>0
                    && $ProductoInfo[0]->soft_promodescuento1_dcto>0
                    && $ProductoInfo[0]->soft_promodescuento1_cant>0
                    && $CantVenta>=$ProductoInfo[0]->soft_promodescuento1_cant)
                {
                    $Descuento = $ProductoInfo[0]->soft_promodescuento1_dcto;
                    $PrecioVenta = round($ProductoInfo[0]->PrecioVta-round(($ProductoInfo[0]->PrecioVta/$ProductoInfo[0]->soft_promodescuento1_dcto)/100));
                }

                try {
                    $DataModel = [
                        'fk_pedido'         => $Actual[0]->fk_pedido
                        ,'estado_valido'     => 'SI'
                        ,'estado_terminado'  => 'NO'
                        ,'estado_softland'   => 'NO'
                        ,'bloq_descuento'    => 'NO'
                        ,'bloq_margen'       => 'NO'
                        ,'bloq_margenemp'    => 'NO'
                        ,'precio_lista'      => ($PrecioLista)*1
                        ,'precio_cliente'    => 0
                        ,'precio_venta'      => ($PrecioVenta)*1
                        ,'descuento'         => ($Descuento)*1
                        ,'descuento_extra'   => 0
                        ,'unidad_medida'     => $ProductoInfo[0]->CodUMed
                        ,'padre_id'          => 0
                        ,'regalo'            => 'NO'
                        ,'cant_venta'        => $CantVenta
                        ,'codigo'            => $ProductoInfo[0]->codprod
                        ,'descripcion'       => $ProductoInfo[0]->DesProd
                        ,'ing_fecha'         => app('App\Http\Controllers\Home_Controller')->GetDateTime()
                        ,'ing_id'            => $req->session()->get('id')
                        ,'ing_nombre'        => $req->session()->get('nombre')
                        ,'del_fecha'         => app('App\Http\Controllers\Home_Controller')->GetDateTime()
                        ,'del_id'            => 0
                        ,'del_nombre'        => ''
                        ,'latitud'           => ''
                        ,'longitud'          => ''
                    ];
                    EcoModel::updateProducto($DataModel, $data['id']);
                    $DataModel = [
                        'estado_valido'     => 'NO'
                    ];
                    EcoModel::updateProductoRegalo($DataModel, $data['id']);
                } catch (Exception $e) { $ErrorProducto=1; return "ERROR_GuardarProducto"; }

                if($ErrorProducto==0){
                    if( $ProductoInfo[0]->regalo!='0' && $ProductoInfo[0]->regalo_1>0 && $ProductoInfo[0]->regalo_2>0 && $CantVenta>=$ProductoInfo[0]->regalo_1 ) {

                        $CantidadRegalo = intdiv($CantVenta, $ProductoInfo[0]->regalo_1);

                        try {
                            $DataModel = [
                                'fk_pedido'          => $Actual[0]->fk_pedido
                                ,'estado_valido'     => 'SI'
                                ,'estado_terminado'  => 'NO'
                                ,'estado_softland'   => 'NO'
                                ,'bloq_descuento'    => 'NO'
                                ,'bloq_margen'       => 'NO'
                                ,'bloq_margenemp'    => 'NO'
                                ,'precio_lista'      => ($PrecioLista)*1
                                ,'precio_cliente'    => 0
                                ,'precio_venta'      => 1
                                ,'descuento'         => 0
                                ,'descuento_extra'   => 0
                                ,'unidad_medida'     => $ProductoInfo[0]->CodUMed
                                ,'padre_id'          => $data['id']
                                ,'regalo'            => 'SI'
                                ,'cant_venta'        => $CantidadRegalo
                                ,'codigo'            => $ProductoInfo[0]->codprod
                                ,'descripcion'       => $ProductoInfo[0]->DesProd
                                ,'ing_fecha'         => app('App\Http\Controllers\Home_Controller')->GetDateTime()
                                ,'ing_id'            => $req->session()->get('id')
                                ,'ing_nombre'        => $req->session()->get('nombre')
                                ,'del_fecha'         => app('App\Http\Controllers\Home_Controller')->GetDateTime()
                                ,'del_id'            => 0
                                ,'del_nombre'        => ''
                                ,'latitud'           => ''
                                ,'longitud'          => ''
                            ];

                            if( EcoModel::existeRegalo($data['id'], $DatosGen['NombreEmpresa'][0]->bdbackoffice) ){
                                EcoModel::updateProductoRegalo($DataModel, $data['id']);
                            } else {
                                EcoModel::addProducto($DataModel, $data['id']);
                            }

                        } catch (Exception $e) { $ErrorProducto=1; return "ERROR_GuardarProductoRegalo"; }
                    }
                }
                return "OK";
            }
        }
    }}

    public function getSubTotalBolsa(Request $req) {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        return EcoModel::getSubtotalTemporal($req->session()->get('cliente_codigo'), $DatosGen['NombreEmpresa'][0]->bdbackoffice);
    }

    public function addProducto(Request $req) {
        $data = $req->input();
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $Condicion = " prod.id='".$data['codigo']."'";
        $AuxCondicionCaracOpcion='';
        $ProductoInfo = EcoModel::getProductosActivos($Condicion, $DatosGen['NombreEmpresa'][0]->bd, $DatosGen['NombreEmpresa'][0]->bdbackoffice,$AuxCondicionCaracOpcion);
        $ClienteInfo = EcoModel::getInfoCliente($DatosGen['NombreEmpresa'][0]->bd, $req->session()->get('cliente_codigo'));

        if( $req->session()->get('cliente_codigo')=='0' ) 
        {
            return "ERROR_ClienteActivo";
        }
        else if( count($ClienteInfo)<=0 )
        {
            return "ERROR_InfoCliente";
        }
        else if( count($ProductoInfo)<=0 )
        {
            return "ERROR_InfoProducto";
        }
        else
        {
            $Pedido = EcoModel::getPedidoTemporal($req->session()->get('cliente_codigo'), $DatosGen['NombreEmpresa'][0]->bdbackoffice);

            if(count($Pedido)<=0){

                try {
                    $DataModel = [
                        'estado_terminado'          => 'NO'
                        , 'id_cotizacion'           => 0
                        , 'estado_cotizacion'       => 'NO'
                        , 'bloq_sobregiro'          => 'NO'
                        , 'bloq_sistema'            => 'NO'
                        , 'bloq_descuento'          => 'NO'
                        , 'bloq_margen'             => 'NO'
                        , 'bloq_despacho'           => 'NO'
                        , 'bloq_transportenuevo'    => 'NO'
                        , 'bloq_margenemp'          => 'NO'
                        , 'bloq_cliente'            => 'NO'
                        , 'id_referencia'           => ''
                        , 'ing_fecha'               => app('App\Http\Controllers\Home_Controller')->GetDateTime()
                        , 'ing_usuario'             => $req->session()->get('id')
                        , 'ing_nombre'              => substr($req->session()->get('nombre'),0,29)
                        , 'cliente_id'              => $req->session()->get('cliente_codigo')
                        , 'cliente_rut'             => $ClienteInfo[0]->codigo
                        , 'cliente_nombre'          => $ClienteInfo[0]->nombre
                        , 'cliente_credito'         => 0
                        , 'cliente_deuda'           => 0
                        , 'cliente_listaprecio'     => 0
                        , 'cliente_condventa'       => ''
                        , 'cliente_contacto'        => ''
                        , 'cliente_moneda'          => ''
                        , 'fecha_pedido'            => date('d-m-Y')
                        , 'fecha_entrega'           => date('d-m-Y')
                        , 'vendedor_id'             => '0'
                        , 'vendedor_nombre'         => ''
                        , 'observaciones'           => ''
                        , 'latitud'                 => ''
                        , 'longitud'                => ''
                        , 'despacho_codigo'         => ''
                        , 'despacho_id'             => 0
                        , 'codigo_descuento'        => ''
                        , 'webpay_id'               => 0
                        , 'webpay_estado'           => 'NO'
                    ];
                    $Pedido = EcoModel::addPedido($DataModel);
                } catch (Exception $e) { $Pedido = 0; }

            } else {
                $Pedido = $Pedido[0]->id;
            }

            if( $Pedido==0 || strlen($Pedido)==0 ){
                return "ERROR_Pedido";
            }else{

                $ErrorProducto  =   0;
                $PrecioLista    =   0;
                $Descuento      =   0;
                $PrecioVenta    =   0;

                try {
                    $DataModel = [
                        'fk_pedido'         => $Pedido
                        ,'estado_valido'     => 'SI'
                        ,'estado_terminado'  => 'NO'
                        ,'estado_softland'   => 'NO'
                        ,'bloq_descuento'    => 'NO'
                        ,'bloq_margen'       => 'NO'
                        ,'bloq_margenemp'    => 'NO'
                        ,'precio_lista'      => 0
                        ,'precio_cliente'    => 0
                        ,'precio_venta'      => 0
                        ,'descuento'         => 0
                        ,'descuento_extra'   => 0
                        ,'unidad_medida'     => ''
                        ,'padre_id'          => 0
                        ,'regalo'            => 'NO'
                        ,'cant_venta'        => 0
                        ,'codigo'            => $ProductoInfo[0]->id
                        ,'descripcion'       => $ProductoInfo[0]->descripcion
                        ,'ing_fecha'         => app('App\Http\Controllers\Home_Controller')->GetDateTime()
                        ,'ing_id'            => $req->session()->get('id')
                        ,'ing_nombre'        => $req->session()->get('nombre')
                        ,'del_fecha'         => app('App\Http\Controllers\Home_Controller')->GetDateTime()
                        ,'del_id'            => 0
                        ,'del_nombre'        => ''
                        ,'latitud'           => ''
                        ,'longitud'          => ''
                    ];
                    $ProductoId = EcoModel::addProducto($DataModel);
                } catch (Exception $e) { $ErrorProducto=1; return "ERROR_GuardarProducto"; }

                if($ErrorProducto==0) {
                    return "OK";
                }

            }
        }
    }

    public function getProductosDetalle(Request $req) {

        $data = $req->input();
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $Condicion = " prod.codigo='".$data['codigo']."'";
        $AuxCondicionCaracOpcion='';
        $Productos = EcoModel::getProductosActivos($Condicion, $DatosGen['NombreEmpresa'][0]->bd, $DatosGen['NombreEmpresa'][0]->bdbackoffice,$AuxCondicionCaracOpcion);
        $Salida="";

        for($i=0; $i<count($Productos); $i++)
        {
            $Imagen = '';
            if($i%2==0){
                $Imagen = 'producto_sample_001.jpg';
            }else{
                $Imagen = 'producto_sample_002.jpg';
            }

            if($Productos[$i]->imagen1!=null && file_exists('../public/'.$Productos[$i]->imagen1))
            {
                $imagen1 = '../'.$Productos[$i]->imagen1.'?'.date("YmdHms");
            }
            else
            {
                $imagen1 = '../img/productos/SinImagen.jpg?'.date("YmdHms");
            }

            if($Productos[$i]->imagen2!=null && file_exists('../public/'.$Productos[$i]->imagen2))
            {
                $imagen2 = '../'.$Productos[$i]->imagen2.'?'.date("YmdHms");
            }
            else
            {
                $imagen2 = '../img/productos/SinImagen.jpg?'.date("YmdHms");
            }

            if($Productos[$i]->imagen3!=null && file_exists('../public/'.$Productos[$i]->imagen3))
            {
                $imagen3 = '../'.$Productos[$i]->imagen3.'?'.date("YmdHms");
            }
            else
            {
                $imagen3 = '../img/productos/SinImagen.jpg?'.date("YmdHms");
            }

            if($Productos[$i]->imagen4!=null && file_exists('../public/'.$Productos[$i]->imagen4))
            {
                $imagen4 = '../'.$Productos[$i]->imagen4.'?'.date("YmdHms");
            }
            else
            {
                $imagen4 = '../img/productos/SinImagen.jpg?'.date("YmdHms");
            }

            if($Productos[$i]->imagen5!=null && file_exists('../public/'.$Productos[$i]->imagen5))
            {
                $imagen5 = '../'.$Productos[$i]->imagen5.'?'.date("YmdHms");
            }
            else
            {
                $imagen5 = '../img/productos/SinImagen.jpg?'.date("YmdHms");
            }

            if($Productos[$i]->imagen6!=null && file_exists('../public/'.$Productos[$i]->imagen6))
            {
                $imagen6 = '../'.$Productos[$i]->imagen6.'?'.date("YmdHms");
            }
            else
            {
                $imagen6 = '../img/productos/SinImagen.jpg?'.date("YmdHms");
            }

            $Salida .= "
            <div class=\"container contPdp\">
        <div class=\"row\">
            <div class=\"col-xl-12 \">
                <div class=\"col-xl-12 col-md-12\" style=\"border-bottom: solid 1px #c3c3c3; margin-bottom: 24px; padding-bottom: 24px;\">
            <div class=\"row\">
    <div class=\"col-xl-4 col-md-4 col-sm-12 imgPlp-modal\">
        <div id=\"ImgDetalleProducto\">
            <img src=\"".$imagen1."\">
        </div>
        <div class=\"row mt-3\">
            <div class=\"col-2\" style=\"cursor:pointer\" onclick=\"SetImagenProducto('".$imagen1."')\"><img src=\"".$imagen1."\"></div>
            <div class=\"col-2\" style=\"cursor:pointer\" onclick=\"SetImagenProducto('".$imagen2."')\"><img src=\"".$imagen2."\"></div>
            <div class=\"col-2\" style=\"cursor:pointer\" onclick=\"SetImagenProducto('".$imagen3."')\"><img src=\"".$imagen3."\"></div>
            <div class=\"col-2\" style=\"cursor:pointer\" onclick=\"SetImagenProducto('".$imagen4."')\"><img src=\"".$imagen4."\"></div>
            <div class=\"col-2\" style=\"cursor:pointer\" onclick=\"SetImagenProducto('".$imagen5."')\"><img src=\"".$imagen5."\"></div>
            <div class=\"col-2\" style=\"cursor:pointer\" onclick=\"SetImagenProducto('".$imagen6."')\"><img src=\"".$imagen6."\"></div>
        </div>
        ";

        if( $req->session()->get('cliente_codigo')!='0' && $req->session()->get('cliente_codigo')!='' && $req->session()->get('cliente_codigo')!=null )
        {
            $Salida .="
            <div class=\"downloadFile\">
                <div class=\"downloadFile-inner\">
                    <h2>Documentos</h2>";
                    if ($Productos[$i]->fichatecnica!=null  ){ $Salida .= "<a class=\"text-primary\" href=\"".$Productos[$i]->fichatecnica."\" target=\"_blank\" download><h6> FICHA TÉCNICA</h6></a>"; }
                    if ($Productos[$i]->hojaseguridad!=null ){ $Salida .= "<a class=\"text-primary\" href=\"".$Productos[$i]->hojaseguridad."\" target=\"_blank\" download><h6> HOJA DE SEGURIDAD</h6></a>"; }
                    if ($Productos[$i]->archivoextra!=null  ){ $Salida .= "<a class=\"text-primary\" href=\"".$Productos[$i]->archivoextra."\" target=\"_blank\" download><h6> ".$Productos[$i]->archivoextranombre."</h6></a>"; }
                $Salida .="</div>
            </div>
            ";
        }
        else
        {
            $ContDocumentos = 0;
            if ($Productos[$i]->fichatecnica!=null  ){ $ContDocumentos++; }
            if ($Productos[$i]->hojaseguridad!=null  ){ $ContDocumentos++; }
            if ($Productos[$i]->archivoextra!=null  ){ $ContDocumentos++; }
            $Salida .="
            <div class=\"downloadFile\">
                <div class=\"downloadFile-inner\">
                    <h2>Documentos</h2>
                    <span class=\"iconFile\">
                    <svg width=\"24\" height=\"24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\" class=\"Icon-sc-11g2u8u-0 kxjGOY\" viewBox=\"0 0 24 24\" data-icon-name=\"file24\"><path d=\"M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9l-7-7z\" stroke=\"#000\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"></path><path d=\"M13 2v7h7\" stroke=\"#000\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"></path></svg>
                    </span>
                    <span> ".$ContDocumentos." documentos</span>
                    <p>  Para ver los archivos <a href=\"registro1.html\">regístrate</a>  o  <a href=\"loging.html\">inicia sesión</a> </p>
                </div>
            </div>
            ";
        }

    $Salida .="
    </div>
            <div class=\"col-xl-8 col-md-8 col-sm-12\" style=\" float:left;\">
                <div class=\"row\">
                    <div class=\"col-6\">
                        <h2>".strtoupper($Productos[$i]->descripcion)."</h2>
                        <span class=\"pdpId\">COD: ".$Productos[$i]->codigo."</span>
                        <p>".strtoupper($Productos[$i]->descripcion2)."</p>
                    </div>
                    <div class=\"col-6\">
                        ";
                        if($Productos[$i]->marca_ruta!=null)
                        {
                            $Salida .="<img style=\"width:200px !important;\" src=\"".$Productos[$i]->marca_ruta."\">";
                        }
                        $Salida .="</div>
                </div>
            ";

                $Salida .="<div class=\"row mt-3\">";

                $Caracteristicas = EcoModel::CargarCaracteristicasFamiliaProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $Productos[$i]->fk_familia, $Productos[$i]->id);

                if( count($Caracteristicas)>0 )
                {
                    foreach($Caracteristicas as $lsRow)
                    {
                        if($lsRow->prod_caract!=null) { $checked=' checked '; } else { $checked = ''; }

                        if( $lsRow->caract_tipo_id==1)
                        {
                            $CaractVal = EcoModel::GetCaracteristicasValoresFamiliasProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $lsRow->caract_id, $Productos[$i]->id);
                            if(count($CaractVal)>0){ $Valor = $CaractVal[0]->valor; } else { $Valor=''; }
                            $Salida .="<div
                            style=\"padding: 1px!important; width:30% !important; margin-right:8px !important; font-size:10px !important\"
                            class=\"mt-2 productItem-inner\"
                            role=\"alert\">
                            <span>".$lsRow->caract_nombre."</span>".$Valor."</div>";
                        }
                        else if( $lsRow->caract_tipo_id==2)
                        {
                            $CaractVal = EcoModel::GetCaracteristicasValoresFamiliasProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $lsRow->caract_id, $Productos[$i]->id);
                            if(count($CaractVal)>0){ $Valor = $CaractVal[0]->valor; } else { $Valor=''; }
                            $Salida .="<div
                            style=\"padding: 1px!important; width:30% !important; margin-right:8px !important; font-size:10px !important\"
                            class=\"mt-2 productItem-inner\"
                            role=\"alert\">
                            <span>".$lsRow->caract_nombre."</span>".$Valor."</div>";
                        }
                        else if( $lsRow->caract_tipo_id==3)
                        {
                            $CaractVal = EcoModel::GetCaracteristicasValoresFamiliasProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $lsRow->caract_id, $Productos[$i]->id);
                            if(count($CaractVal)>0){ $Valor = $CaractVal[0]->valor; } else { $Valor=''; }
                            $Salida .="<div
                            style=\"padding: 1px!important; width:30% !important; margin-right:8px !important; font-size:10px !important\"
                            class=\"mt-2 productItem-inner\"
                            role=\"alert\">
                            <span>".$lsRow->caract_nombre."</span>".$Valor."</div>";
                        }
                        else if( $lsRow->caract_tipo_id==5 )
                        {
                            $Opciones = EcoModel::CargarCaracteristicasFamiliaProductosOpciones($DatosGen['NombreEmpresa'][0]->bdbackoffice, $lsRow->caract_id, $Productos[$i]->id);
                            $Salida .="<div
                            style=\"padding: 1px!important; width:30% !important; margin-right:8px !important; font-size:10px !important\"
                            class=\"mt-2 productItem-inner\"
                            role=\"alert\">
                            <span>".$lsRow->caract_nombre."</span>";
                                foreach($Opciones as $lsOpt){
                                    $Salida .=$lsOpt->opcion." - ";
                                }
                            $Salida .="</div>";
                        }
                    }
                }

                $Paises = EcoModel::GetPaisesProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $Productos[$i]->id);
                if( count($Paises)>0 ){
                    $Salida .="<div
                    style=\"padding: 1px!important; width:30% !important; margin-right:8px !important; font-size:10px !important\"
                    class=\"mt-2 productItem-inner\"
                    role=\"alert\">
                    <span>PAISES</span>";
                        foreach($Paises as $lsRow) { $Salida .= $lsRow->nombre." - "; }
                    $Salida .=" </div>";
                }

                $Salida .="<div
                style=\"padding: 1px!important; width:30% !important; margin-right:8px !important; font-size:10px !important\"
                class=\"mt-2 productItem-inner\"
                role=\"alert\">
                <span>MARCA</span>";
                $Salida .= $Productos[$i]->marca_nombre;
                $Salida .=" </div>";

                $Familias = EcoModel::GetSubFamiliasProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $Productos[$i]->id);
                if( count($Familias)>0 ){
                    $Salida .="<div
                    style=\"padding: 1px!important; width:30% !important; margin-right:8px !important; font-size:10px !important\"
                    class=\"mt-2 productItem-inner\"
                    role=\"alert\">
                    <span>FAMILIAS</span>";
                        foreach($Familias as $lsRow) { $Salida .= $lsRow->nombre." - "; }
                    $Salida .="</div>";
                }

                $Proveedores = EcoModel::GetProveedoresProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $Productos[$i]->id);
                if( count($Proveedores)>0 ){
                    $Salida .="<div
                    style=\"padding: 1px!important; width:30% !important; margin-right:8px !important; font-size:10px !important\"
                    class=\"mt-2 productItem-inner\"
                    role=\"alert\">
                    <span>PROVEEDORES</span>";
                        foreach($Proveedores as $lsRow) { $Salida .= $lsRow->nombre." - "; }
                    $Salida .=" </div>";
                }

                $Salida .="</div>";

                $SalidaDocumentos = "";

            $Salida .="
                <button type=\"button\" class=\"btn btn-primar btn-primary-mat btn-primary-matInModal\" onclick=\"AgregarProducto('".$Productos[$i]->id."')\">Solicitar una cotización</button>
</div>
            </div>
</div>
        </div>
        </div>
        <div class=\"row\">
<div class=\"col-xl-12\" style=\"padding-left: 30px; padding-right: 30px; box-sizing: border-box;\">
            <h2>Product Description</h2>
            <p>".nl2br($Productos[$i]->desextra)."...</p>

</div>
        </div>
</div>";
        }
        return $Salida;

    }

    public function getProductosActivos(Request $req) {
        $data = $req->input();
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $Codigo     = $data['Codigo'];
        $Type       = $data['Type'];
        $Order      = $data['Order'];
        $OrderCant  = $data['OrderCant'];
        $Texto      = $data['Texto'];
        $Pais       = $data['Pais'];
        $Imagen = '';

        $Condicion = " prod.estado =true ";

        $FiltroExtra = null;
        $SalidaFiltroExtra = '';
        if( $Type=='banner' )
        {
            if($Condicion != " ") { $Condicion .= " and bann.banner=".$Codigo." "; }
            else { $Condicion .= " bann.banner=".$Codigo." "; }
            $NombreProductos = EcoModel::getNombreBanner($Codigo, $DatosGen['NombreEmpresa'][0]->bdbackoffice);
            if(count($NombreProductos)>0){
                $NombreProductos = $NombreProductos[0]->nombre;
            }
        }
        else if( $Type=='Familia' )
        {
            if($Condicion != " ")
            {
                $Condicion .= " and prod.fk_familia=".$Codigo." ";
            }
            else
            {
                $Condicion .= " prod.fk_familia=".$Codigo." ";
            }
            $NombreProductos = EcoModel::getNombreGrupo($DatosGen['NombreEmpresa'][0]->bd, $Codigo);
            if(count($NombreProductos)>0)
            {
                $NombreProductos = $NombreProductos[0]->nombre;
            }

            $FiltroExtra = EcoModel::CargarCaracteristicasFamilias($DatosGen['NombreEmpresa'][0]->bdbackoffice, $Codigo);
            foreach($FiltroExtra as $lsRow)
            {
                if( $lsRow->es_filtro=='SI')
                {
                    if( $lsRow->tipo==19999)
                    {
                        $Opciones = EcoModel::CargarCaracteristicasFamilia($DatosGen['NombreEmpresa'][0]->bdbackoffice, $lsRow->fk_caracteristica);
                        if(count($CaractVal)>0)
                        {
                            $Valor = $CaractVal[0]->valor;
                        }
                        else
                        {
                            $Valor='';
                        }

                        $SalidaFiltroExtra .="
                        <div class=\"accordion\" id=\"accordionPanelsStayOpenExample\" style=\"margin:0px !important;\">
                            <div class=\"accordion-item\">
                                <h2 class=\"accordion-header\" id=\"panelsStayOpen-headingProveedores\">
                                    <button class=\"accordion-button collapsed\" type=\"button\" data-bs-toggle=\"collapse\"
                                    data-bs-target=\"#panelsStayOpen-collapseProveedores\" aria-expanded=\"false\" aria-controls=\"panelsStayOpen-collapseProveedores\">
                                    ".$lsRow->caract_nombre."
                                    </button>
                                </h2>
                                <div id=\"panelsStayOpen-collapseProveedores\" class=\"accordion-collapse collapse\" aria-labelledby=\"panelsStayOpen-headingProveedores\">
                                    <div class=\"accordion-body\">
                                        ";
                                        foreach ($ProductosProveedores as $lsRow)
                                        {
                                            $SalidaFiltroExtra .="
                                            <label class=\"control control--checkbox\">".$Valor." <input value=\"".$Valor."\" type=\"checkbox\" id=\"ChkProdProveedores[]\" name=\"ChkProdProveedores[]\" >
                                                <div class=\"control__indicator\"></div>
                                            </label>
                                            ";
                                        }
                                    $SalidaFiltroExtra .="
                                    </div>
                                </div>
                            </div>
                        </div>";
                    }
                    else if( $lsRow->tipo==29999)
                    {
                        $Opciones = EcoModel::CargarCaracteristicasFamilia($DatosGen['NombreEmpresa'][0]->bdbackoffice, $lsRow->fk_caracteristica);
                        if(count($CaractVal)>0)
                        {
                            $Valor = $CaractVal[0]->valor;
                        }
                        else
                        {
                            $Valor='';
                        }

                        $SalidaFiltroExtra .="
                        <div class=\"accordion\" id=\"accordionPanelsStayOpenExample\" style=\"margin:0px !important;\">
                            <div class=\"accordion-item\">
                                <h2 class=\"accordion-header\" id=\"panelsStayOpen-headingProveedores\">
                                    <button class=\"accordion-button collapsed\" type=\"button\" data-bs-toggle=\"collapse\"
                                    data-bs-target=\"#panelsStayOpen-collapseProveedores\" aria-expanded=\"false\" aria-controls=\"panelsStayOpen-collapseProveedores\">
                                    ".$lsRow->caract_nombre."
                                    </button>
                                </h2>
                                <div id=\"panelsStayOpen-collapseProveedores\" class=\"accordion-collapse collapse\" aria-labelledby=\"panelsStayOpen-headingProveedores\">
                                    <div class=\"accordion-body\">
                                        ";
                                        foreach ($ProductosProveedores as $lsRow)
                                        {
                                            $SalidaFiltroExtra .="
                                            <label class=\"control control--checkbox\">".$Valor." <input value=\"".$Valor."\" type=\"checkbox\" id=\"ChkProdProveedores[]\" name=\"ChkProdProveedores[]\">
                                                <div class=\"control__indicator\"></div>
                                            </label>
                                            ";
                                        }
                                    $SalidaFiltroExtra .="
                                    </div>
                                </div>
                            </div>
                        </div>";
                    }
                    else if( $lsRow->tipo==39999)
                    {
                        $Opciones = EcoModel::CargarCaracteristicasFamilia($DatosGen['NombreEmpresa'][0]->bdbackoffice, $lsRow->fk_caracteristica);
                        if(count($CaractVal)>0)
                        {
                            $Valor = $CaractVal[0]->valor;
                        }
                        else
                        {
                            $Valor='';
                        }
                        $SalidaFiltroExtra .="
                        <div class=\"accordion\" id=\"accordionPanelsStayOpenExample\" style=\"margin:0px !important;\">
                            <div class=\"accordion-item\">
                                <h2 class=\"accordion-header\" id=\"panelsStayOpen-headingProveedores\">
                                    <button class=\"accordion-button collapsed\" type=\"button\" data-bs-toggle=\"collapse\"
                                    data-bs-target=\"#panelsStayOpen-collapseProveedores\" aria-expanded=\"false\" aria-controls=\"panelsStayOpen-collapseProveedores\">
                                    ".$lsRow->caract_nombre."
                                    </button>
                                </h2>
                                <div id=\"panelsStayOpen-collapseProveedores\" class=\"accordion-collapse collapse\" aria-labelledby=\"panelsStayOpen-headingProveedores\">
                                    <div class=\"accordion-body\">
                                        ";
                                        foreach ($ProductosProveedores as $lsRow)
                                        {
                                            $SalidaFiltroExtra .="
                                            <label class=\"control control--checkbox\">".$Valor." <input value=\"".$Valor."\" type=\"checkbox\" id=\"ChkProdProveedores[]\" name=\"ChkProdProveedores[]\">
                                                <div class=\"control__indicator\"></div>
                                            </label>
                                            ";
                                        }
                                    $SalidaFiltroExtra .="
                                    </div>
                                </div>
                            </div>
                        </div>";
                    }
                    else if( $lsRow->tipo==3 )
                    {
                        $Opciones = EcoModel::CargarCaracteristicasFamiliaOpciones($DatosGen['NombreEmpresa'][0]->bdbackoffice, $lsRow->fk_caracteristica);
                        $SalidaFiltroExtra .="
                        <div class=\"accordion\" id=\"accordionPanelsStayOpenExample\" style=\"margin:0px !important;\">
                            <div class=\"accordion-item\">
                                <h2 class=\"accordion-header\" id=\"panelsStayOpen-heading".$lsRow->fk_caracteristica."\">
                                    <button class=\"accordion-button collapsed\" type=\"button\" data-bs-toggle=\"collapse\"
                                    data-bs-target=\"#panelsStayOpen-collapse".$lsRow->fk_caracteristica."\" aria-expanded=\"false\" aria-controls=\"panelsStayOpen-collapse".$lsRow->fk_caracteristica."\">
                                    ".ucfirst(strtolower($lsRow->caract_nombre))."
                                    </button>
                                </h2>
                                <div id=\"panelsStayOpen-collapse".$lsRow->fk_caracteristica."\" class=\"accordion-collapse collapse\" aria-labelledby=\"panelsStayOpen-heading".$lsRow->fk_caracteristica."\">
                                    <div class=\"accordion-body\">
                                        ";
                                        foreach ($Opciones as $lsOpt)
                                        {
                                            $Selected = '';
                                            if(isset($data['ChkProdCaracOpcion']))
                                            {
                                                for( $i=0; $i<count($data['ChkProdCaracOpcion']); $i++)
                                                {
                                                    if( ($lsRow->fk_caracteristica.".::.".$lsOpt->id)==$data['ChkProdCaracOpcion'][$i] )
                                                    {
                                                        $Selected = ' checked ';
                                                    }
                                                }
                                            }
                                            $SalidaFiltroExtra .="
                                            <label class=\"control control--checkbox\">".$lsOpt->opcion." <input value=\"".$lsRow->fk_caracteristica.".::.".$lsOpt->id."\" type=\"checkbox\" id=\"ChkProdCaracOpcion[]\" name=\"ChkProdCaracOpcion[]\" ".$Selected.">
                                                <div class=\"control__indicator\"></div>
                                            </label>
                                            ";
                                        }
                                    $SalidaFiltroExtra .="
                                    </div>
                                </div>
                            </div>
                        </div>";
                    }
                }
            }

        }
        else if( $Type=='Marca' )
        {
            if($Condicion != " ") { $Condicion .= " and prod.fk_marca=".$Codigo." "; }
            else { $Condicion .= " prod.fk_marca=".$Codigo." "; }
            $NombreProductos = EcoModel::getNombreMarca($DatosGen['NombreEmpresa'][0]->bd, $Codigo);
            if(count($NombreProductos)>0)
            {
                if($NombreProductos[0]->cabecera!=null)
                {
                    $Imagen = $NombreProductos[0]->cabecera;
                }
                $NombreProductos = $NombreProductos[0]->nombre;
            }
        }
        else if( $Type=='Buscador' )
        {
            $Codigo = strtoupper($Codigo);

            if($Condicion != " ")
            {
                $Condicion .= " and ";
            }

            $Condicion .= "
            (
                UPPER(prod.codigo) like UPPER('%".$Codigo."%')
                or UPPER(prod.descripcion) like UPPER('%".$Codigo."%')
                or UPPER(prod.descripcion2) like UPPER('%".$Codigo."%')
                or UPPER(fam.nombre) like UPPER('%".$Codigo."%')
                or UPPER(marc.nombre) like UPPER('%".$Codigo."%')
                or prod.id IN (
                    SELECT
                    tempprod.fk_producto
                    FROM public.productos_caracteristicas as tempprod
                    inner join public.caracteristicas_productos as caract on tempprod.fk_caracteristica=caract.id and tempprod.fk_producto=prod.id
                    left join public.caracteristicas_productos_opciones as opt on caract.id=opt.fk_caracteristica and tempprod.valor=cast(opt.id as varchar)
                    where
                    case
                    when caract.tipo=1 then unaccent(UPPER(cast(tempprod.valor as varchar)))
                    when caract.tipo=2 then unaccent(UPPER(cast(tempprod.valor as varchar)))
                    when caract.tipo=3 then unaccent(UPPER(cast(opt.opcion as varchar)))
                    when caract.tipo=4 then unaccent(UPPER(cast(tempprod.valor as varchar)))
                    end like unaccent(UPPER('%".$Codigo."%'))
                )
            )";

            $NombreProductos = "BUSQUEDA: ".$Codigo;
        }
        else
        {
            $NombreProductos = "BUSQUEDA: ".$Codigo;
        }

        $Descripcion = '';
        if( $Type=='Familia' )
        {
            $AuxInfo = EcoModel::getNombreGrupo($DatosGen['NombreEmpresa'][0]->bd, $Codigo);
            if(count($AuxInfo)>0)
            {
                $Descripcion = $AuxInfo[0]->descripcion;
                if($Imagen=='')
                {
                    $Imagen = $AuxInfo[0]->ruta2;
                }
            }
            else
            {
                if($Imagen=='')
                {
                    $Imagen = 'img/familias/Buscador.jpg';
                }
                $Descripcion = '';
            }
        }
        else
        {
            if($Imagen=='')
            {
                $Imagen = 'img/familias/Buscador.jpg';
            }
            $Descripcion = '';
        }

        $Condicion .= " and prod.id IN ( SELECT TEMPQRY.fk_producto FROM productos_paises AS TEMPQRY WHERE TEMPQRY.fk_producto=prod.id and TEMPQRY.fk_pais=".$Pais." ) ";

        if(isset($data['ChkProdProveedores']))
        {
            if($Condicion == " ") {
                $Condicion .= " prod.id IN ( SELECT * FROM productos_proveedores AS TEMPQRY WHERE TEMPQRY.fk_producto=prod.id and ( ";
                for( $i=0; $i<count($data['ChkProdProveedores']); $i++)
                {
                    if($i==0){
                        $Condicion .= " TEMPQRY.fk_proveedor=".$data['ChkProdProveedores'][$i]." ";
                    }else{
                        $Condicion .= " OR TEMPQRY.fk_proveedor=".$data['ChkProdProveedores'][$i]." ";
                    }
                }
                $Condicion .= " ) )";
            }
            else
            {
                $Condicion .= " and prod.id IN ( SELECT TEMPQRY.fk_producto FROM productos_proveedores AS TEMPQRY WHERE TEMPQRY.fk_producto=prod.id and ( ";
                for( $i=0; $i<count($data['ChkProdProveedores']); $i++)
                {
                    if($i==0){
                        $Condicion .= " TEMPQRY.fk_proveedor=".$data['ChkProdProveedores'][$i]." ";
                    }else{
                        $Condicion .= " OR TEMPQRY.fk_proveedor=".$data['ChkProdProveedores'][$i]." ";
                    }
                }
                $Condicion .= " ) ) ";
            }
        }

        if(isset($data['ChkProdMarcas']))
        {
            if($Condicion == " ") {
                $Condicion .= " prod.id IN ( SELECT TEMPQRY.id FROM productos AS TEMPQRY WHERE TEMPQRY.id=prod.id and ( ";
                for( $i=0; $i<count($data['ChkProdMarcas']); $i++)
                {
                    if($i==0){
                        $Condicion .= " TEMPQRY.fk_marca=".$data['ChkProdMarcas'][$i]." ";
                    }else{
                        $Condicion .= " OR TEMPQRY.fk_marca=".$data['ChkProdMarcas'][$i]." ";
                    }
                }
                $Condicion .= " ) )";
            }
            else
            {
                $Condicion .= " and prod.id IN ( SELECT TEMPQRY.id FROM productos AS TEMPQRY WHERE TEMPQRY.id=prod.id and ( ";
                for( $i=0; $i<count($data['ChkProdMarcas']); $i++)
                {
                    if($i==0){
                        $Condicion .= " TEMPQRY.fk_marca=".$data['ChkProdMarcas'][$i]." ";
                    }else{
                        $Condicion .= " OR TEMPQRY.fk_marca=".$data['ChkProdMarcas'][$i]." ";
                    }
                }
                $Condicion .= " ) ) ";
            }
        }

        if(isset($data['ChkFamilias']))
        {
            if($Condicion == " ") {
                $Condicion .= " prod.id IN ( SELECT * FROM productos_familias AS TEMPQRY WHERE TEMPQRY.fk_producto=prod.id and ( ";
                for( $i=0; $i<count($data['ChkFamilias']); $i++)
                {
                    if($i==0){
                        $Condicion .= " TEMPQRY.fk_familia=".$data['ChkFamilias'][$i]." ";
                    }else{
                        $Condicion .= " OR TEMPQRY.fk_familia=".$data['ChkFamilias'][$i]." ";
                    }
                }
                $Condicion .= " ) )";
            }
            else
            {
                $Condicion .= " and prod.id IN ( SELECT TEMPQRY.fk_producto FROM productos_familias AS TEMPQRY WHERE TEMPQRY.fk_producto=prod.id and ( ";
                for( $i=0; $i<count($data['ChkFamilias']); $i++)
                {
                    if($i==0){
                        $Condicion .= " TEMPQRY.fk_familia=".$data['ChkFamilias'][$i]." ";
                    }else{
                        $Condicion .= " OR TEMPQRY.fk_familia=".$data['ChkFamilias'][$i]." ";
                    }
                }
                $Condicion .= " ) ) ";
            }
        }

        $AuxCondicionCaracOpcion = '';
        if(isset($data['ChkProdCaracOpcion']))
        {
            for( $i=0; $i<count($data['ChkProdCaracOpcion']); $i++)
            {
                $AuxProdCarcOpcion = explode('.::.', $data['ChkProdCaracOpcion'][$i]);

                if($i==0)
                {
                    $AuxCondicionCaracOpcion .= "
                    inner join backoffice_mathiesen.public.productos_caracteristicas as car on car.fk_producto=prod.id and car.fk_caracteristica=".$AuxProdCarcOpcion[0]." and ( car.valor=cast(".$AuxProdCarcOpcion[1]." as varchar)
                    ";
                }
                else
                {
                    $AuxCondicionCaracOpcion .= " or car.valor='".$AuxProdCarcOpcion[1]."' ";
                }

            }

            $AuxCondicionCaracOpcion .= " ) ";
        }

        $Productos = EcoModel::getProductosActivos($Condicion, $DatosGen['NombreEmpresa'][0]->bd, $DatosGen['NombreEmpresa'][0]->bdbackoffice, $AuxCondicionCaracOpcion);

        if($Order==1) {
        usort($Productos,function($value1,$value2){
            return  $value1->descripcion > $value2->descripcion;
        });}
        else if($Order==2) {
            usort($Productos,function($value1,$value2){
                return  $value1->descripcion < $value2->descripcion;
        });}
        else {
        $Order = 1;
        usort($Productos,function($value1,$value2){
            return  $value1->descripcion > $value2->descripcion;
        });}

        $Salida="";

        $TotPaginator = ceil(count($Productos)/$OrderCant);

        $Salida .="
        <nav aria-label=\"breadcrumb\" style=\"margin-left: 28px; margin-top:110px !important\">
            <ol class=\"breadcrumb\">
                <li class=\"breadcrumb-item\"><a href=\"/\">Página de inicio</a></li>
                <li class=\"breadcrumb-item active\" aria-current=\"page\">Página de productos</li>
            </ol>
        </nav>
        <div class=\"bbbootstrap\" style=\"background-position-x: center; background-position-y: center; background-size: contain; background-image: url(".$Imagen.") !important;\">
            <div class=\"bbbootstrap-color\"></div>
            <div class=\"container\">
                <form onSubmit=\"return false;\">
                    <span role=\"status\" aria-live=\"polite\" class=\"ui-helper-hidden-accessible\"></span>
                    <input type=\"text\" id=\"BuscadorCategorias\" name=\"BuscadorCategorias\" value=\"\" placeholder=\"Descubre más productos en nuestro Catálogo\" role=\"searchbox\" class=\"InputBox \" autocomplete=\"off\">
                    <input type=\"submit\" id=\"Form_Go\" class=\"Button\" value=\"Buscar\" onclick=\"CargarProductos('Buscador', $('#BuscadorCategorias').val());\">
                </form>
            </div>
        </div>";

        $Ornenometro1 ="
        <select class=\"border border-default form-sm form-control-sm\" id=\"OrdenoMetro\" name=\"OrdenoMetro\" style=\"background-color: white; padding:0px 0px 0px 5px !important\" onChange=\"CargarProductos('".$Type."','".$Codigo."');\">";
            if( $Order==1) { $Selected = " selected "; }else{ $Selected = " "; }
            $Ornenometro1 .= "<option style=\"display:block;width:100%;\" value=\"1\" ".$Selected.">Nombre A -> Z</option>";
            if( $Order==2) { $Selected = " selected "; }else{ $Selected = " "; }
            $Ornenometro1 .= "<option style=\"display:block;width:100%;\" value=\"2\" ".$Selected.">Nombre Z -> A</option>
        </select>
        ";

        $Ornenometro2 ="
        <select class=\"border border-default form form-control-sm\" id=\"OrdenoMetroCant\" name=\"OrdenoMetroCant\" style=\"background-color: white; padding:0px 0px 0px 5px !important\" onChange=\"CargarProductos('".$Type."','".$Codigo."');\">";
            if( $OrderCant==12) { $Selected = " selected "; }else{ $Selected = " "; }
            $Ornenometro2 .= "<option value=\"12\" ".$Selected.">12</option>";
            if( $OrderCant==24) { $Selected = " selected "; }else{ $Selected = " "; }
            $Ornenometro2 .= "<option value=\"24\" ".$Selected.">24</option>";
            if( $OrderCant==48) { $Selected = " selected "; }else{ $Selected = " "; }
            $Ornenometro2 .= "<option value=\"48\" ".$Selected.">48</option>";
            if( $OrderCant==999999999999999999999999) { $Selected = " selected "; }else{ $Selected = " "; }
            $Ornenometro2 .= "<option value=\"999999999999999999999999\" ".$Selected.">TODOS</option>
        </select>
        ";

        $Salida .="</div>
        <div class=\"container\">
            <div class=\"cat-sumary col-12 mb-3\">
                <h1>".mb_strtoupper($NombreProductos)."</h1>
                ".mb_strtoupper($Descripcion).".</p>
            </div>
        ";

        $Salida .="
        <div class=\"row\">
            <div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxx-4\" >
                <form class=\"row g-3\" method=\"post\" id=\"FormFiltrarGrillaProductos\" enctype=\"multipart/form-data\">
                <input type=\"hidden\" name=\"_token\" value=\"6bfqImq0ntza9OxGugdtJwmNFtk3gfOfIY1Qghty\">
                <input type=\"hidden\" id=\"Codigo\" name=\"Codigo\" value=\"".$data['Codigo']."\" readonly/>
                <input type=\"hidden\" id=\"Order\" name=\"Order\" value=\"".$data['Order']."\" readonly/>
                <input type=\"hidden\" id=\"Type\" name=\"Type\" value=\"".$data['Type']."\" readonly/>
                <input type=\"hidden\" id=\"Texto\" name=\"Texto\" value=\"".$data['Texto']."\" readonly/>
                <input type=\"hidden\" id=\"OrderCant\" name=\"OrderCant\" value=\"".$data['OrderCant']."\" readonly/>
                <div class=\"mt-5 accordion  text-center\" id=\"accordionPanelsStayOpenExample\" style=\"margin-top:10px !important;\">
                    <div class=\"accordion-item\"  style=\"padding:10px !important;\"><h4>Filtro De Productos</h4>
                    </div>
                </div>
                ".$SalidaFiltroExtra;

                                $ProductosProveedores    =   EcoModel::GetProductosProveedores($DatosGen['NombreEmpresa'][0]->bdbackoffice);
                                $ProductosMarcas         =   EcoModel::GetProductosMarcas($DatosGen['NombreEmpresa'][0]->bdbackoffice);
                                $ProductosFamilias       =   EcoModel::GetProductosFamilias($DatosGen['NombreEmpresa'][0]->bdbackoffice);

                                if( count($ProductosProveedores)>0 )
                                {
                                    $Salida .="
                                    <div class=\"accordion\" id=\"accordionPanelsStayOpenExample\" style=\"margin:0px !important;\">
                                        <div class=\"accordion-item\">
                                            <h2 class=\"accordion-header\" id=\"panelsStayOpen-headingProveedores\">
                                                <button class=\"accordion-button collapsed\" type=\"button\" data-bs-toggle=\"collapse\"
                                                data-bs-target=\"#panelsStayOpen-collapseProveedores\" aria-expanded=\"false\" aria-controls=\"panelsStayOpen-collapseProveedores\">
                                                Proveedores
                                                </button>
                                            </h2>
                                            <div id=\"panelsStayOpen-collapseProveedores\" class=\"accordion-collapse collapse\" aria-labelledby=\"panelsStayOpen-headingProveedores\">
                                                <div class=\"accordion-body\">
                                                    ";
                                                    foreach ($ProductosProveedores as $lsRow)
                                                    {
                                                        $Checked = '';
                                                        if(isset($data['ChkProdProveedores']))
                                                        {
                                                            for( $i=0; $i<count($data['ChkProdProveedores']); $i++)
                                                            {
                                                                if( $lsRow->id==$data['ChkProdProveedores'][$i] )
                                                                {
                                                                    $Checked = ' checked ';
                                                                }
                                                            }
                                                        }
                                                        $Salida .="
                                                        <label class=\"control control--checkbox\">".$lsRow->nombre." <input value=\"".$lsRow->id."\" type=\"checkbox\" id=\"ChkProdProveedores[]\" name=\"ChkProdProveedores[]\" ".$Checked.">
                                                            <div class=\"control__indicator\"></div>
                                                        </label>
                                                        ";
                                                    }
                                                $Salida .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                                }

                                if( count($ProductosMarcas)>0 ){
                                    $Salida .="
                                    <div class=\"accordion\" id=\"accordionPanelsStayOpenExample\" style=\"margin:0px !important;\">
                                        <div class=\"accordion-item\">
                                            <h2 class=\"accordion-header\" id=\"panelsStayOpen-headingMarcas\">
                                                <button class=\"accordion-button collapsed\" type=\"button\" data-bs-toggle=\"collapse\"
                                                data-bs-target=\"#panelsStayOpen-collapseMarcas\" aria-expanded=\"false\" aria-controls=\"panelsStayOpen-collapseMarcas\">
                                                Marcas
                                                </button>
                                            </h2>
                                            <div id=\"panelsStayOpen-collapseMarcas\" class=\"accordion-collapse collapse\" aria-labelledby=\"panelsStayOpen-headingMarcas\">
                                                <div class=\"accordion-body\">
                                                    ";
                                                    foreach ($ProductosMarcas as $lsRow)
                                                    {
                                                        $Checked = '';
                                                        if(isset($data['ChkProdMarcas']))
                                                        {
                                                            for( $i=0; $i<count($data['ChkProdMarcas']); $i++)
                                                            {
                                                                if( $lsRow->id==$data['ChkProdMarcas'][$i] )
                                                                {
                                                                    $Checked = ' checked ';
                                                                }
                                                            }
                                                        }
                                                        $Salida .="
                                                        <label class=\"control control--checkbox\">".$lsRow->nombre." <input value=\"".$lsRow->id."\" type=\"checkbox\" id=\"ChkProdMarcas[]\" name=\"ChkProdMarcas[]\" ".$Checked.">
                                                            <div class=\"control__indicator\"></div>
                                                        </label>
                                                        ";
                                                    }
                                                $Salida .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                                }

                                if( count($ProductosFamilias)>0 ){
                                    $Salida .="
                                    <div class=\"accordion\" id=\"accordionPanelsStayOpenExample\" style=\"margin:0px !important;\">
                                        <div class=\"accordion-item\">
                                            <h2 class=\"accordion-header\" id=\"panelsStayOpen-headingFamilias\">
                                                <button class=\"accordion-button collapsed\" type=\"button\" data-bs-toggle=\"collapse\"
                                                data-bs-target=\"#panelsStayOpen-collapseFamilias\" aria-expanded=\"false\" aria-controls=\"panelsStayOpen-collapseFamilias\">
                                                Familias
                                                </button>
                                            </h2>
                                            <div id=\"panelsStayOpen-collapseFamilias\" class=\"accordion-collapse collapse\" aria-labelledby=\"panelsStayOpen-headingFamilias\">
                                                <div class=\"accordion-body\">
                                                    ";
                                                    foreach ($ProductosFamilias as $lsRow)
                                                    {
                                                        $Checked = '';
                                                        if(isset($data['ChkFamilias']))
                                                        {
                                                            for( $i=0; $i<count($data['ChkFamilias']); $i++)
                                                            {
                                                                if( $lsRow->id==$data['ChkFamilias'][$i] )
                                                                {
                                                                    $Checked = ' checked ';
                                                                }
                                                            }
                                                        }
                                                        $Salida .="
                                                        <label class=\"control control--checkbox\">".$lsRow->nombre." <input value=\"".$lsRow->id."\" type=\"checkbox\" id=\"ChkFamilias[]\" name=\"ChkFamilias[]\" ".$Checked.">
                                                            <div class=\"control__indicator\"></div>
                                                        </label>
                                                        ";
                                                    }
                                                $Salida .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                                }

                                $Salida .="
                                <div class=\"accordion  text-center\" id=\"accordionPanelsStayOpenExample\" style=\"margin:0px !important; padding-bottom:10px !important;\">
                                    <div class=\"accordion-item mb-10\" style=\"padding-bottom:10px !important;\">
                                        <button style=\"font-size: 20px; padding: 8px 10px; border-radius: 6px;\" type=\"button\" class=\"mt-3 btn btn-primary btn-lg\" onclick=\"LoadFiltrarGrillaProductos();\">FILTRAR</button>
                                        <br>
                                    </div>
                                </div>
            </form>
            </div>
            <div class=\"col-md-8\">
                <nav aria-label=\"Page navigation example\">
                    <ul class=\"pagination\">
                        ";
                        for($i=1; $i<=$TotPaginator; $i++){
                            if($i==1){ $Active = ' active '; } else { $Active = '';}
                            $Salida .= "<li id=\"page-item-btn-".$i."_1\" class=\"page-item-btn page-item ".$Active."\" onclick=\"CargarPaginator(".$i.");\" style=\"cursor:pointer;\">
                            <a class=\"page-link\" href=\"#top\">".$i."</a>
                            </li>";
                        }
                    $Salida .="
                    </ul>
                </nav>
                <div class=\"row topFilter\">
                    <div class=\"col-sm-6 col-md-6 col-lg-8 col-xl-8  position-relative numberItem\">".count($Productos)." productos encontrados.</div>
                    <div class=\"col-sm-3 col-md-3 col-lg-2 col-xl-2  position-relative\">
                    ".$Ornenometro1."
                    </div>
                    <div class=\" col-sm-3 col-md-3 col-lg-2 col-xl-2  position-relative\">
                    ".$Ornenometro2."
                    </div>
                </div>
        ";

        if(count($Productos)>0)
        {

            $PageId = 0;
            for($i=0; $i<count($Productos); $i++)
            {

                $Imagen = '';
                if($i%2==0){
                    $Imagen = 'producto_sample_001.jpg';
                }else{
                    $Imagen = 'producto_sample_002.jpg';
                }

                if( ($i+1)==1 ){
                    $PageId++;
                    $Salida .= "<div class=\"col-12 page-id-ordenometro row\" id=\"page-id-".$PageId."\" style=\"display:block;\">";
                }else if( $i%$OrderCant==0 ){
                    $PageId++;
                    $Salida .= "</div><div class=\"col-12 page-id-ordenometro row\" id=\"page-id-".$PageId."\" style=\"display:none;\">";
                }

                if($Productos[$i]->imagen1!=null && file_exists('../public/'.$Productos[$i]->imagen1)){
                    $imagen = ''.$Productos[$i]->imagen1.'?'.date("YmdHms");
                }else{
                    $imagen = 'img/productos/SinImagen.jpg?'.date("YmdHms");
                }

                $BackGround = '';
                if (str_contains($Productos[$i]->descripcion, '01-')) {
                    $BackGround = ' background-color: #BBDEFB; color:black;';
                }else{
                    $BackGround = ' background-color: #1976D2; color:white;';
                }


                $Salida .= "
                <div class=\"cont-product-cardInfo mb-3\">
                <div class=\"data-info\">
                    <div class=\"imgPlp\">
                        <img src=\"".$imagen."\">
                    </div>
                    <div class=\"cont-textInfo\">
                        <span class=\"pdpCat\">".$NombreProductos."</span>
                        <h2>".$Productos[$i]->descripcion."</h2>
                        <span class=\"idPlp\">COD: ".$Productos[$i]->id." -- ".$Productos[$i]->codigo."</span>
                        <div class=\"descriptionPlp\">".substr(nl2br($Productos[$i]->desextra),0,250)."...</div>
                    </div>
                </div>";

                    $Salida .="
                    <div class=\"row \">
                        <div class=\"col-12 row\" style=\"display: flex !important;\">";

                    $Caracteristicas = EcoModel::CargarCaracteristicasFamiliaProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $Productos[$i]->fk_familia, $Productos[$i]->id);

                    if( count($Caracteristicas)>0 )
                    {
                        foreach($Caracteristicas as $lsRow)
                        {
                            if($lsRow->prod_caract!=null) { $checked=' checked '; } else { $checked = ''; }

                            if( $lsRow->caract_tipo_id==1)
                            {
                                $CaractVal = EcoModel::GetCaracteristicasValoresFamiliasProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $lsRow->caract_id, $Productos[$i]->id);
                                if(count($CaractVal)>0){ $Valor = $CaractVal[0]->valor; } else { $Valor=''; }
                                $Salida .="<div class=\"col-3 productItem\"><div class=\"productItem-inner\"><span>".strtoupper($lsRow->caract_nombre)."</span> ".$Valor."</div></div>";
                            }
                            else if( $lsRow->caract_tipo_id==2)
                            {
                                $CaractVal = EcoModel::GetCaracteristicasValoresFamiliasProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $lsRow->caract_id, $Productos[$i]->id);
                                if(count($CaractVal)>0){ $Valor = $CaractVal[0]->valor; } else { $Valor=''; }
                                $Salida .="<div class=\"col-3 productItem\"><div class=\"productItem-inner\"><span>".strtoupper($lsRow->caract_nombre)."</span> ".$Valor."</div></div>";
                            }
                            else if( $lsRow->caract_tipo_id==4)
                            {
                                $CaractVal = EcoModel::GetCaracteristicasValoresFamiliasProducto($DatosGen['NombreEmpresa'][0]->bdbackoffice, $lsRow->caract_id, $Productos[$i]->id);
                                if(count($CaractVal)>0){ $Valor = $CaractVal[0]->valor; } else { $Valor=''; }
                                $Salida .="<div class=\"col-3 productItem\"><div class=\"productItem-inner\"><span>".strtoupper($lsRow->caract_nombre)."</span> ".$Valor."</div></div>";

                            }
                            else if( $lsRow->caract_tipo_id==3 )
                            {
                                $Opciones = EcoModel::CargarCaracteristicasFamiliaProductosOpciones($DatosGen['NombreEmpresa'][0]->bdbackoffice, $lsRow->caract_id, $Productos[$i]->id);
                                $Salida .="<div class=\"col-3 productItem\"><div class=\"productItem-inner\"><span>".strtoupper($lsRow->caract_nombre)."</span> ";
                                foreach($Opciones as $lsOpt){
                                    $Salida .=$lsOpt->opcion." - ";
                                }
                                $Salida .="</div></div>";
                            }

                        }
                    }

                    $Salida .="
                    </div>
                    <div class=\"row text-rigth\">
                        <div class=\"col-4\"><button type=\"button\" class=\"btn btn-primar btn-primary-mat\" onclick=\"AgregarProducto('".$Productos[$i]->id."')\">Solicitar una cotización</button></div>
                        <div class=\"col-4\"><button type=\"button\" class=\"btn btn-primary soft-button\" onclick=\"CargarModalProducto('".$Productos[$i]->codigo."');\">Ver Más</button></div>
                    </div>
                    ";

                $Salida .="
                </div>
                </div>
                ";
            }
            $Salida .="</div></div>";

        }
        else
        {
            $Salida .="<div class=\"container\" style=\"height:800px!important\"><div class=\"alert alert-danger mt-5\" role=\"alert\"><h2 class=\"text-danger\">NO SE ENCONTRARON PRODUCTOS</h2></div></div>";
        }

        return "</div>".$Salida;
    }

    public function SetClienteActivo(Request $req) { if( !$req->session()->get('nombre') || !$req->session()->get('fk_rol') ) { $req->session()->flush();  return redirect('login'); } else {
        $data = $req->input();
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);
        $req->session()->put('cliente_codigo',  $data['cliente']);
        return "OK";
    }}

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
        $formateado = "$".strrev($tmp);
        return $formateado;
    }

    public function carrito(Request $req) {
        $data = $req->input();
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $Salida = '';
        if( $req->session()->get('cliente_codigo')!='0' ){

            $Salida = '';
            $Pedido = EcoModel::getPedidoTemporal($req->session()->get('cliente_codigo'), $DatosGen['NombreEmpresa'][0]->bdbackoffice);
            if( count($Pedido)>0 ) {
                $Pedido = $Pedido[0]->id;
            }else{
                $Pedido = -1;
            }

            $Productos = EcoModel::getDetalleBolsa($Pedido, $DatosGen['NombreEmpresa'][0]->bdbackoffice);

            if(count($Productos)>0){
            $Salida .="
        <nav aria-label=\"breadcrumb\" style=\"margin-left: 28px;\">
        <ol class=\"breadcrumb\">
            <li class=\"breadcrumb-item\"><a href=\"/\">Página de inicio</a></li>
            <li class=\"breadcrumb-item active\" aria-current=\"page\">Página de cotizador</li>
        </ol>
        </nav>
        <div class=\"container-flow fullBanner-sm  \"  style=\"background-image: url('img/cotizador.png'); background-repeat: no-repeat; background-size: cover; background-position:top center\" >
        <!--<img src=\"images/contacto.png\" alt=\"...\"/>-->
        </div>
            <div class=\"container contContact\" style=\"position:relative; top:-100px\">
                <div class=\"row\" id=\"DivContenidoCotizacion\">
                    <div class=\"col-lg-12\">
                        <ul class=\" rounded-0\">";
                        $Salida .= "
                        <div class=\"section-title text-center mt-30 mb-15\">
                            <h2 class=\"title text-dark text-capitalize\">Información De Productos</h2>
                        </div>
                        ";

                        $SubTotal = 0;
                        for($i=0; $i<count($Productos); $i++){

                            if(file_exists('../public/'.$Productos[$i]->imagen1)){
                                $imagen = '../'.$Productos[$i]->imagen1.'?'.date("YmdHms");
                            }else{
                                $imagen = '../img/productos/SinImagen.jpg?'.date("YmdHms");
                            }

                            $Salida .= "
                            <div class=\"card mb-3\">
                                <div class=\"card-body row\">
                                    <div
                                    class=\"col-3 mr-0 ml-0 p-0 my-auto\"
                                    style=\"
                                    height:200px !important;
                                    background-image: url('".$imagen."?".rand(5, 15)."');
                                    background-size: contain;
                                    background-repeat: no-repeat;
                                    background-position: center center;
                                    cursor:pointer;
                                    \"></div>
                                    <div class=\"col-3 mr-0 ml-0 p-0 my-auto\">
                                        <div class=\"text-dark\"><strong>COD: ".$Productos[$i]->codigo."</strong></div>
                                        <div class=\"text-dark\">".$Productos[$i]->descripcion."</div>
                                        <button type=\"button\"  style=\"margin-top: -10px;\" class=\"mt-5 btn btn-primar btn-primary-mat\" onclick=\"QuitarLinea(".$Productos[$i]->id.")\">QUITAR</button>
                                    </div>
                                    <div class=\"col-3 mr-0 ml-0 p-0 my-auto\">
                                        <h5 class=\"card-title font-weight-bold text-dark mb-2\">DOCUMENTOS</h5>";
                                        if ($Productos[$i]->fichatecnica!=null ){ $Salida .= "<a class=\"text-primary\" href=\"".$Productos[$i]->fichatecnica."\" target=\"_blank\" download><h6>FICHA TÉCNICAInformación De Productos</h6></a>"; }
                                        if ($Productos[$i]->fichatecnica!=null ){ $Salida .= "<a class=\"text-primary\" href=\"".$Productos[$i]->hojaseguridad."\" target=\"_blank\" download><h6>HOJA DE SEGURIDAD</h6></a>"; }
                                    $Salida .="</div>
                                </div>
                            </div>
                            ";
                        }

                        $Salida .="
                        </ul>
                        <button style=\"font-size: 20px; padding: 8px 10px; border-radius: 6px;\" type=\"button\" class=\"mb-5 col-12 mt-3 mb-5 btn btn-primar btn-primary-mat\" onclick=\"RealizarPago()\">
                        SOLICITAR COTIZACIÓN
                        </button>
                    </div>
                </div>
                </div>
                ";
                }else{
                    $Salida .="
                    <nav aria-label=\"breadcrumb\" style=\"margin-left: 28px; margin-top: 110px !important;\">
                    <ol class=\"breadcrumb\">
                        <li class=\"breadcrumb-item\"><a href=\"/\">Página de inicio</a></li>
                        <li class=\"breadcrumb-item active\" aria-current=\"page\">Página de cotizador</li>
                    </ol>
                    </nav>
                    <div class=\"container\"><div class=\"alert alert-danger mt-5\" role=\"alert\"><h6 class=\"text-danger\">SIN PRODUCTOS AGREGADOS</h6></div></div>";
                }

        }

        if( $data['tipo']=='Feria'){

            $Codigo = '';
            $Order = '';
            $Type = '';
            $Texto = '';
            $OrderCant = '';

            return view('eco_carritoFeria.index', [
                'DatosGen'      => $DatosGen
                , 'Salida'      => $Salida
                , 'Codigo'  => $Codigo
                , 'Order'   => $Order
                , 'Type'    => $Type
                , 'Texto'   => $Texto
                , 'OrderCant'   => $OrderCant
            ]);
        }else{
            return view('eco_carrito.index', [
                'DatosGen'      => $DatosGen
                , 'Salida'      => $Salida
            ]);
        }
    }

    public function CerrarFeria(Request $req) {
        $data = $req->input();
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $Codigo = '';
        $Order = '';
        $Type = '';
        $Texto = '';
        $OrderCant = '';
        return view('eco_categoryFeria.CerrarFeria', [
            'DatosGen'  => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Codigo'  => $Codigo
            , 'Order'   => $Order
            , 'Type'    => $Type
            , 'Texto'   => $Texto
            , 'OrderCant'   => $OrderCant
        ]);
    }

    public function categoryFeria(Request $req) {
        $data = $req->input();
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        $Codigo = $_GET['id'];
        $Order = $_GET['Order'];
        $Type = $_GET['Type'];
        $Texto = '';
        $OrderCant = $_GET['OrderCant'];

        return view('eco_categoryFeria.index', [
            'DatosGen'  => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Codigo'  => $Codigo
            , 'Order'   => $Order
            , 'Type'    => $Type
            , 'Texto'   => $Texto
            , 'OrderCant'   => $OrderCant
        ]);
    }

    public function category(Request $req) {

        $data = $req->input();
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        if( isset($data['id']) ) { $Codigo = $data['id']; }
        else{ $Codigo = 'ACC'; }

        if( isset($data['Order']) ) { $Order = $data['Order']; }
        else{ $Order = 1; }

        if( isset($data['Type']) ) { $Type = $data['Type']; }
        else{ $Type = 'Asc'; }

        if( isset($data['texto']) ) { $Texto = $data['texto']; }
        else{ $Texto = ''; }

        if( isset($data['OrderCant']) ) { $OrderCant = $data['OrderCant']; }
        else{ $OrderCant = 12; }

        return view('eco_category.index', [
            'DatosGen'  => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Codigo'  => $Codigo
            , 'Order'   => $Order
            , 'Type'    => $Type
            , 'Texto'   => $Texto
            , 'OrderCant'   => $OrderCant
            , 'Paises'      => EcoModel::GetProductosPaises($DatosGen['NombreEmpresa'][0]->bdbackoffice)
            , 'Proveedores' => EcoModel::GetProductosProveedores($DatosGen['NombreEmpresa'][0]->bdbackoffice)
            , 'Marcas'      => EcoModel::GetProductosMarcas($DatosGen['NombreEmpresa'][0]->bdbackoffice)
            , 'Familias'    => EcoModel::GetProductosFamilias($DatosGen['NombreEmpresa'][0]->bdbackoffice)
            , 'Pais'        => GeneralModel::GetUnPais($DatosGen['NombreEmpresa'][0]->bdbackoffice, $data['Pais']) 
        ]);
    }

    public function contacto(Request $req) { if( !$req->session()->get('nombre') || !$req->session()->get('fk_rol') ) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        return view('eco_contacto.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
        ]);
    }}

    public function servicios(Request $req) { if( !$req->session()->get('nombre') || !$req->session()->get('fk_rol') ) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        return view('eco_servicios.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
        ]);
    }}

    public function sobreempresa(Request $req) { if( !$req->session()->get('nombre') || !$req->session()->get('fk_rol') ) { $req->session()->flush();  return redirect('login'); } else {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        return view('eco_sobreempresa.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
        ]);
    }}

    public function index(Request $req) {

        /*
        $AllUsuarios = MantUsuarios::GetListUsuariosClientes();

        foreach($AllUsuarios as $lsRow){

            $DataModel = [
                'contrasenia' =>  md5(substr($lsRow->usuario, 0, 4))
            ];
            MantUsuarios::UpdateUsuariosContrasenasClientes($DataModel, $lsRow->id);

            $DataModel = [
                'fk_cliente'       => $lsRow->usuario,
                'fk_usuario'       => $lsRow->id,
            ];
            MantClientes::GuardarRelacionUsuario($DataModel);
        }
        */
        return view('eco_index.index', [
            'DatosGen' => app('App\Http\Controllers\Home_Controller')->DatosGen($req)
            , 'Session'     => $req->session()
        ]);
    }
}

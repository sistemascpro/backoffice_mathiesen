<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class EcoModel extends Model
{ 
    public static function CargarCaracteristicasFamilias($BDBACK, $id)
    {
        return DB::select("
        SELECT 
        cfam.id
        , cfam.fk_caracteristica
        , cfam.fk_familia
        , ISNULL(cfam.es_filtro,'NO') as es_filtro
        , tip.nombre as caract_tipo
        , carac.nombre as caract_nombre
        , cfam.valor
        , carac.tipo
        FROM ".$BDBACK.".dbo.familias_caracteristicas as cfam 
        inner join ".$BDBACK.".dbo.caracteristicas_productos as carac on cfam.fk_caracteristica=carac.id 
        inner join ".$BDBACK.".dbo.caracteristicas_productos_tipos as tip on carac.tipo=tip.id
        where 
        cfam.estado=1
        and cfam.fk_familia=".$id."
        ");
    }

    public static function GetProductosFamilias($BDBACK)
    {
        return DB::select("
        SELECT 
        id
        , UPPER(nombre) as nombre
        FROM ".$BDBACK.".dbo.familias
        where
        estado=1
        ");
    }

    public static function GetProductosMarcas($BDBACK)
    {
        return DB::select("
        SELECT 
        id
        , UPPER(nombre) as nombre
        FROM ".$BDBACK.".dbo.marcas
        where
        estado=1
        ");
    }

    public static function GetProductosProveedores($BDBACK)
    {
        return DB::select("
        SELECT 
        id
        , UPPER(nombre) as nombre
        FROM ".$BDBACK.".dbo.proveedores
        where
        estado=1
        ");
    }

    public static function GetProductosPaises($BDBACK)
    {
        return DB::select("
        SELECT 
        id
        , UPPER(nombre) as nombre
        FROM ".$BDBACK.".dbo.paises
        where
        estado=1
        ");
    }

    public static function GetProveedoresProducto($BDBACK, $fk_producto)
    {
        return DB::select("
        SELECT 
        UPPER(prov.nombre) as nombre
        FROM ".$BDBACK.".dbo.productos_proveedores as prodprov
        INNER join ".$BDBACK.".dbo.proveedores as prov on prodprov.fk_proveedor=prov.id
        where
        prodprov.fk_producto=".$fk_producto."
        ");
    }

    public static function GetSubFamiliasProducto($BDBACK, $fk_producto)
    {
        return DB::select("
        SELECT 
        UPPER(fam.nombre) as nombre
        FROM ".$BDBACK.".dbo.productos_familias as prodfam
        INNER join ".$BDBACK.".dbo.familias as fam on prodfam.fk_familia=fam.id
        where
        prodfam.fk_producto=".$fk_producto."
        ");
    }

    public static function GetPaisesProducto($BDBACK, $fk_producto)
    {
        return DB::select("
        SELECT 
        UPPER(pais.nombre) as nombre
        FROM ".$BDBACK.".dbo.productos_paises as prodpais
        INNER join ".$BDBACK.".dbo.paises as pais on prodpais.fk_pais=pais.id
        where
        prodpais.fk_producto=".$fk_producto."
        ");
    }

    public static function CargarCaracteristicasFamiliaOpciones($BDBACK, $id)
    {
        return DB::select("
        SELECT 
        caract.id
        , caract.opcion
        , caract.estado
        , caract.fk_caracteristica
        FROM ".$BDBACK.".dbo.caracteristicas_productos_opciones as caract
        where
        caract.fk_caracteristica=".$id."
        and caract.estado=1
        ");
    }

    public static function CargarCaracteristicasFamiliaProductosOpciones($BDBACK, $id, $fk_producto)
    {
        return DB::select("
        SELECT 
        caract.id
        , caract.opcion
        , caract.estado
        , caract.fk_caracteristica
        , prod.fk_producto 
        FROM ".$BDBACK.".dbo.caracteristicas_productos_opciones as caract
        INNER join ".$BDBACK.".dbo.productos_caracteristicas as prod on caract.fk_caracteristica=prod.fk_caracteristica and caract.id=prod.valor and prod.fk_producto=".$fk_producto."
        where
        caract.fk_caracteristica=".$id."
        and caract.estado=1
        ");
    }

    public static function CargarCaracteristicasFamilia($BDBACK, $id)
    {
        return DB::select("
        SELECT 
        id
        ,fk_caracteristica
        ,valor
        ,estado
        ,fk_producto
        FROM ".$BDBACK.".dbo.productos_caracteristicas
        where
        fk_caracteristica=".$id."
        ");
    }


    public static function GetCaracteristicasValoresFamiliasProducto($BDBACK, $fk_caracteristica, $fk_producto)
    {
        return DB::select("
        SELECT 
        id
        ,fk_caracteristica
        ,valor
        ,estado
        ,fk_producto
        FROM ".$BDBACK.".dbo.productos_caracteristicas
        where
        fk_producto=".$fk_producto."
        and fk_caracteristica=".$fk_caracteristica."
        ");
    }

    public static function CargarCaracteristicasFamiliaProducto($BDBACK, $id, $fk_producto)
    {
        return DB::select("
        SELECT 
        cfam.id
        , cfam.fk_caracteristica
        , cfam.fk_familia
        , tip.id as caract_tipo_id
        , tip.nombre as caract_tipo
        , carac.nombre as caract_nombre
        , carac.libre
        , carac.id as caract_id
        , cfam.valor
        , prod.fk_caracteristica as prod_caract
        FROM ".$BDBACK.".dbo.familias_caracteristicas as cfam 
        inner join ".$BDBACK.".dbo.caracteristicas_productos as carac on cfam.fk_caracteristica=carac.id 
        inner join ".$BDBACK.".dbo.caracteristicas_productos_tipos as tip on carac.tipo=tip.id
        inner join ".$BDBACK.".dbo.productos_caracteristicas as prod on cfam.fk_caracteristica=prod.fk_caracteristica and prod.fk_producto=".$fk_producto."
        where 
        cfam.estado=1
        and cfam.fk_familia=".$id."
        group by 
        cfam.id
        , cfam.fk_caracteristica
        , cfam.fk_familia
        , tip.id
        , tip.nombre
        , carac.nombre
        , carac.libre
        , carac.id
        , cfam.valor
        , prod.fk_caracteristica
        ");
    }

    public static function GetProductosCaracteristicas($BD, $id)
    {
        return DB::select("
        SELECT 
        cara.id as cara_id
        ,cara.nombre as cara_nombre
        ,cara.codigo as cara_codigo
        , isnull(prod.valor,'') as valor
        FROM 
        ".$BD.".dbo.caracteristicas_productos as cara 
        inner join ".$BD.".dbo.prods_carcs as prod on prod.fk_caracteristica=cara.id and prod.fk_producto=".$id."
        ");
    }

    public static function UpdatePedidoSoftland($DataModel, $Pedido)
    {
        return DB::connection('sqlsrv')->table('pedido_softland')->where('fk_pedido', $Pedido)->update($DataModel);
    }

    public static function GetSinCorreo($BD, $BDBACK)
    {
        return DB::select("
        select 
        soft.fk_pedido
        from ".$BD.".softland.nw_nventa as nvta
        inner join ".$BDBACK.".dbo.pedido_softland as soft on nvta.Patente=CAST(soft.fk_pedido as VARCHAR) and soft.correo='NO'
        where
        nvFeAprob between DATEADD(minute, -60, GETDATE()) and DATEADD(minute, -30, GETDATE())
        order by nvFem desc
        ");
    }

    public static function getClienteCobrador($BD, $Cliente)
    {
        return DB::select("
        SELECT 
        CLI.CodCob 
        FROM ".$BD.".softland.cwtcvcl AS CLI 
        WHERE CLI.codigo='".$Cliente."' AND CLI.CodCob=2
        ");
    }

    public static function UpdateProductoTerminado($DataModel, $id)
    {
        return DB::connection('sqlsrv')->table('pedido_producto')->where('fk_pedido', $id)->where('estado_valido', 'SI')->update($DataModel);
    }

    public static function InserPedidoSoftland($DataModel)
    {
        return DB::connection('sqlsrv')->table('pedido_softland')->insertGetId($DataModel);
    }
        
    public static function getDetalleBolsaGroupCodProd($Pedido, $Bodega, $BDBACK)
    {
        

        return DB::select("
        SELECT 
        temp1.codigo
        , temp1.imagen1
        , temp1.imagen2
        , temp1.imagen3
        , temp1.imagen4
        , temp1.imagen5
        , temp1.imagen6
        , temp1.descripcion
        FROM ".$BDBACK.".dbo.pedido_producto as temp1
        inner join ".$BDBACK.".dbo.GetProductosActivos as prod on temp1.id collate database_default = prod.id collate database_default
        where
        temp1.estado_valido='SI'
        and temp1.estado_terminado='NO'
        and temp1.fk_pedido='".$Pedido."'
        group by 
        temp1.id
        , temp1.descripcion
        ");
    }

    public static function getLimitesDespachos($BDBACK){
        return DB::select("
        SELECT 
        *
        FROM ".$BDBACK.".dbo.limites_despachos
        where
        id=1
        ");
    }

    public static function getPedidoTotales($BD, $Id, $BDBACK){
        return DB::select("
        SELECT 
        cab.id
        , ISNULL(dir.RegionDch,0) as region
        , ISNULL(descu.valor,0) as descuento
        , ISNULL(SUM(prod.cant_venta*prod.precio_venta),0) as total
        FROM ".$BDBACK.".dbo.pedido_cabecera as cab
        left join ".$BDBACK.".dbo.codigosdescuentos as descu on cab.codigo_descuento=descu.id
        left join ".$BDBACK.".dbo.pedido_producto as prod on cab.id=prod.fk_pedido and prod.estado_valido='SI' and prod.estado_terminado='NO'
        left join ".$BD.".softland.cwtauxd as dir on dir.NomDch collate database_default = cab.despacho_id collate database_default and dir.CodAxD collate database_default = cab.cliente_id collate database_default
        where
        cab.id=".$Id."
        group by 
        cab.id
        , descu.valor
        , ISNULL(dir.RegionDch,0)
        ");
    }

    public static function GetDireccionCliente($BD, $Cliente, $Codigo){
        return DB::select("
        SELECT
        ISNULL(comu.ComDes,'') AS Comuna
        , ISNULL(reg.Descripcion,'') as Region
        FROM
        ".$BD.".softland.cwtauxd AS A
        left join ".$BD.".softland.cwtcomu as comu on A.ComDch=comu.ComCod
        left join ".$BD.".softland.cwtregion as reg on A.RegionDch=reg.id_Region
        WHERE
        A.CodAxD='".$Cliente."'
        and A.NomDch='".$Codigo."'
        ");
    }

    public static function getValorDescuento($Id, $BDBACK){
        return DB::select("
        SELECT
        *
        FROM ".$BDBACK.".dbo.codigosdescuentos as temp1
        where
        temp1.id=".$Id."
        ");
    }

    public static function UpdateCodigoDescuento($DataModel, $id)
    {
        return DB::connection('sqlsrv')->table('codigosdescuentos_detalles')->where('id', $id)->update($DataModel);
    }

    public static function UpdatePedido($DataModel, $id)
    {
        return DB::connection('sqlsrv')->table('pedido_cabecera')->where('id', $id)->update($DataModel);
    }

    public static function ValidarCodigoDescuento($Codigo, $Cliente, $BDBACK){
        return DB::select("
        SELECT
        temp1.id AS id_codigo
        ,temp1.codigo
        ,temp1.descripcion
        ,temp1.valor
        ,temp1.fecha1
        ,temp1.fecha2
        ,temp2.id AS id_cliente
        ,temp2.fk_cliente
        ,temp2.usado
        FROM ".$BDBACK.".dbo.codigosdescuentos as temp1
        inner join ".$BDBACK.".dbo.codigosdescuentos_detalles as temp2 on temp1.id=temp2.fk_codigo
        where
        temp1.codigo='".$Codigo."'
        and temp2.fk_cliente='".$Cliente."'
        and CONVERT(DATE, GETDATE(),103) BETWEEN CONVERT(DATE, temp1.fecha1,103) and CONVERT(DATE, temp1.fecha2,103)
        and RTRIM(LTRIM(temp2.usado))='NO'
        ");
    }

    public static function GetDireccionesCliente($BD, $Cliente){
        return DB::select("
        SELECT
        A.NomDch
        , A.DirDch
        , ISNULL(comu.ComDes,'') AS Comuna
        , ISNULL(reg.Descripcion,'') as Region
        FROM
        ".$BD.".softland.cwtauxd AS A
        left join ".$BD.".softland.cwtcomu as comu on A.ComDch=comu.ComCod
        left join ".$BD.".softland.cwtregion as reg on A.RegionDch=reg.id_Region
        WHERE
        A.CodAxD='".$Cliente."'
        ");
    }
    public static function existeRegalo($id, $BDBACK)
    {
        return DB::select("
        SELECT
        *
        FROM ".$BDBACK.".dbo.pedido_producto
        where
        padre_id=".$id."
        ");
    }

    public static function getInfoClienteCotizacion($BD, $Codigo)
    {
        return DB::select("
        SELECT 
        *
        FROM
        ".$BD.".dbo.usuarios
        WHERE
        id=".$Codigo."
        ");
    }

    public static function GetInfoCliente($BD, $Codigo)
    {
        return DB::select("
        SELECT 
        *
        FROM
        ".$BD.".dbo.clientes
        WHERE
        codigo='".$Codigo."'
        ");
    }

    public static function getNombreBanner($Codigo, $BDBACK)
    {
        return DB::select("
        SELECT 
        id
        , nombre
        , ruta
        , posicion
        , estado
        FROM ".$BDBACK.".dbo.banners
        where
        id=".$Codigo."
        ");
    }

    public static function getNombreMarca($BDBACK, $Codigo)
    {
        return DB::select("
        SELECT 
        id
        , nombre
        , ruta
        , cabecera
        , estado
        FROM ".$BDBACK.".dbo.marcas
        where
        id=".$Codigo."
        ");
    }

    public static function getNombreGrupo($BD, $Codigo)
    {
        return DB::select("
        select
        *
        from
        ".$BD.".dbo.familias
        where
        id=".$Codigo."
        ");
    }

    public static function updateProductoRegalo($DataModel, $id)
    {
        return DB::connection('sqlsrv')->table('pedido_producto')->where('padre_id', $id)->update($DataModel);
    }

    public static function updateProducto($DataModel, $id)
    {
        return DB::connection('sqlsrv')->table('pedido_producto')->where('id', $id)->update($DataModel);
    }

    public static function deleteLineaProductoActual($id)
    {
        return DB::connection('sqlsrv')->table('pedido_producto')->where('id', $id)->delete();
    }

    public static function deleteLineaProductoRegalo($id)
    {
        return DB::connection('sqlsrv')->table('pedido_producto')->where('padre_id', $id)->delete();
    }

    public static function getLineaProductoActual($id, $BDBACK)
    {
        return DB::select("
        SELECT
        *
        FROM ".$BDBACK.".dbo.pedido_producto
        where
        id=".$id."
        ");
    }

    public static function getDetalleBolsa($Pedido, $BDBACK)
    {
        return DB::select("
        SELECT 
        temp1.id
        , temp1.estado_valido
        , temp1.estado_terminado
        , temp1.fk_pedido
        , Prod.codigo
        , prod.descripcion
        , prod.descripcion2
        , prod.DesExtra
        , prod.fichatecnica
        , prod.hojaseguridad
        , isnull(prod.imagen1,'/img/productos/SinImagen.jpg') as imagen1
        
        FROM ".$BDBACK.".dbo.pedido_producto as temp1 
        inner join ".$BDBACK.".dbo.productos as Prod 
        on temp1.codigo = Prod.id
        
        where 
        temp1.estado_valido='SI' 
        and temp1.estado_terminado='NO' 
        and temp1.fk_pedido='".$Pedido."' 
        
        order by 
        temp1.id
        asc
        ");
    }

    public static function getSubtotalTemporal($Codigo, $BDBACK)
    {
        return DB::select("
        SELECT
        ISNULL(count(temp2.id),0) as cantidad
        FROM ".$BDBACK.".dbo.pedido_cabecera as temp1
        inner join ".$BDBACK.".dbo.pedido_producto as temp2 on temp1.id=temp2.fk_pedido and temp2.estado_terminado='NO'
        where
        temp1.cliente_id='".$Codigo."'
        and temp1.estado_terminado='NO'
        ");
    }

    public static function addProducto($DataModel)
    {
        return DB::connection('sqlsrv')->table('pedido_producto')->insertGetId($DataModel);
    }

    public static function addPedido($DataModel)
    {
        return DB::connection('sqlsrv')->table('pedido_cabecera')->insertGetId($DataModel);
    }

    public static function getPedidoTemporal($Codigo, $BDBACK)
    {
        return DB::select("
        SELECT 
        * 
        FROM ".$BDBACK.".dbo.pedido_cabecera
        where
        estado_terminado='NO' and cliente_id='".$Codigo."'
        ");
    }

    public static function getProductosActivos($Condicion, $BD, $BDBACK, $AuxCondicionCaracOpcion)
    {
        return DB::select("
        SELECT
        prod.id
        , prod.codigo
        , prod.descripcion
        , prod.fk_familia
        , fam.nombre as familia_nombre
        , prod.estado
        , prod.descripcion2
        , prod.DesExtra
        , prod.vista
        , prod.fichatecnica
        , prod.hojaseguridad
        , prod.archivoextra
        , prod.archivoextranombre
        , prod.imagen1
        , prod.imagen2
        , prod.imagen3
        , prod.imagen4
        , prod.imagen5
        , prod.imagen6
        , prod.fk_marca
        , marc.nombre as marca_nombre
        , marc.ruta as marca_ruta
        , isnull(bann.banner,0) as fk_banner
        , ISNULL(CAST((
            SELECT caract.valor+'/'
            FROM ".$BDBACK.".dbo.productos_caracteristicas AS caract
            WHERE prod.id=caract.fk_producto
            FOR XML PATH('')
        )as varchar(300)),'0') AS caracteristicas_valores
        FROM ".$BDBACK.".dbo.productos as prod
        ".$AuxCondicionCaracOpcion."
        inner join familias as fam on prod.fk_familia=fam.id
        left join ".$BDBACK.".dbo.banners_detalles as bann on prod.codigo=bann.CodProd
        left join ".$BDBACK.".dbo.marcas as marc on prod.fk_marca=marc.id
        where
        ".$Condicion."
        group by 
        prod.id
        , prod.codigo
        , prod.descripcion
        , prod.fk_familia
        , fam.nombre
        , prod.estado
        , prod.descripcion2
        , prod.DesExtra
        , prod.vista
        , prod.fichatecnica
        , prod.hojaseguridad
        , prod.archivoextra
        , prod.archivoextranombre
        , prod.imagen1
        , prod.imagen2
        , prod.imagen3
        , prod.imagen4
        , prod.imagen5
        , prod.imagen6
        , prod.fk_marca
        , marc.ruta
        , marc.nombre
        , isnull(bann.banner,0)
        ");
    }

    public static function GetCantProductoPedido($Pedido, $CodProd, $BDBACK)
    {
        return DB::select("
        SELECT 
        ISNULL(sum(cant_venta),0) AS cantidad
        FROM ".$BDBACK.".dbo.pedido_producto 
        where 
        fk_pedido=".$Pedido."
        and codigo='".$CodProd."' 
        and estado_terminado='NO' 
        and estado_valido='SI'
        ");
    }
    
}

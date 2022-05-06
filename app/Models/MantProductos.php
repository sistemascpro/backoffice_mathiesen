<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantProductos extends Model
{
    public static function GetHistorialArchivos($BDBACK, $id)
    {
        return DB::select("
        SELECT
        id
        , tipo
        , isnull(nombre, '') as nombre
        , archivo
        , isnull(fecha, '') as fecha
        , isnull(responsable, '') as responsable
        FROM ".$BDBACK.".dbo.productos_archivos
        where
        fk_producto=".$id."
        order by
        id
        desc
        ");
    }


    public static function GuardarProductosArchivos($BDBACK, $DataModel)
    {
        return DB::connection($BDBACK)->table('productos_archivos')->insertGetId($DataModel);
    }

    public static function GetMarcas($BDBACK, $id){
        return DB::select("
        SELECT
        marc.id
        , marc.codigo
        , marc.nombre
        , marc.ruta
        , case when prod.id is not null then 'selected' else '' end as selected
        FROM ".$BDBACK.".dbo.marcas as marc
        left join ".$BDBACK.".dbo.productos as prod on marc.id=prod.fk_marca and prod.id=".$id."
        where
        marc.estado=1
        order by
        marc.nombre asc
        ");
    }

    public static function GetProveedores($BDBACK, $id){
        return DB::select("
        SELECT
        proov.id
        , proov.codigo
        , proov.nombre
        , case when prod.id is not null then 'checked' else '' end as checked
        FROM ".$BDBACK.".dbo.proveedores as proov
        left join ".$BDBACK.".dbo.productos_proveedores as prod on proov.id=prod.fk_proveedor and prod.fk_producto=".$id."
        where
        proov.estado=1
        order by
        proov.nombre asc
        ");
    }

    public static function GetPaises($BDBACK, $id){
        return DB::select("
        SELECT
        pais.id
        , pais.codigo
        , pais.nombre
        , case when prod.id is not null then 'checked' else '' end as checked
        FROM ".$BDBACK.".dbo.paises as pais
        left join ".$BDBACK.".dbo.productos_paises as prod on pais.id=prod.fk_pais and prod.fk_producto=".$id."
        where
        pais.estado=1
        order by
        pais.nombre asc
        ");
    }

    public static function GetCaracteristicasValores($BDBACK, $fk_caracteristica, $fk_producto)
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

    public static function CargarCaracteristicasFamiliaOpciones($BDBACK, $id, $fk_producto)
    {
        return DB::select("
        SELECT 
        caract.id
        , caract.opcion
        , caract.estado
        , caract.fk_caracteristica
        , prod.fk_producto 
        FROM ".$BDBACK.".dbo.caracteristicas_productos_opciones as caract
        left join ".$BDBACK.".dbo.productos_caracteristicas as prod on caract.fk_caracteristica=prod.fk_caracteristica and caract.id=prod.valor and prod.fk_producto=".$fk_producto."
        where
        caract.fk_caracteristica=".$id."
        and caract.estado=1
        ");
    }

    public static function CargarCaracteristicasFamilia($BDBACK, $id, $fk_producto)
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
        left join ".$BDBACK.".dbo.productos_caracteristicas as prod on cfam.fk_caracteristica=prod.fk_caracteristica and prod.fk_producto=".$fk_producto."
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

    public static function EliminarProveedores($BDBACK, $id)
    {
        return DB::connection($BDBACK)->table('productos_proveedores')->where('fk_producto', $id)->delete();
    }

    public static function EliminarPaises($BDBACK, $id)
    {
        return DB::connection($BDBACK)->table('productos_paises')->where('fk_producto', $id)->delete();
    }

    public static function EliminarFamilias($BDBACK, $id)
    {
        return DB::connection($BDBACK)->table('productos_familias')->where('fk_producto', $id)->delete();
    }
    
    public static function EliminarCaracteristicas($BDBACK, $id)
    {
        return DB::connection($BDBACK)->table('productos_caracteristicas')->where('fk_producto', $id)->delete();
    }

    public static function CargarFamiliasSecundarias($BDBACK, $id, $producto){
        return DB::select("
        SELECT
        fam.id
        , fam.codigo
        , fam.nombre
        , case when prod.id is null then '' else 'checked' end as checked
        FROM ".$BDBACK.".dbo.familias as fam
        left join ".$BDBACK.".dbo.productos_familias as prod on prod.fk_familia=fam.id and prod.fk_producto=".$producto."
        where
        fam.estado=1
        and fam.id!=".$id."
        order by
        fam.codigo
        asc
        ");
    }

    public static function UpdateProducto($BDBACK, $DataModel, $id)
    {
        return DB::connection($BDBACK)->table('productos')->where('id', $id)->update($DataModel);
    }

    public static function GuardarProductoProveedor($BDBACK, $DataModel)
    {
        return DB::connection($BDBACK)->table('productos_proveedores')->insertGetId($DataModel);
    }
    
    public static function GuardarProductoPais($BDBACK, $DataModel)
    {
        return DB::connection($BDBACK)->table('productos_paises')->insertGetId($DataModel);
    }

    public static function GuardarCaracteristicaProducto($BDBACK, $DataModel)
    {
        return DB::connection($BDBACK)->table('productos_caracteristicas')->insertGetId($DataModel);
    }

    public static function GuardarProductoFamilia($BDBACK, $DataModel)
    {
        return DB::connection($BDBACK)->table('productos_familias')->insertGetId($DataModel);
    }

    public static function GuardarProducto($BDBACK, $DataModel)
    {
        return DB::connection($BDBACK)->table('productos')->insertGetId($DataModel);
    }

    public static function GetOpcionesSelect($BDBACK, $id){
        return DB::select("
        SELECT
        opt.id
        , opt.fk_caracteristica
        FROM ".$BDBACK.".dbo.caracteristicas_productos as caract
        inner join ".$BDBACK.".dbo.caracteristicas_productos_opciones as opt on caract.id=opt.fk_caracteristica
        where
        caract.id=".$id."  
        and caract.tipo=5
        ");
    }

    public static function GetFamilias($BDBACK, $id){
        return DB::select("
        SELECT
        fam.id
        , fam.codigo
        , fam.nombre
        , fam.estado
        , case when prod.id is not null then 'selected' else '' end as selected
        FROM ".$BDBACK.".dbo.familias as fam
        left join ".$BDBACK.".dbo.productos as prod on fam.id=prod.fk_familia and prod.id=".$id."
        where
        fam.estado=1
        order by
        fam.codigo asc
        ");
    }



    public static function ExisteExtra($BDBACK, $id)
    {
        return DB::select("
        SELECT
        *
        FROM ".$BDBACK.".dbo.productos_infoextra
        where
        CONVERT(NVARCHAR(32),HashBytes('MD5', CONVERT(NVARCHAR(32),HashBytes('MD5', cast(CodProd as varchar(max))),2) ),2)='".$id."'
        ");
    }

    public static function ExisteCodigo($BDBACK, $dato, $id)
    {
        return DB::select("
        SELECT
        *
        FROM dbo.productos
        where
        id!=".$id."
        and upper(codigo)=upper('".$dato."')
        ");
    }

    public static function GetCaracteristicas($BDBACK, $id)
    {
        return DB::select("
        SELECT 
        cara.id as cara_id
        ,cara.nombre as cara_nombre
        , case when prod.id is null then '' else  'checked' end as asignado
        , isnull(prod.valor,'') as valor
        FROM 
        ".$BD.".dbo.caracteristicas_productos as cara 
        left join ".$BD.".dbo.prods_carcs as prod on prod.fk_caracteristica=cara.id and prod.fk_producto=".$id."
        ");
    }

    public static function GetProducto($BDBACK, $id)
    {
        return DB::select("
        SELECT
        prod.id
        , prod.estado
        , prod.codigo
        , prod.descripcion
        , prod.vista
        , isnull(prod.descripcion2,'') as descripcion2
        , isnull(prod.DesExtra,'') as DesExtra
        , prod.estado
        , prod.fk_familia
        , prod.fichatecnica
        , prod.hojaseguridad
        , prod.imagen1
        , prod.imagen2
        , prod.imagen3
        , prod.imagen4
        , prod.imagen5
        , prod.imagen6
        , prod.archivoextra
        , prod.archivoextranombre
        FROM ".$BDBACK.".dbo.productos as prod
        where
        prod.id='".$id."'
        order by prod.codigo asc
        ");
    }

    public static function GetList($BDBACK)
    {
        return DB::select("
        SELECT
        prod.id
        , prod.estado
        , prod.codigo
        , prod.descripcion
        , fam.nombre as familia
        FROM ".$BDBACK.".dbo.productos as prod
        inner join ".$BDBACK.".dbo.familias as fam on prod.fk_familia=fam.id
        order by codigo asc
        ");
    }

}

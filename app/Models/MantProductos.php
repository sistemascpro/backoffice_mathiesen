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
        , coalesce(nombre, '') as nombre
        , archivo
        , coalesce(fecha, '') as fecha
        , coalesce(responsable, '') as responsable
        FROM ".$BDBACK.".public.productos_archivos
        where
        fk_producto=".$id."
        order by
        id
        desc
        ");
    }


    public static function GuardarProductosArchivos($BDBACK, $DataModel)
    {
        return DB::connection('pgsql')->table('productos_archivos')->insertGetId($DataModel);
    }

    public static function GetMarcas($BDBACK, $id){
        return DB::select("
        SELECT
        marc.id
        , marc.codigo
        , marc.nombre
        , marc.ruta
        , case when prod.id is not null then 'selected' else '' end as selected
        FROM ".$BDBACK.".public.marcas as marc
        left join ".$BDBACK.".public.productos as prod on marc.id=prod.fk_marca and prod.id=".$id."
        where
        marc.estado =true
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
        FROM ".$BDBACK.".public.proveedores as proov
        left join ".$BDBACK.".public.productos_proveedores as prod on proov.id=prod.fk_proveedor and prod.fk_producto=".$id."
        where
        proov.estado =true
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
        FROM ".$BDBACK.".public.paises as pais
        left join ".$BDBACK.".public.productos_paises as prod on pais.id=prod.fk_pais and prod.fk_producto=".$id."
        where
        pais.estado =true
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
        FROM ".$BDBACK.".public.productos_caracteristicas
        where
        fk_producto=".$fk_producto."
        and fk_caracteristica=".$fk_caracteristica."
        ");
    }

    public static function CargarCaracteristicasFamiliaOpciones($BDBACK, $id, $fk_producto)
    {
        return DB::select("
        SELECT
        opciones.id
        , opciones.opcion
        , opciones.estado
        , opciones.fk_caracteristica
        , prod.fk_producto
        FROM ".$BDBACK.".public.caracteristicas_productos_opciones as opciones
        inner join ".$BDBACK.".public.caracteristicas_productos as caract on opciones.fk_caracteristica=caract.id
        left join ".$BDBACK.".public.productos_caracteristicas as prod on caract.id=prod.fk_caracteristica and cast(prod.valor as int)=opciones.id and prod.fk_producto=".$fk_producto."
        where
        caract.id=".$id."
        and caract.estado =true
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
        FROM ".$BDBACK.".public.familias_caracteristicas as cfam 
        inner join ".$BDBACK.".public.caracteristicas_productos as carac on cfam.fk_caracteristica=carac.id 
        inner join ".$BDBACK.".public.caracteristicas_productos_tipos as tip on carac.tipo=tip.id
        left join ".$BDBACK.".public.productos_caracteristicas as prod on cfam.fk_caracteristica=prod.fk_caracteristica and prod.fk_producto=".$fk_producto."
        where 
        cfam.estado =true
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
        return DB::connection('pgsql')->table('productos_proveedores')->where('fk_producto', $id)->delete();
    }

    public static function EliminarPaises($BDBACK, $id)
    {
        return DB::connection('pgsql')->table('productos_paises')->where('fk_producto', $id)->delete();
    }

    public static function EliminarFamilias($BDBACK, $id)
    {
        return DB::connection('pgsql')->table('productos_familias')->where('fk_producto', $id)->delete();
    }
    
    public static function EliminarCaracteristicas($BDBACK, $id)
    {
        return DB::connection('pgsql')->table('productos_caracteristicas')->where('fk_producto', $id)->delete();
    }

    public static function CargarFamiliasSecundarias($BDBACK, $id, $producto){
        return DB::select("
        SELECT
        fam.id
        , fam.codigo
        , fam.nombre
        , case when prod.id is null then '' else 'checked' end as checked
        FROM ".$BDBACK.".public.familias as fam
        left join ".$BDBACK.".public.productos_familias as prod on prod.fk_familia=fam.id and prod.fk_producto=".$producto."
        where
        fam.estado =true
        and fam.id!=".$id."
        order by
        fam.codigo
        asc
        ");
    }

    public static function UpdateProducto($BDBACK, $DataModel, $id)
    {
        return DB::connection('pgsql')->table('productos')->where('id', $id)->update($DataModel);
    }

    public static function GuardarProductoProveedor($BDBACK, $DataModel)
    {
        return DB::connection('pgsql')->table('productos_proveedores')->insertGetId($DataModel);
    }
    
    public static function GuardarProductoPais($BDBACK, $DataModel)
    {
        return DB::connection('pgsql')->table('productos_paises')->insertGetId($DataModel);
    }

    public static function GuardarCaracteristicaProducto($BDBACK, $DataModel)
    {
        return DB::connection('pgsql')->table('productos_caracteristicas')->insertGetId($DataModel);
    }

    public static function GuardarProductoFamilia($BDBACK, $DataModel)
    {
        return DB::connection('pgsql')->table('productos_familias')->insertGetId($DataModel);
    }

    public static function GuardarProducto($BDBACK, $DataModel)
    {
        return DB::connection('pgsql')->table('productos')->insertGetId($DataModel);
    }

    public static function GetOpcionesSelect($BDBACK, $id){
        return DB::select("
        SELECT
        opt.id
        , opt.fk_caracteristica
        FROM ".$BDBACK.".public.caracteristicas_productos as caract
        inner join ".$BDBACK.".public.caracteristicas_productos_opciones as opt on caract.id=opt.fk_caracteristica
        where
        caract.id=".$id."
        and caract.tipo=3
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
        FROM ".$BDBACK.".public.familias as fam
        left join ".$BDBACK.".public.productos as prod on fam.id=prod.fk_familia and prod.id=".$id."
        where
        fam.estado =true
        order by
        fam.codigo asc
        ");
    }



    public static function ExisteExtra($BDBACK, $id)
    {
        return DB::select("
        SELECT
        *
        FROM ".$BDBACK.".public.productos_infoextra
        where
        CONVERT(NVARCHAR(32),HashBytes('MD5', CONVERT(NVARCHAR(32),HashBytes('MD5', cast(CodProd as varchar(max))),2) ),2)='".$id."'
        ");
    }

    public static function ExisteCodigo($BDBACK, $dato, $id)
    {
        return DB::select("
        SELECT
        *
        FROM public.productos
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
        , coalesce(prod.valor,'') as valor
        FROM 
        ".$BD.".public.caracteristicas_productos as cara 
        left join ".$BD.".public.prods_carcs as prod on prod.fk_caracteristica=cara.id and prod.fk_producto=".$id."
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
        , coalesce(prod.descripcion2,'') as descripcion2
        , coalesce(prod.DesExtra,'') as DesExtra
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
        FROM ".$BDBACK.".public.productos as prod
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
        FROM ".$BDBACK.".public.productos as prod
        inner join ".$BDBACK.".public.familias as fam on prod.fk_familia=fam.id
        order by codigo asc
        ");
    }

}

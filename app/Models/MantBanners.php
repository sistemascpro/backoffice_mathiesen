<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantBanners extends Model
{
    public static function EliminarBanners($BDBACK, $id)
    {
        return DB::connection($BDBACK)->table('banners')->where('id', $id)->delete();
    }

    public static function EliminarProductos($BDBACK, $id)
    {
        return DB::connection($BDBACK)->table('banners_detalles')->where('banner', $id)->delete();
    }

    public static function EliminarProducto($BDBACK, $id)
    {
        return DB::connection($BDBACK)->table('banners_detalles')->where('id', $id)->delete();
    }

    public static function CargarProductosBanners($BDBACK, $Id)
    {
        return DB::select("
        SELECT
        bann.id
        , bann.CodProd
        , prod.descripcion
        FROM ".$BDBACK.".public.banners_detalles as bann
        INNER JOIN ".$BDBACK.".public.productos as prod on bann.CodProd = prod.codigo
        where bann.banner=".$Id."
        ");
    }

    public static function AgregarProducto($BDBACK, $DataModel)
    {
        return DB::connection($BDBACK)->table('banners_detalles')->insertGetId($DataModel);
    }

    public static function ExisteProductoBanner($BDBACK, $CodProd, $Id)
    {
        return DB::select("
        SELECT
        *
        FROM ".$BDBACK.".public.banners_detalles
        where banner=".$Id." and CodProd='".$CodProd."'
        ");
    }

    public static function UpdateBanner($BDBACK, $DataModel, $id)
    {
        return DB::connection($BDBACK)->table('banners')->where('id', $id)->update($DataModel);
    }

    public static function ExistePosicion($BDBACK, $Posicion, $id)
    {
        return DB::select("
        SELECT
        *
        FROM ".$BDBACK.".public.banners
        where posicion=".$Posicion." and id!=".$id."
        ");
    }

    public static function GuardarBanner($BDBACK, $DataModel)
    {
        return DB::connection($BDBACK)->table('banners')->insertGetId($DataModel);
    }

    public static function GetDetalle($BDBACK, $id)
    {
        return DB::select("
        SELECT
        id
        , nombre
        , ruta
        , posicion
        FROM ".$BDBACK.".public.banners
        where id=".$id."
        ");
    }
    
    public static function GetList($BDBACK)
    {
        return DB::select("
        SELECT 
        bann.id
        , bann.nombre
        , bann.ruta
        , bann.posicion
        , count(deta.id) as cantidad

        FROM 
        ".$BDBACK.".public.banners as bann
        left join ".$BDBACK.".public.banners_detalles as deta on bann.id=deta.banner

        group by 
        bann.id
        , bann.nombre
        , bann.ruta
        , bann.posicion

        order by
        bann.posicion
        asc
        ");
    }

}

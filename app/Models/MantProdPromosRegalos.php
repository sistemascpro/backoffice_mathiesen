<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantProdPromosRegalos extends Model
{

    public static function UpdatePromo($BDBACK, $DataModel, $Id)
    {
        return DB::connection($BDBACK)->table('prodpromosregalos')->where(DB::raw("CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(id as varchar(max))),2) ),2)"), $Id)->update($DataModel);
    }

    public static function Guardar($BDBACK, $DataModel)
    {
        return DB::connection($BDBACK)->table('prodpromosregalos')->insertGetId($DataModel);
    }

    public static function ExistePromo($BDBACK, $Prod1, $Cant1, $Fecha1, $Fecha2, $Id)
    {
        return DB::select("
        SELECT
        promo.prod1
        , promo.cant1
        , promo.prod2
        , promo.cant2
        , promo.precio2
        , promo.fecha1
        , promo.fecha2
        FROM 
        ".$BDBACK.".dbo.prodpromosregalos as promo
        where
        (
            CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(promo.id as varchar(max))),2) ),2)!='".$Id."'
            and promo.prod1='".$Prod1."' 
            and promo.cant1=".$Cant1."
            and convert(datetime, '". $Fecha1."', 103)
            between convert(datetime, promo.fecha1, 103)
            and convert(datetime, promo.fecha2, 103)
        )
        or 
        (
            CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(promo.id as varchar(max))),2) ),2)!='".$Id."'
            and promo.prod1='".$Prod1."' 
            and promo.cant1=".$Cant1."
            and convert(datetime, '". $Fecha2."', 103)
            between convert(datetime, promo.fecha1, 103)
            and convert(datetime, promo.fecha2, 103)
        )
        or 
        (
            CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(promo.id as varchar(max))),2) ),2)!='".$Id."'
            and promo.prod1='ACC004' 
            and promo.cant1=3
            and convert(datetime, promo.fecha1, 103)
            between convert(datetime, '". $Fecha1."', 103)
            and convert(datetime, '". $Fecha2."', 103)
        )
        or 
        (
            CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(promo.id as varchar(max))),2) ),2)!='".$Id."'
            and promo.prod1='ACC004' 
            and promo.cant1=3
            and convert(datetime, promo.fecha2, 103)
            between convert(datetime, '". $Fecha1."', 103)
            and convert(datetime, '". $Fecha2."', 103)
        )        
        ");
    }

    public static function CargarProducto($BDBACK, $CodProd)
    {
        return DB::select("
        SELECT
        prod.descripcion
        FROM ".$BDBACK.".dbo.productos as prod
        WHERE
        UPPER(prod.codigo)=UPPER('".$CodProd."')
        order by prod.codigo asc
        ");
    }

    public static function GetDetalle($BDBACK, $id)
    {
        return DB::select("
        SELECT
        CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(promo.id as varchar(max))),2) ),2) AS promoid
        , promo.prod1
        , prod1.DesProd as desc1
        , promo.cant1
        , promo.prod2
        , promo.cant2
        , promo.precio2
        , prod2.DesProd as desc2
        , CONCAT(SUBSTRING(promo.fecha1,7,4),'-',SUBSTRING(promo.fecha1,4,2),'-',SUBSTRING(promo.fecha1,1,2)) as fecha1
        , CONCAT(SUBSTRING(promo.fecha2,7,4),'-',SUBSTRING(promo.fecha2,4,2),'-',SUBSTRING(promo.fecha2,1,2)) as fecha2
        FROM ".$BDBACK.".dbo.prodpromosregalos as promo
        inner join ".$BDBACK.".dbo.productos as prod1 on promo.prod1 collate database_default = prod1.CodProd collate database_default
        inner join ".$BDBACK.".dbo.productos as prod2 on promo.prod2 collate database_default = prod2.CodProd collate database_default
        where
        CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(promo.id as varchar(max))),2) ),2)='".$id."'
        ");
    }

    public static function GetList($BDBACK)
    {
        return DB::select("
        SELECT
        CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(promo.id as varchar(max))),2) ),2) as promoid
        , promo.prod1
        , prod1.descripcion as desc1
        , promo.cant1
        , promo.prod2
        , promo.cant2
        , promo.precio2
        , prod2.descripcion as desc2
        , promo.fecha1
        , promo.fecha2
        FROM dbo.prodpromosregalos as promo
        inner join ".$BDBACK.".dbo.productos as prod1 on promo.prod1 = prod1.codigo
        inner join ".$BDBACK.".dbo.productos as prod2 on promo.prod2 = prod2.codigo
        order by promo.id desc 
        ");
    }

}

<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantProductosSinCanje extends Model
{
    public static function Eliminar($id)
    {
        return DB::connection('sqlsrv')->table('productos_sincanje')->where('id', $id)->delete();
    }

    public static function Guardar($DataModel)
    {
        return DB::connection('sqlsrv')->table('productos_sincanje')->insertGetId($DataModel);
    }

    public static function ExisteProducto($BD, $CodProd)
    {
        return DB::select("
        SELECT
        prod.codigo
        , prod.descripcion
        FROM ".$BD.".dbo.productos as prod
        WHERE
        prod.CodProd='".$CodProd."'
        ");
    }

    public static function ExisteAgregado($CodProd)
    {
        return DB::select("
        SELECT
        *
        FROM dbo.productos_sincanje
        where
        CodProd='".$CodProd."'
        ");
    }

    public static function GetList($BD)
    {
        return DB::select("
        SELECT
        sincan.id
        , sincan.CodProd
        , prod.descripcion
        FROM dbo.productos_sincanje as sincan
        INNER JOIN ".$BD.".dbo.productos as prod on sincan.CodProd = prod.codigo
        ");
    }

}

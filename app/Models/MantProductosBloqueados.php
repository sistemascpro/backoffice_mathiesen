<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantProductosBloqueados extends Model
{
    public static function Eliminar($id)
    {
        return DB::connection('sqlsrv')->table('productos_bloqueados')->where('id', $id)->delete();
    }

    public static function Guardar($DataModel)
    {
        return DB::connection('sqlsrv')->table('productos_bloqueados')->insertGetId($DataModel);
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

    public static function ExisteAgregado($CodProd, $BDBACK)
    {
        return DB::select("
        SELECT
        *
        FROM ".$BDBACK.".dbo.productos_bloqueados
        where
        CodProd='".$CodProd."'
        ");
    }

    public static function GetList($BD, $BDBACK)
    {
        return DB::select("
        SELECT
        bloq.id
        , prod.codigo
        , prod.descripcion
        , bloq.Mensaje
        FROM ".$BDBACK.".dbo.productos_bloqueados as bloq
        INNER JOIN ".$BD.".dbo.productos as prod on bloq.CodProd = prod.codigo
        ");
    }

}

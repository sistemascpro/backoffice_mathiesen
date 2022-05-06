<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantProductosCaracteristicas extends Model
{
    public static function EliminarOpcion($DBBACK, $id)
    {
        return DB::connection($DBBACK)->table('caracteristicas_productos_opciones')->where('id', $id)->delete();
    }

    public static function GetOpciones($DBBACK, $id)
    {
        return DB::select("
        SELECT
        *
        FROM ".$DBBACK.".dbo.caracteristicas_productos_opciones
        where
        fk_caracteristica=".$id."
        ");
    }
        
    public static function ExisteNombre($DBBACK, $dato, $id)
    {
        return DB::select("
        SELECT
        *
        FROM ".$DBBACK.".dbo.caracteristicas_productos
        where
        id!=".$id."
        and upper(nombre)=upper('".$dato."')
        ");
    }

    public static function GuardarOpcion($DBBACK, $DataModel)
    {
        return DB::connection($DBBACK)->table('caracteristicas_productos_opciones')->insertGetId($DataModel);
    }

    public static function Guardar($DBBACK, $DataModel)
    {
        return DB::connection($DBBACK)->table('caracteristicas_productos')->insertGetId($DataModel);
    }

    public static function Actualizar($DBBACK, $DataModel, $id)
    {
        return DB::connection($DBBACK)->table('caracteristicas_productos')->where('id', $id)->update($DataModel);
    }

    public static function GetCaracteristicasTipos($DBBACK)
    {
        return DB::select("
        SELECT
        *
        FROM ".$DBBACK.".dbo.caracteristicas_productos_tipos
        order by
        nombre
        asc
        ");
    }

    public static function GetDetalle($DBBACK, $id)
    {
        return DB::select("
        SELECT
        *
        FROM ".$DBBACK.".dbo.caracteristicas_productos
        WHERE
        id=".$id."
        ");
    }

    public static function GetList($DBBACK)
    {
        return DB::select("
        SELECT
        temp1.id
        , temp2.nombre as tipo_nombre
        , temp1.nombre
        , temp1.estado
        FROM ".$DBBACK.".dbo.caracteristicas_productos as temp1
        inner join ".$DBBACK.".dbo.caracteristicas_productos_tipos  as temp2 on temp1.tipo=temp2.id
        order by
        temp1.nombre
        asc
        ");
    }
}

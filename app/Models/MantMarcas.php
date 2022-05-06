<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantMarcas extends Model
{
    public static function updateEstado($DataModel, $id)
    {
        return DB::connection('sqlsrv')->table('marcas')->where('id', $id)->update($DataModel);
    }

    public static function UpdateMarca($DataModel, $id)
    {
        return DB::connection('sqlsrv')->table('marcas')->where('id', $id)->update($DataModel);
    }

    public static function ExistePosicion($BD, $posicion, $id)
    {
        return DB::select("
        SELECT
        *
        FROM ".$BD.".dbo.marcas
        where posicion=".$posicion." and id!=".$id."
        ");
    }

    public static function ExisteNombre($BD, $nombre, $id)
    {
        return DB::select("
        SELECT
        *
        FROM ".$BD.".dbo.marcas
        where nombre='".$nombre."' and id!=".$id."
        ");
    }

    public static function GuardarMarca($DataModel)
    {
        return DB::connection('sqlsrv')->table('marcas')->insertGetId($DataModel);
    }

    public static function GetDetalle($BD, $id)
    {
        return DB::select("
        SELECT
        *
        FROM ".$BD.".dbo.marcas
        where id=".$id."
        ");
    }

    public static function GetList($BD)
    {
        return DB::select("
        SELECT
        *
        FROM
        ".$BD.".dbo.marcas
        order by
        nombre
        asc
        ");
    }

}

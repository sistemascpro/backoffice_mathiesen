<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantPaises extends Model
{
    public static function MakeUpdate($BDBACK, $DataModel, $id)
    {
        return DB::connection($BDBACK)->table('paises')->where('id', $id)->update($DataModel);
    }

    public static function ExisteCodigo($BDBACK, $codigo, $id)
    {
        return DB::select("
        SELECT
        *
        FROM ".$BDBACK.".dbo.paises
        where codigo='".$codigo."' and id!=".$id."
        ");
    }

    public static function ExisteNombre($BDBACK, $nombre, $id)
    {
        return DB::select("
        SELECT
        *
        FROM ".$BDBACK.".dbo.paises
        where nombre='".$nombre."' and id!=".$id."
        ");
    }

    public static function Guardar($BDBACK, $DataModel)
    {
        return DB::connection($BDBACK)->table('paises')->insertGetId($DataModel);
    }

    public static function GetDetalle($BDBACK, $id)
    {
        return DB::select("
        SELECT
        *
        FROM ".$BDBACK.".dbo.paises
        where id=".$id."
        ");
    }

    public static function GetList($BDBACK)
    {
        return DB::select("
        SELECT 
        *
        FROM 
        ".$BDBACK.".dbo.paises
        order by
        nombre
        asc
        ");
    }
}
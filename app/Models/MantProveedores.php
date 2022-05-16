<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantProveedores extends Model
{
    public static function MakeUpdate($BDBACK, $DataModel, $id)
    {
        return DB::connection('pgsql')->table('proveedores')->where('id', $id)->update($DataModel);
    }

    public static function ExisteCodigo($BDBACK, $codigo, $id)
    {
        return DB::select("
        SELECT
        *
        FROM ".$BDBACK.".public.proveedores
        where codigo='".$codigo."' and id!=".$id."
        ");
    }

    public static function ExisteNombre($BDBACK, $nombre, $id)
    {
        return DB::select("
        SELECT
        *
        FROM ".$BDBACK.".public.proveedores
        where nombre='".$nombre."' and id!=".$id."
        ");
    }

    public static function Guardar($BDBACK, $DataModel)
    {
        return DB::connection('pgsql')->table('proveedores')->insertGetId($DataModel);
    }

    public static function GetDetalle($BDBACK, $id)
    {
        return DB::select("
        SELECT
        *
        FROM ".$BDBACK.".public.proveedores
        where id=".$id."
        ");
    }

    public static function GetList($BDBACK)
    {
        return DB::select("
        SELECT 
        *
        FROM 
        ".$BDBACK.".public.proveedores
        order by
        nombre
        asc
        ");
    }
}
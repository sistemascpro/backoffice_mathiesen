<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantSliderContenidos extends Model
{
    public static function Eliminar($id)
    {
        return DB::connection('sqlsrv')->table('noticias')->where('id', $id)->delete();
    }

    public static function UpdateNoticia($DataModel, $NoticiaId)
    {
        return DB::table('noticias')->where(DB::raw("CONVERT(NVARCHAR(32),HashBytes('MD5', CONVERT(NVARCHAR(32),HashBytes('MD5', cast(id as varchar(max))),2) ),2)"), $NoticiaId)->update($DataModel);
    }

    public static function GuardarNoticia($DataModel)
    {
        return DB::connection('sqlsrv')->table('noticias')->insertGetId($DataModel);
    }

    public static function ExistePosicion($posicion, $id)
    {
        return DB::select("
        SELECT
        *
        FROM dbo.noticias
        where
        CONVERT(NVARCHAR(32),HashBytes('MD5', CONVERT(NVARCHAR(32),HashBytes('MD5', cast(id as varchar(max))),2) ),2)!='".$id."'
        and posicion=".$posicion."
        ");
    }

    public static function ExisteId($id)
    {
        return DB::select("
        SELECT
        *
        FROM dbo.noticias
        where CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(id as varchar(max))),2) ),2)='".$id."'
        ");
    }

    public static function GetNoticia($id)
    {
        return DB::select("
        SELECT
        *
        FROM dbo.sliders_contenidos
        where id=".$id."
        ");
    }

    public static function GetList($BDBACK)
    {
        return DB::select("
        SELECT 
        *
        FROM ".$BDBACK.".dbo.sliders_contenidos
        order by id asc
        ");
    }

}

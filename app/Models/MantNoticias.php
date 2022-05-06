<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantNoticias extends Model
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

    public static function GetNoticiaMd5($id)
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
        CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(id as varchar(max))),2) ),2) as noticiaid
        ,id
        ,titulo
        ,contenido
        ,imagen
        ,cover
        ,video
        ,tipo
        ,posicion
        ,CASE WHEN tipo='Imagen' THEN titulo else '' END as ImagenTitulo
        ,CASE WHEN tipo='Imagen' THEN contenido else '' END as ImagenContenido
        ,CASE WHEN tipo='Imagen' THEN CAST(posicion as nvarchar(1)) else '' END as ImagenPosicion
        ,CASE WHEN tipo='Video'  THEN titulo else '' END as VideoTitulo 
        ,CASE WHEN tipo='Video'  THEN contenido else '' END as VideoContenido  
        ,CASE WHEN tipo='Video'  THEN CAST(posicion as nvarchar(1)) else '' END as VideoPosicion
        FROM dbo.noticias
        where id=".$id."
        ");
    }

    public static function GetList($BDBACK)
    {
        return DB::select("
        SELECT 
        id
        ,titulo
        ,contenido
        ,imagen
        ,cover
        ,video
        ,tipo
        ,posicion
        FROM ".$BDBACK.".dbo.noticias
        ");
    }

}

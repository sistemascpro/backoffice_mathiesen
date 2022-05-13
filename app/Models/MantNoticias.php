<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantNoticias extends Model
{
    public static function Eliminar($id)
    {
        return DB::connection('pgsql')->table('noticias')->where('id', $id)->delete();
    }

    public static function UpdateNoticia($DataModel, $NoticiaId)
    {
        return DB::table('noticias')->where(DB::raw("id"), $NoticiaId)->update($DataModel);
    }

    public static function GuardarNoticia($DataModel)
    {
        return DB::connection('pgsql')->table('noticias')->insertGetId($DataModel);
    }

    public static function ExistePosicion($posicion, $id)
    {
        return DB::select("
        SELECT
        *
        FROM public.noticias
        where
        id!='".$id."'
        and posicion=".$posicion."
        ");
    }

    public static function ExisteId($id)
    {
        return DB::select("
        SELECT
        *
        FROM public.noticias
        where id=".$id."
        ");
    }

    public static function GetNoticiaMd5($id)
    {
        return DB::select("
        SELECT
        *
        FROM public.noticias
        where id=".$id."
        ");
    }

    public static function GetNoticia($id)
    {
        return DB::select("
        SELECT
        id
        ,titulo
        ,contenido
        ,imagen
        ,posicion
        FROM public.noticias
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
        ,posicion
        FROM ".$BDBACK.".public.noticias
        ");
    }

}

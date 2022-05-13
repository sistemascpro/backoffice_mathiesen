<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class GeneralModel extends Model
{
    public static function GetSliderContenidos($BDBACK)
    {
        return DB::select("
        SELECT
        *
        FROM ".$BDBACK.".public.sliders_contenidos
        order by id asc
        ");
    }

    public static function GetUnPais($BDBACK, $Pais)
    {
        return DB::select("
        SELECT 
        *
        FROM ".$BDBACK.".public.paises
        where
        estado =true
        and id=".$Pais."
        order by 
        nombre asc
        ");
    }

    public static function GetPaises($BDBACK)
    {
        return DB::select("
        SELECT 
        *
        FROM ".$BDBACK.".public.paises
        where
        estado =true
        order by 
        nombre asc
        ");
    }

    public static function GetNoticiaIdSiguiente($DBBACK, $id)
    {
            return DB::select("
            SELECT
            *
            FROM ".$DBBACK.".public.noticias
            where
            id>".$id."
            order by
            id
            asc
            limit 1
            ");
    }

    public static function GetNoticiaIdAnterior($DBBACK, $id)
    {
            return DB::select("
            SELECT
            *
            FROM ".$DBBACK.".public.noticias
            where
            id<".$id."
            order by 
            id
            desc
            limit 1
            ");
    }

    public static function GetNoticiaId($DBBACK, $id)
    {
            return DB::select("
            SELECT
            *
            FROM ".$DBBACK.".public.noticias
            where
            id=".$id."
            limit 1
            ");
    }
    
    public static function GetAllNoticias($DBBACK)
    {
        return DB::select("
        SELECT
        *
        FROM ".$DBBACK.".public.noticias
        order by posicion, id asc
        ");
    }
    public static function GetFamiliasHome($BDBACK)
    {
        return DB::select("
        SELECT 
        *
        FROM ".$BDBACK.".public.familias
        where estado =true and ruta!='' and ruta is not null
        order by nombre asc
        ");
    }  

    public static function GetMarcas($BDBACK)
    {
        return DB::select("
        SELECT 
        *
        FROM ".$BDBACK.".public.marcas
        where 
        estado =true 
        and ruta!=''
        and ruta is not null
        and posicion>=1
        and posicion<=8
        order by posicion asc
        ");
    }  

    public static function GetNoticias($BDBACK)
    {
        return DB::select("
        SELECT 
        id
        ,titulo
        ,contenido
        ,imagen
        ,posicion
        FROM ".$BDBACK.".public.noticias
        where posicion!=0 order by posicion asc
        ");
    }  
    
    public static function GetMenuBuscador($BDBACK)
    {
        return DB::select("
        select
        codigo
        , nombre
        from
        ".$BDBACK.".public.familias
        where
        estado =true
        order by 
        nombre
        asc        
        ");
    }
    
    public static function GetBanners($BDBACK)
    {
        return DB::select("
        SELECT
        *
        FROM
        ".$BDBACK.".public.banners
        order by posicion
        asc
        ");
    }

    public static function GetSliders($BDBACK)
    {
        return DB::select("
        SELECT
        *
        FROM
        ".$BDBACK.".public.sliders
        order by id 
        asc
        ");
    }

    public static function GetCLientes($BDBACK, $id)
    {
        if(!isset($id))
        {
            $id=0;
        }
        return DB::select("
        SELECT
        cli.*
        FROM
        ".$BDBACK.".public.clientes as cli
        inner join  ".$BDBACK.".public.clientes_usuarios as cliusu on cli.id=CAST(cliusu.fk_cliente as int)
        where
        cliusu.fk_usuario='".$id."'
        ");
    }

    public static function GetMenusProductosPadres($BDBACK)
    {
        return DB::select("
        SELECT
        *
        FROM
        ".$BDBACK.".public.familias
        where
        estado =true
        order by nombre asc
        ");
    }

    public static function GetNombreEmpresa($BDBACK)
    {
        return DB::select("Select * from ".$BDBACK.".public.empresa where bdbackoffice='".$BDBACK."' ");
    }
}

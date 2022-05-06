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
        FROM ".$BDBACK.".dbo.sliders_contenidos
        order by id asc
        ");
    }

    public static function GetUnPais($BDBACK, $Pais)
    {
        return DB::select("
        SELECT 
        *
        FROM ".$BDBACK.".dbo.paises
        where
        estado=1
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
        FROM ".$BDBACK.".dbo.paises
        where
        estado=1
        order by 
        nombre asc
        ");
    }

    public static function GetNoticiaId($DBBACK, $id)
    {
            return DB::select("
            SELECT
            *
            FROM ".$DBBACK.".dbo.noticias
            where
            cast(id as varchar(max))='".$id."'
            ");
    }
    
    public static function GetAllNoticias($DBBACK)
    {
        return DB::select("
        SELECT
        *
        FROM ".$DBBACK.".dbo.noticias
        order by posicion, id asc
        ");
    }
    public static function GetFamiliasHome($BDBACK)
    {
        return DB::select("
        SELECT 
        *
        FROM ".$BDBACK.".dbo.familias
        where estado=1 and ruta!='' and ruta is not null
        order by nombre asc
        ");
    }  

    public static function GetMarcas($BDBACK)
    {
        return DB::select("
        SELECT 
        *
        FROM ".$BDBACK.".dbo.marcas
        where 
        estado=1 
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
        ,cover
        ,video
        ,tipo
        ,posicion
        FROM ".$BDBACK.".dbo.noticias
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
        ".$BDBACK.".dbo.familias
        where
        estado=1
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
        ".$BDBACK.".dbo.banners
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
        ".$BDBACK.".dbo.sliders
        order by id 
        asc
        ");
    }

    public static function GetCLientes($BDBACK, $id)
    {
        return DB::select("
        SELECT
        cli.*
        FROM
        ".$BDBACK.".dbo.clientes as cli
        inner join  ".$BDBACK.".dbo.clientes_usuarios as cliusu on cli.codigo = cliusu.fk_cliente
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
        ".$BDBACK.".dbo.familias
        where
        estado=1
        order by nombre asc
        ");
    }

    public static function GetNombreEmpresa($BDBACK)
    {
        return DB::select("Select * from ".$BDBACK.".dbo.empresa where bdbackoffice='".$BDBACK."' ");
    }
}

<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantProductosFamilias extends Model
{
    public static function DeleteCaracteristica($BDBACK, $id)
    {
        return DB::connection($BDBACK)->table('familias_caracteristicas')->where('id', $id)->delete();
    }

    public static function CargarCaracteristicasFamilias($BDBACK, $id)
    {
        return DB::select("
        SELECT
        cfam.id
        , cfam.fk_caracteristica
        , cfam.fk_familia
        , coalesce(cfam.es_filtro,'NO') as es_filtro
        , tip.nombre as caract_tipo
        , carac.nombre as caract_nombre
        , cfam.valor
        FROM ".$BDBACK.".public.familias_caracteristicas as cfam
        inner join ".$BDBACK.".public.caracteristicas_productos as carac on cfam.fk_caracteristica=carac.id
        inner join ".$BDBACK.".public.caracteristicas_productos_tipos as tip on carac.tipo=tip.id
        where
        cfam.estado =true
        and cfam.fk_familia=".$id."
        ");
    }

    public static function GuardarFamiliaCaracteristica($BDBACK, $DataModel)
    {
        return DB::connection($BDBACK)->table('familias_caracteristicas')->insertGetId($DataModel);
    }

    public static function GetTipoCaracteristica($BDBACK, $id)
    {
        return DB::select("
        SELECT
        caract.id
        , caract.nombre
        , caract.estado
        , caract.tipo
        , tip.nombre as tipo_nombre
        , caract.obligatorio
        , caract.libre
        , caract.valor
        FROM ".$BDBACK.".public.caracteristicas_productos as caract
        inner join ".$BDBACK.".public. caracteristicas_productos_tipos as tip on caract.tipo=tip.id
        where caract.estado =true and caract.id=".$id."
        order by
        tip.nombre, caract.nombre
        asc
        ");
    }

    public static function CargarFormaCaracteristica($BDBACK, $id)
    {
        return DB::select("
        SELECT
        caract.id
        , caract.nombre
        , caract.estado
        , caract.tipo
        , caract.obligatorio
        , caract.libre
        , caract.valor
        , opc.id
        , opc.opcion
        FROM ".$BDBACK.".public.caracteristicas_productos AS caract
        left join ".$BDBACK.".public.caracteristicas_productos_opciones as opc on caract.id=opc.fk_caracteristica and opc.estado =true
        where
        caract.id=".$id."
        ");
    }

    public static function DeleteFamilia($id)
    {
        return DB::table('familias')->where('id', $id)->delete();
    }

    public static function GetInformacionRelacionada($id)
    {
        return DB::select("
        SELECT
        *
        FROM public.usuarios
        where
        fk_rol=".$id."
        ");
    }

    public static function DecryptMd5Familia ($id)
    {
        return DB::select("
        SELECT
        *
        FROM public.familias
        where
        MD5(MD5(id::text))='".$id."'
        ");
    }

    public static function UpdateFamilia($DataModel, $id)
    {
        return DB::table('familias')->where('id', $id)->update($DataModel);
    }

    public static function GuardarFamilia($BDBACK, $DataModel)
    {
        return DB::connection($BDBACK)->table('familias')->insertGetId($DataModel);
    }

    public static function ExisteId($id)
    {
        return DB::select("
        SELECT
        *
        FROM public.familias
        where
        id='".$id."'
        ");
    }

    public static function ExisteCodigo($dato, $id)
    {
        return DB::select("
        SELECT
        *
        FROM public.familias
        where
        id!='".$id."'
        and upper(codigo)=upper('".$dato."')
        ");
    }

    public static function ExisteNombre($dato, $id)
    {
        return DB::select("
        SELECT
        *
        FROM public.familias
        where
        id!=".$id."
        and upper(nombre)=upper('".$dato."')
        ");
    }

    public static function GetFamilia($id)
    {
        return DB::select("
        SELECT
        id
        , codigo
        , descripcion
        , nombre
        , estado
        , ruta
        , ruta2
        FROM public.familias
        where id=".$id."
        ");
    }

    public static function GetCaracteristicas($BDBACK)
    {
        return DB::select("
        SELECT
        caract.id
        , caract.nombre
        , caract.estado
        , caract.tipo
        , tip.nombre as tipo_nombre
        , caract.obligatorio
        , caract.libre
        , caract.valor
        FROM ".$BDBACK.".public.caracteristicas_productos as caract
        inner join ".$BDBACK.".public. caracteristicas_productos_tipos as tip on caract.tipo=tip.id
        where caract.estado =true
        order by
        tip.nombre, caract.nombre
        asc
        ");
    }

    public static function UpdateEstado($BDBACK, $DataModel, $id)
    {
        return DB::connection($BDBACK)->table('familias')->where('id', $id)->update($DataModel);
    }

    public static function GetList($BDBACK)
    {
        return DB::select("
        SELECT
        id
        , codigo
        , descripcion
        , nombre
        , estado
        , ruta
        , ruta2
        FROM ".$BDBACK.".public.familias as pfamilia
        order by
        nombre
        asc
        ");
    }
}
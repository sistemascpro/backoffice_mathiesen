<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantProductosSubFamilias extends Model
{

    public static function DeleteSubFamilia($id)
    {
        return DB::table('sub_familias')->where('id', $id)->delete();
    }

    public static function GetInformacionRelacionada($id)
    {
        return DB::select("
        SELECT
        *
        FROM dbo.sub_familias
        where
        fk_rol=".$id."
        ");
    }

    public static function DecryptMd5SubFamilia ($id)
    {
        return DB::select("
        SELECT
        *
        FROM public.sub_familias
        where
        id=".$id."
        ");
    }

    public static function UpdateSubFamilia($DataModel, $id)
    {
        return DB::table('sub_familias')->where('id', $id)->update($DataModel);
    }

    public static function GuardarSubFamilia($DataModel)
    {
        return DB::connection('sqlsrv')->table('sub_familias')->insertGetId($DataModel);
    }

    public static function ExisteId($id)
    {
        return DB::select("
        SELECT
        *
        FROM dbo.sub_familias
        where
        id=".$id."
        ");
    }

    public static function ExisteCodigo($dato, $id)
    {
        return DB::select("
        SELECT
        *
        FROM dbo.sub_familias
        where
        id!=".$id."
        and upper(codigo)=upper('".$dato."')
        ");
    }

    public static function ExisteNombre($dato, $id)
    {
        return DB::select("
        SELECT
        *
        FROM dbo.sub_familias
        where
        id!=".$id."
        and upper(nombre)=upper('".$dato."')
        ");
    }

    public static function GetFamilias($id)
    {
        return DB::select("
        SELECT
        familia.id
        , familia.codigo
        , familia.nombre
        , familia.estado
        , case when sfamilia.id is not null then 'selected' else '' end as selected
        FROM dbo.familias as familia
        left join dbo.sub_familias as sfamilia on familia.id=sfamilia.fk_familia and sfamilia.id=".$id."
        WHERE
        familia.estado=1
        group by
        familia.id
        , familia.codigo
        , familia.nombre
        , familia.estado
        , sfamilia.id
        , case when sfamilia.id is not null then 'selected' else '' end
        order by
        familia.codigo
        , familia.nombre
        ");
    }

    public static function GetSubFamilia($id)
    {
        return DB::select("
        SELECT
        sfamilia.id
        , sfamilia.codigo
        , sfamilia.nombre
        , sfamilia.fk_familia
        , sfamilia.estado
        , familia.id as familiaid
        , familia.nombre as familianombre
        FROM dbo.sub_familias as sfamilia
        left join dbo.familias as familia on sfamilia.fk_familia=familia.id
        where sfamilia.id=".$id."
        ");
    }

    public static function updateEstado($DataModel, $id)
    {
        return DB::table('sub_familias')->where('id', $id)->update($DataModel);
    }

    public static function GetList()
    {
        return DB::select("
        SELECT
        sfamilia.id as subfamiliaid
        , sfamilia.id
        , sfamilia.codigo
        , sfamilia.nombre
        , sfamilia.fk_familia
        , sfamilia.estado
        , familia.id as familiaid
        , familia.nombre as familianombre
        FROM dbo.sub_familias as sfamilia
        left join dbo.familias as familia on sfamilia.fk_familia=familia.id
        group by
        sfamilia.id
        , sfamilia.codigo
        , sfamilia.nombre
        , sfamilia.fk_familia
        , sfamilia.estado
        , familia.id
        , familia.nombre
        order by
        sfamilia.codigo asc
        ");
    }

}

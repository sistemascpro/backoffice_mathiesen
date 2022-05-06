<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantCodigosDescuentos extends Model
{
    public static function EliminarCliente($Id)
    {
        return DB::connection('sqlsrv')->table('codigosdescuentos_detalles')->where('id', $Id)->delete();
    }

    public static function GuardarCliente($DataModel)
    {
        return DB::connection('sqlsrv')->table('codigosdescuentos_detalles')->insertGetId($DataModel);
    }

    public static function ExisteCliente($codigo, $Id)
    {
        return DB::select("
        SELECT
        *
        FROM 
        dbo.codigosdescuentos_detalles 
        where
        fk_cliente='".$codigo."' and fk_codigo=".$Id." and RTRIM(LTRIM(usado))='NO'
        ");
    }

    public static function BuscarClientes($BD, $codigo)
    {
        return DB::select("
        SELECT 
        cli.codigo
        , cli.nombre
        FROM ".$BD.".softland.cwtauxi as cli 
        where
        cli.codigo LIKE '%".$codigo."%'
        or cli.nombre LIKE '%".$codigo."%'
        order by 
        cli.nombre asc
        ");
    }

    public static function CargarDetalle($BD, $Id)
    {
        return DB::select("
        SELECT 
        deta.id
        , deta.fk_codigo
        , deta.fk_cliente
        , deta.usado
        , cli.codigo
        , cli.nombre
        FROM dbo.codigosdescuentos_detalles as deta
        inner join ".$BD.".softland.cwtauxi as cli on deta.fk_cliente collate database_default = cli.codigo collate database_default
        where
        deta.fk_codigo=".$Id."
        order by 
        deta.id desc
        ");
    }

    public static function UpdateCodigo($DataModel, $Id)
    {
        return DB::table('codigosdescuentos')->where('id', $Id)->update($DataModel);
    }

    public static function Guardar($DataModel)
    {
        return DB::connection('sqlsrv')->table('codigosdescuentos')->insertGetId($DataModel);
    }

    public static function ExisteCodigo($Codigo, $Id)
    {
        return DB::select("
        SELECT
        *
        FROM 
        dbo.codigosdescuentos 
        where
        codigo='".$Codigo."' and id!=".$Id."
        ");
    }

    public static function GetDetalle($id)
    {
        return DB::select("
        SELECT
        id
        , codigo
        , descripcion
        , valor
        , CONCAT(SUBSTRING(fecha1,7,4),'-',SUBSTRING(fecha1,4,2),'-',SUBSTRING(fecha1,1,2)) as fecha1
        , CONCAT(SUBSTRING(fecha2,7,4),'-',SUBSTRING(fecha2,4,2),'-',SUBSTRING(fecha2,1,2)) as fecha2
        FROM dbo.codigosdescuentos 
        where
        id=".$id."
        ");
    }

    public static function GetList()
    {
        return DB::select("
        SELECT
        cdesc.id
        , cdesc.codigo
        , cdesc.descripcion
        , cdesc.valor
        , cdesc.fecha1
        , cdesc.fecha2
        , count(cdet.id) as clientes
        FROM dbo.codigosdescuentos as cdesc
        left join dbo.codigosdescuentos_detalles as cdet on cdesc.id=cdet.fk_codigo
        group by 
        cdesc.id
        , cdesc.codigo
        , cdesc.descripcion
        , cdesc.valor
        , cdesc.fecha1
        , cdesc.fecha2
        ");
    }

}

<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantClientes extends Model
{
    public static function ExisteEmailRegistro($DB, $Email)
    {
        return DB::select("
        SELECT
        *
        FROM ".$DB.".dbo.usuarios
        where RTRIM(LTRIM(UPPER(email)))=RTRIM(LTRIM(UPPER('".$Email."')))
        ");
    }

    public static function UpdateUsuario($DataModel, $UsuarioId)
    {
        return DB::table('usuarios')->where(DB::raw("CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(id as varchar(max))),2) ),2)"), $UsuarioId)->update($DataModel);
    }

    public static function GetUsuarioMd5($id)
    {
        return DB::select("
        SELECT
        CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(usu.id as varchar(max))),2) ),2) as id_md5
        , usu.id
        , usu.estado
        , usu.rut
        , usu.nombres
        , usu.apellidos
        , usu.telefono1
        , coalesce(usu.telefono2,'') as telefono2
        , usu.email
        , usu.contrasenia
        , LEFT(CONVERT(VARCHAR, usu.fechaCreacion, 120), 10) as fecha_creacion
        , LEFT(CONVERT(VARCHAR, usu.fechaActualizacion, 120), 10) as fecha_actualizacion
        , usu.usuario
        , usu.avatar
        FROM dbo.usuarios as usu
        where
        CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(usu.id as varchar(max))),2) ),2)='".$id."'
        ");
    }

    public static function GuardarRelacionUsuario($DataModel)
    {
        return DB::connection('sqlsrv')->table('clientes_usuarios')->insertGetId($DataModel);
    }

    public static function GetUsuarioRut($Rut)
    {
        return DB::select("
        SELECT
        *
        FROM dbo.usuarios
        where rut='".$Rut."'
        ");
    }

    public static function GuardarUsuario($DataModel)
    {
        return DB::connection('sqlsrv')->table('usuarios')->insertGetId($DataModel);
    }

    public static function ExisteId($id)
    {
        return DB::select("
        SELECT
        *
        FROM dbo.usuarios
        where
        CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(id as varchar(max))),2) ),2)!='".$id."'
        ");
    }

    public static function ExisteRut($dato, $id)
    {
        return DB::select("
        SELECT
        *
        FROM dbo.usuarios
        where
        CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(id as varchar(max))),2) ),2)!='".$id."'
        and upper(rut)=upper('".$dato."')
        ");
    }

    public static function ExisteEmail($dato, $id)
    {
        return DB::select("
        SELECT
        *
        FROM dbo.usuarios
        where
        CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(id as varchar(max))),2) ),2)!='".$id."'
        and upper(email)=upper('".$dato."')
        ");
    }

    public static function ExisteUsuario($dato, $id)
    {
        return DB::select("
        SELECT
        *
        FROM dbo.usuarios
        where
        CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(id as varchar(max))),2) ),2)!='".$id."'
        and upper(usuario)=upper('".$dato."')
        ");
    }

    public static function GetUsuariosNoCliente($id)
    {
        return DB::select("
        SELECT
        CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(usu.id as varchar(max))),2) ),2) as id_md5
        , usu.id
        , usu.estado
        , usu.rut
        , usu.nombres
        , usu.apellidos
        , usu.telefono1
        , coalesce(usu.telefono2,'') as telefono2
        , usu.email
        , usu.contrasenia
        , LEFT(CONVERT(VARCHAR, usu.fechaCreacion, 120), 10) as fecha_creacion
        , LEFT(CONVERT(VARCHAR, usu.fechaActualizacion, 120), 10) as fecha_actualizacion
        , usu.fk_rol
        , rol.nombre as rol_nombre
        , usu.usuario
        , usu.avatar
        FROM dbo.usuarios as usu
        left join dbo.clientes_usuarios as cli_usu on cli_usu.fk_cliente='".$id."' and usu.id=cli_usu.fk_usuario
        left join dbo.roles as rol on usu.fk_rol=rol.id
        where
        cli_usu.id is null and usu.fk_rol=3
        ");
    }

    public static function GetUsuariosCliente($id)
    {
        return DB::select("
        SELECT
        CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(usu.id as varchar(max))),2) ),2) as id_md5
        , usu.id
        , usu.estado
        , usu.rut
        , usu.nombres
        , usu.apellidos
        , usu.telefono1
        , coalesce(usu.telefono2,'') as telefono2
        , usu.email
        , usu.contrasenia
        , usu.fk_rol
        , rol.nombre as rol_nombre
        , usu.usuario
        , usu.avatar
        FROM dbo.clientes_usuarios as cli_usu
        inner join dbo.usuarios as usu on cli_usu.fk_usuario=usu.id
        inner join dbo.roles as rol on usu.fk_rol=rol.id
        where cli_usu.fk_cliente='".$id."'
        ");
    }

    public static function GetCliente($Bd, $id)
    {
        return DB::select("
        SELECT
        *
        FROM
        ".$Bd.".dbo.clientes
        where
        codigo='".$id."'
        ");
    }

    public static function updateEstado($DataModel, $id)
    {
        return DB::table('usuarios')->where('id', $id)->update($DataModel);
    }

    public static function GetList($Bd)
    {
        return DB::select("
        SELECT
        codigo
        , nombre
        , email
        , telefono
        FROM ".$Bd.".dbo.clientes
        order by nombre asc
        ");
    }

}

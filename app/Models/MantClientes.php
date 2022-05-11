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
        FROM ".$DB.".public.usuarios
        where RTRIM(LTRIM(UPPER(email)))=RTRIM(LTRIM(UPPER('".$Email."')))
        ");
    }

    public static function UpdateUsuario($DataModel, $UsuarioId)
    {
        return DB::table('usuarios')->where('id', $UsuarioId)->update($DataModel);
    }

    public static function GetUsuarioMd5($id)
    {
        return DB::select("
        SELECT
        usu.id as id_md5
        , usu.id
        , usu.estado
        , usu.rut
        , usu.nombres
        , usu.apellidos
        , usu.telefono1
        , coalesce(usu.telefono2,'') as telefono2
        , usu.email
        , usu.contrasenia
        , usu.fechacreacion as fecha_creacion
        , usu.fechaactualizacion as fecha_actualizacion
        , usu.usuario
        FROM public.usuarios as usu
        where
        usu.id='".$id."'
        ");
    }

    public static function GuardarRelacionUsuario($DataModel)
    {
        return DB::connection('pgsql')->table('clientes_usuarios')->insertGetId($DataModel);
    }

    public static function GetUsuarioRut($Rut)
    {
        return DB::select("
        SELECT
        *
        FROM public.usuarios
        where rut='".$Rut."'
        ");
    }

    public static function GuardarRelacionCliente($DataModel)
    {
        return DB::connection('pgsql')->table('clientes_usuarios')->insertGetId($DataModel);
    }

    public static function GuardarCliente($DataModel)
    {
        return DB::connection('pgsql')->table('clientes')->insertGetId($DataModel);
    }

    public static function GuardarUsuario($DataModel)
    {
        return DB::connection('pgsql')->table('usuarios')->insertGetId($DataModel);
    }

    public static function ExisteId($id)
    {
        return DB::select("
        SELECT
        *
        FROM public.usuarios
        where
        id!='".$id."'
        ");
    }

    public static function ExisteRut($dato, $id)
    {
        return DB::select("
        SELECT
        *
        FROM public.usuarios
        where
        id!='".$id."'
        and upper(rut)=upper('".$dato."')
        ");
    }

    public static function ExisteEmail($dato, $id)
    {
        return DB::select("
        SELECT
        *
        FROM public.usuarios
        where
        id!='".$id."'
        and upper(email)=upper('".$dato."')
        ");
    }

    public static function ExisteUsuario($dato, $id)
    {
        return DB::select("
        SELECT
        *
        FROM public.usuarios
        where
        id!='".$id."'
        and upper(usuario)=upper('".$dato."')
        ");
    }

    public static function GetUsuariosNoCliente($id)
    {
        return DB::select("
        SELECT
        usu.id
        , usu.estado
        , usu.rut
        , usu.nombres
        , usu.apellidos
        , usu.telefono1
        , coalesce(usu.telefono2,'') as telefono2
        , usu.email
        , usu.contrasenia
        , usu.fechacreacion as fecha_creacion
        , usu.fechaactualizacion as fecha_actualizacion
        , usu.fk_rol
        , rol.nombre as rol_nombre
        , usu.usuario
        FROM public.usuarios as usu
        left join public.clientes_usuarios as cli_usu on cli_usu.fk_cliente='".$id."' and usu.id=cli_usu.fk_usuario
        left join public.roles as rol on usu.fk_rol=rol.id
        where
        cli_usu.id is null and usu.fk_rol=3
        ");
    }

    public static function GetUsuariosCliente($id)
    {
        return DB::select("
        SELECT
        usu.id
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
        FROM public.clientes_usuarios as cli_usu
        inner join public.usuarios as usu on cli_usu.fk_usuario=usu.id
        inner join public.roles as rol on usu.fk_rol=rol.id
        where cli_usu.fk_cliente='".$id."'
        ");
    }

    public static function GetRolCliente($Bd)
    {
        return DB::select("
        SELECT
        id
        FROM
        ".$Bd.".public.roles
        where
        UPPER(nombre)='CLIENTE'
        ");
    }
    public static function GetCliente($Bd, $id)
    {
        return DB::select("
        SELECT
        *
        FROM
        ".$Bd.".public.clientes
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
        FROM ".$Bd.".public.clientes
        order by nombre asc
        ");
    }

}

<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantUsuarios extends Model
{
    public static function GetListUsuariosClientes()
    {
        return DB::select("
        SELECT
        usu.id
        , usu.usuario
        FROM public.usuarios as usu
        where usu.fk_rol=6
        ");
    }

    public static function UpdateUsuariosContrasenasClientes($DataModel, $ID)
    {
        return DB::table('usuarios')->where('id', $ID)->update($DataModel);
    }

    public static function UpdateUsuario($DataModel, $UsuarioId)
    {
        return DB::table('usuarios')->where('id', $UsuarioId)->update($DataModel);
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

    public static function GetRoles($id)
    {
        return DB::select("
        SELECT
        rol.id
        , rol.estado
        , rol.nombre
        , case when usu.id is not null then 'selected' else '' end as selected
        FROM public.roles as rol
        left join public.usuarios as usu on rol.id=usu.fk_rol and usu.id=".$id."
        ");
    }

    public static function GetUsuario($id)
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
        , usu.habilitado
        FROM public.usuarios as usu
        inner join public.roles as rol on usu.fk_rol=rol.id
        where usu.id=".$id."
        order by usu.nombres asc
        ");
    }

    public static function updateEstado($DataModel, $id)
    {
        return DB::table('usuarios')->where('id', $id)->update($DataModel);
    }

    public static function GetList()
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
        , usu.habilitado
        FROM public.usuarios as usu
        inner join public.roles as rol on usu.fk_rol=rol.id
        order by usu.nombres asc
        ");
    }

}

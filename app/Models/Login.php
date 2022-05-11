<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    public static function ValidatePermiso($Rol, $Menu)
    {
        return DB::select("
        SELECT
        *
        FROM public.roles_permisos as rol
        inner join public.menu as men on rol.fk_menu=men.id
        inner join public.roles as rols on rol.fk_rol=rols.id

        where
        rols.nombre='".$Rol."'
        and men.url='".$Menu."'
        ");
    }

    public static function GetPermisos($BDBACK, $id)
    {
        return DB::select("
        SELECT
        men.id
        , men.nombre
        , men.permiso
        , men.padre
        , men.url
        , men.estado
        , men.alt
        , men.icono
        , men.posicion
        FROM ".$BDBACK.".public.roles_permisos as per
        inner join ".$BDBACK.".public.menu as men on per.fk_menu=men.id
        inner join ".$BDBACK.".public.roles as rol on per.fk_rol=rol.id
        where
        rol.nombre='".$id."'
        group by
        men.id
        , men.nombre
        , men.permiso
        , men.padre
        , men.url
        , men.estado
        , men.alt
        , men.icono
        , men.posicion
        order by
        men.posicion
        asc
        ");
    }

    public static function ValidateUsuario($BDBACK, $user, $password)
    {
        return DB::select("
        SELECT
        usu.id
        , usu.estado
        , usu.rut
        , usu.nombres
        , usu.apellidos
        , usu.telefono1
        , usu.telefono2
        , usu.email
        , usu.contrasenia
        , rol.nombre as fk_rol
        , usu.usuario
        , rol.nombre as rol_nombre
        FROM ".$BDBACK.".public.usuarios as usu
        inner join ".$BDBACK.".public.roles as rol on usu.fk_rol=rol.id and rol.estado =true
        where
        usu.usuario='".$user."'
        and usu.contrasenia='".$password."'
        and usu.estado =true
        and usu.habilitado='SI'
        ");
    }
}

<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantRoles extends Model
{

    public static function DeleteRol($RolId)
    {
        return DB::table('roles')->where('id', $RolId)->delete();
    }

    public static function GetUsuariosConRol($Rol)
    {
        return DB::select("
        SELECT
        *
        FROM public.usuarios
        where
        fk_rol=".$Rol."
        ");
    }

    public static function DecryptMd5Rol($id)
    {
        return DB::select("
        SELECT
        *
        FROM public.roles
        where
        id=".$id."
        ");
    }

    public static function DeleteSubClasesMd5($RolId)
    {
        return DB::table('roles_clases')->where('fk_rol', $RolId)->delete();
    }

    public static function DeleteVendedoresMd5($RolId)
    {
        return DB::table('roles_vendedores')->where('fk_rol', $RolId)->delete();
    }

    public static function DeletePermisosMd5($RolId)
    {
        return DB::table('roles_permisos')->where('fk_rol', $RolId)->delete();
    }

    public static function UpdateRol($DataModel, $RolId)
    {
        return DB::table('roles')->where('id', $RolId)->update($DataModel);
    }

    public static function GuardarSubClase($DataModel)
    {
        return DB::connection('pgsql')->table('roles_clases')->insertGetId($DataModel);
    }

    public static function GuardarVendedor($DataModel)
    {
        return DB::connection('pgsql')->table('roles_vendedores')->insertGetId($DataModel);
    }

    public static function GuardarPermisos($DataModel)
    {
        return DB::connection('pgsql')->table('roles_permisos')->insertGetId($DataModel);
    }

    public static function DeleteSubClase($RolId)
    {
        return DB::table('roles_clases')->where('fk_rol', $RolId)->delete();
    }

    public static function DeleteVendedores($RolId)
    {
        return DB::table('roles_vendedores')->where('fk_rol', $RolId)->delete();
    }

    public static function DeletePermisos($RolId)
    {
        return DB::table('roles_permisos')->where('fk_rol', $RolId)->delete();
    }

    public static function GuardarRol($DataModel)
    {
        return DB::connection('pgsql')->table('roles')->insertGetId($DataModel);
    }

    public static function ExisteId($id)
    {
        return DB::select("
        SELECT
        *
        FROM public.roles
        where
        id!='".$id."'
        ");
    }

    public static function ExisteNombre($dato, $id)
    {
        return DB::select("
        SELECT
        *
        FROM public.roles
        where
        id!='".$id."'
        and upper(nombre)=upper('".$dato."')
        ");
    }

    public static function GetClasesProductos($id)
    {
        return DB::select("
        SELECT
        pclass.id as claseid
        , pclass.codigo as clasecodigo
        , pclass.nombre as clasenombre
        , pclass.estado as claseestado
        , psclass.id as subclaseid
        , psclass.codigo as subclasecodigo
        , psclass.nombre as subclasenombre
        , case when rolcass.id is not null then 'checked' else '' end as checked
        FROM public.productos_clases as pclass
        INNER join public.productos_sub_clases as psclass on pclass.id=psclass.fk_clase
        left join public.roles_clases as rolcass on psclass.id=rolcass.fk_subclase and rolcass.fk_rol=".$id."
        ORDER BY
        pclass.codigo
        , pclass.nombre
        , pclass.estado
        , psclass.codigo
        , psclass.nombre
        asc
        ");
    }

    public static function GetVendedores($id)
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
        , usu.\"fechacreacion\"
        , usu.\"fechaactualizacion\"
        , usu.fk_rol
        , usu.usuario
        , usu.fk_responsable
        , case when rol.id is not null then 'checked' else '' end as checked
        FROM public.usuarios as usu
        left join public.roles_vendedores as rol on usu.id=rol.fk_vendedor and rol.fk_rol=".$id."
        where
        usu.fk_rol=2
        group by
        usu.id
        , usu.estado
        , usu.rut
        , usu.nombres
        , usu.apellidos
        , usu.telefono1
        , usu.telefono2
        , usu.email
        , usu.contrasenia
        , usu.\"fechacreacion\"
        , usu.\"fechaactualizacion\"
        , usu.fk_rol
        , usu.usuario
        , usu.fk_responsable
        , case when rol.id is not null then 'checked' else '' end
        order by concat(usu.nombres,' ',usu.apellidos) asc
        ");
    }

    public static function GetPermisos($id)
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
        , case when per.fk_rol is not null then 'checked' else '' end as checked
        FROM public.menu as men
        left join public.roles_permisos as per on men.id=per.fk_menu and per.fk_rol=".$id."
        group by
        men.id
        , men.nombre
        , men.permiso
        , men.padre
        , men.url
        , men.estado
        , men.alt
        , men.icono
        , case when per.fk_rol is not null then 'checked' else '' end
        order by men.permiso asc
        ");
    }

    public static function GetRol($id)
    {
        return DB::select("
        SELECT
        id
        , estado
        , nombre
        FROM public.roles
        where id=".$id."
        ");
    }

    public static function updateEstado($DataModel, $id)
    {
        return DB::table('roles')->where('id', $id)->update($DataModel);
    }

    public static function GetList()
    {
        return DB::select("
        SELECT
        rol.id
        , rol.estado
        , rol.nombre
        , count(per.id) as cantidad
        FROM public.roles as rol
        left join public.roles_permisos as per on rol.id=per.fk_rol
        group by
        rol.id
        , rol.estado
        , rol.nombre
        order by
        rol.nombre
        asc
        ");
    }

}

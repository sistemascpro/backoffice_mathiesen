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
        FROM dbo.usuarios
        where
        fk_rol=".$Rol."
        ");
    }

    public static function DecryptMd5Rol($id)
    {
        return DB::select("
        SELECT
        *
        FROM dbo.roles
        where
        CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(id as varchar(max))),2) ),2)='".$id."'
        ");
    }

    public static function DeleteSubClasesMd5($RolId)
    {
        return DB::table('roles_clases')->where(DB::raw("CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(fk_rol as varchar(max))),2) ),2)"), $RolId)->delete();
    }

    public static function DeleteVendedoresMd5($RolId)
    {
        return DB::table('roles_vendedores')->where(DB::raw("CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(fk_rol as varchar(max))),2) ),2)"), $RolId)->delete();
    }

    public static function DeletePermisosMd5($RolId)
    {
        return DB::table('roles_permisos')->where(DB::raw("CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(fk_rol as varchar(max))),2) ),2)"), $RolId)->delete();
    }

    public static function UpdateRol($DataModel, $RolId)
    {
        return DB::table('roles')->where(DB::raw("CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(id as varchar(max))),2) ),2)"), $RolId)->update($DataModel);
    }

    public static function GuardarSubClase($DataModel)
    {
        return DB::connection('sqlsrv')->table('roles_clases')->insertGetId($DataModel);
    }

    public static function GuardarVendedor($DataModel)
    {
        return DB::connection('sqlsrv')->table('roles_vendedores')->insertGetId($DataModel);
    }

    public static function GuardarPermisos($DataModel)
    {
        return DB::connection('sqlsrv')->table('roles_permisos')->insertGetId($DataModel);
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
        return DB::connection('sqlsrv')->table('roles')->insertGetId($DataModel);
    }

    public static function ExisteId($id)
    {
        return DB::select("
        SELECT
        *
        FROM dbo.roles
        where
        CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(id as varchar(max))),2) ),2)!='".$id."'
        ");
    }

    public static function ExisteNombre($dato, $id)
    {
        return DB::select("
        SELECT
        *
        FROM dbo.roles
        where
        CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(id as varchar(max))),2) ),2)!='".$id."'
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
        FROM dbo.productos_clases as pclass
        INNER join dbo.productos_sub_clases as psclass on pclass.id=psclass.fk_clase
        left join dbo.roles_clases as rolcass on psclass.id=rolcass.fk_subclase and rolcass.fk_rol=".$id."
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
        , usu.\"fechaCreacion\"
        , usu.\"fechaActualizacion\"
        , usu.fk_rol
        , usu.usuario
        , usu.avatar
        , usu.fk_responsable
        , case when rol.id is not null then 'checked' else '' end as checked
        FROM dbo.usuarios as usu
        left join dbo.roles_vendedores as rol on usu.id=rol.fk_vendedor and rol.fk_rol=".$id."
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
        , usu.\"fechaCreacion\"
        , usu.\"fechaActualizacion\"
        , usu.fk_rol
        , usu.usuario
        , usu.avatar
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
        FROM dbo.menu as men
        left join dbo.roles_permisos as per on men.id=per.fk_menu and per.fk_rol=".$id."
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
        CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(id as varchar(max))),2) ),2) as rolid
        , estado
        , nombre
        FROM dbo.roles
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
        FROM dbo.roles as rol
        left join dbo.roles_permisos as per on rol.id=per.fk_rol
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

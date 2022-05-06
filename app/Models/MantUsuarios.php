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
        FROM dbo.usuarios as usu
        where usu.fk_rol=6
        ");
    }
    
    public static function UpdateUsuariosContrasenasClientes($DataModel, $ID)
    {
        return DB::table('usuarios')->where('id', $ID)->update($DataModel);
    }

    public static function UpdateUsuario($DataModel, $UsuarioId)
    {
        return DB::table('usuarios')->where(DB::raw("CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(id as varchar(max))),2) ),2)"), $UsuarioId)->update($DataModel);
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

    public static function GetRoles($id)
    {
        return DB::select("
        SELECT
        rol.id
        , rol.estado
        , rol.nombre
        , case when usu.id is not null then 'selected' else '' end as selected
        FROM dbo.roles as rol
        left join dbo.usuarios as usu on rol.id=usu.fk_rol and usu.id=".$id."
        ");
    }

    public static function GetUsuario($id)
    {
        return DB::select("
        SELECT
        CONVERT(NVARCHAR(32),HashBytes('MD5',   CONVERT(NVARCHAR(32),HashBytes('MD5', cast(usu.id as varchar(max))),2) ),2) as usuarioid
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
        , usu.habilitado
        , isnull(usu.avatar,'img/usuarios/NoneUser.jpg') as avatar
        FROM dbo.usuarios as usu
        inner join dbo.roles as rol on usu.fk_rol=rol.id
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
        , LEFT(CONVERT(VARCHAR, usu.fechaCreacion, 120), 10) as fecha_creacion
        , LEFT(CONVERT(VARCHAR, usu.fechaActualizacion, 120), 10) as fecha_actualizacion
        , usu.fk_rol
        , rol.nombre as rol_nombre
        , usu.usuario
        , usu.habilitado
        , isnull(usu.avatar,'img/usuarios/NoneUser.jpg') as avatar
        FROM dbo.usuarios as usu
        inner join dbo.roles as rol on usu.fk_rol=rol.id
        order by usu.nombres asc
        ");
    }

}

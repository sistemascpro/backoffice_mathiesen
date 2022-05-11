<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class UsuarioPerfil extends Model
{
    public static function updateInformacion($DataModel, $id)
    {
        return DB::table('usuarios')->where('id', $id)->update($DataModel);
    }

    public static function UpdateContrasenia($DataModel, $id)
    {
        return DB::table('usuarios')->where('id', $id)->update($DataModel);
    }

    public static function GetUsuario($id)
    {
        return DB::select("
        SELECT
        *
        FROM public.usuarios as usu
        where
        usu.id=".$id."
        ");
    }

}

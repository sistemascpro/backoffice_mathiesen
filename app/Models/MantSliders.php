<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantSliders extends Model
{
    public static function Eliminar($id)
    {
        return DB::connection('pgsql')->table('sliders')->where('id', $id)->delete();
    }

    public static function Guardar($DataModel)
    {
        return DB::connection('pgsql')->table('sliders')->insertGetId($DataModel);
    }


    public static function GetList($BDBACK)
    {
        return DB::select("
        SELECT
        *
        FROM
        ".$BDBACK.".public.sliders
        order by id desc
        ");
    }

}

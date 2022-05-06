<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantSliders extends Model
{
    public static function Eliminar($BDBACK, $id)
    {
        return DB::connection($BDBACK)->table('sliders')->where('id', $id)->delete();
    }

    public static function Guardar($BDBACK, $DataModel)
    {
        return DB::connection($BDBACK)->table('sliders')->insertGetId($DataModel);
    }

    public static function GetList($BDBACK)
    {
        return DB::select("
        SELECT 
        *
        FROM 
        ".$BDBACK.".dbo.sliders
        order by id desc
        ");
    }

}

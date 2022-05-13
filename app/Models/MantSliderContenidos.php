<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantSliderContenidos extends Model
{
    public static function Eliminar($id)
    {
        return DB::connection('pgsql')->table('sliders_contenidos')->where('id', $id)->delete();
    }

    public static function UpdateSlider($DataModel, $NoticiaId)
    {
        return DB::table('sliders_contenidos')->where(DB::raw("id"), $NoticiaId)->update($DataModel);
    }

    public static function Guardar($DataModel)
    {
        return DB::connection('pgsql')->table('sliders_contenidos')->insertGetId($DataModel);
    }

    public static function GetSlider($id)
    {
        return DB::select("
        SELECT
        *
        FROM public.sliders_contenidos
        where id=".$id."
        ");
    }

    public static function GetList($BDBACK)
    {
        return DB::select("
        SELECT 
        *
        FROM ".$BDBACK.".public.sliders_contenidos
        order by id asc
        ");
    }

}

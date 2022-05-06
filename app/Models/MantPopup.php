<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class MantPopup extends Model
{
    public static function Guardar($DataModel)
    {
        return DB::table('popup')->where('id', '1')->update($DataModel);
    }

    public static function GetList()
    {
        return DB::select("
        SELECT
        *
        FROM dbo.popup
        ");
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\GeneralModel;
use App\Models\Login;

class EcoHome_Controller extends BaseController
{

    public function index(Request $req) {
        
        return view('eco_home.index', [
            'NombreEmpresa' => GeneralModel::GetNombreEmpresa('backoffice_mathiesen_new')
        ]);

    }

}

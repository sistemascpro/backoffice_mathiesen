<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\UrlBaseTrait;
use App\Http\Traits\SwitchUsuarioRolTrait;
use Response;
use Validator;
use Mail;
use App\Models\MantClientes;
use Illuminate\Http\Request;

class SendMail_Controller extends Controller
{
    public function EnviarCorreoContacto(Request $req)
    {
        try {
            $EstadoEnvio=0;
            $data['ContNombre']     = $_POST['ContNombre'];
            $data['ContPais']   = $_POST['ContPais'];
            $data['ContEmail']     = $_POST['ContEmail'];
            $data['ContTelefono']    = $_POST['ContTelefono'];
            $data['ContAsunto']    = $_POST['ContAsunto'];
            $data['ContIndustria']    = $_POST['ContIndustria'];
            $data['ContMensaje']    = $_POST['ContMensaje'];
            /*
            $Correos[0] = 'contacto.mathiesen@grupomathiesen.com';
            $Correos[1] = $_POST['ContEmail'];
            */
            $Correos[0] = 'edo.v81@gmail.com';
            $Correos[1] = 'ssalom@grupomathiesen.com';
            Mail::send('eco_sendmail.SendMailContacto1', $data, function($message) use ($Correos, $data){
            $message->from('contacto.mathiesen@grupomathiesen.com', $data['ContNombre']);
            $message->to($Correos, $data['ContAsunto']);
            $message->subject($data['ContAsunto'].' - '.date("Y-m-d H:i:s", time() - 14400));
            });
            return "OK";
        }
        catch (Exception $e) 
        {
            return "ERROR";
        }
    }


    public function EnviarRegistro(Request $req)
    {
        $DatosGen = app('App\Http\Controllers\Home_Controller')->DatosGen($req);

        if( count(MantClientes::ExisteEmailRegistro($DatosGen['NombreEmpresa'][0]->bdbackoffice, $_POST['RegEmail']))>0 )
        {
            return "EL EMAIL YA ESTA REGISTRADO";
        }
        else
        {
            $EstadoEnvio = 0;
            $error="";

            $DataModel = [
              'estado'        => 1,
              'usuario'       => $_POST['RegEmail'],
              'contrasenia'   => md5(strtolower($_POST['RegContrasenia1'])),
              'fk_rol'        => 3,
              'rut'           => null,
              'nombres'       => $_POST['RegNombre'],
              'apellidos'     => $_POST['RegApellido'],
              'telefono1'     => $_POST['RegTelefono'],
              'telefono2'     => $_POST['RegTelefono'],
              'email'         => $_POST['RegEmail'],
              'fechacreacion'         => app('App\Http\Controllers\Home_Controller')->GetDateTime(),
              'fechaactualizacion'    =>  app('App\Http\Controllers\Home_Controller')->GetDateTime(),
              'fk_responsable'        => 1,
              'habilitado'            => 'PENDIENTE',
            ];

            $UserId = MantClientes::GuardarUsuario($DataModel);

            $DataModel = [
                'codigo'                => $_POST['RegEmail'],
                'sucursar'              => '',
                'nombre'                => $_POST['RegNombre'],
                'tipocliente'           => '',
                'giro'                  => '',
                'direccion'             => '',
                'direcciondespacho'     => '',
                'comuna'                => '',
                'ciudad'                => '',
                'pais'                  => '',
                'vendedor'              => '',
                'formapago'              => '',
                'listaprecio'           => 0,
                'nombrelistaprecio'     => '',
                'contacto'              => '',
                'telefono'              => '',
                'email'                 => '',
                'comentarios'           => '',
            ];

            $ClienteId = MantClientes::GuardarCliente($DataModel);

            $DataModel = [
            'fk_cliente'        => $ClienteId,
            'fk_usuario'        => $UserId,
            ];

            MantClientes::GuardarRelacionCliente($DataModel);

            $data['RegEmail']       = $_POST['RegEmail'];
            $data['RegEmpresa']     = $_POST['RegEmpresa'];
            $data['RegNombre']      = $_POST['RegNombre'];
            $data['RegApellido']    = $_POST['RegApellido'];
            $data['RegTelefono']    = $_POST['RegTelefono'];
            $data['RegEmail']       = $_POST['RegEmail'];
            $data['RegTipo']        = $_POST['RegTipo'];
            //$Correos[0] = 'contacto.mathiesen@grupomathiesen.com';
            try{
            $Correos[0] = 'edo.v81@gmail.com';
            Mail::send('eco_sendmail.SendMailContacto1Cliente', $data, function($message) use ($Correos, $data){
                $message->from('contacto.mathiesen@grupomathiesen.com', 'MATHIESEN');
                $message->to($Correos, 'Registro Cliente');
                $message->subject('Registro Cliente'.' - '.date("Y-m-d H:i"));
            });

            $Correos[0] =  $_POST['RegEmail'];
            Mail::send('eco_sendmail.SendMailContacto2Cliente', $data, function($message) use ($Correos, $data){
                $message->from('contacto.mathiesen@grupomathiesen.com', 'MATHIESEN');
                $message->to($Correos, 'Registro Cliente');
                $message->subject('Registro Cliente'.' - '.date("Y-m-d H:i"));
            });
            }catch (Exception $e) 
            {

            }

            return "OK";
        }
        
    }

}


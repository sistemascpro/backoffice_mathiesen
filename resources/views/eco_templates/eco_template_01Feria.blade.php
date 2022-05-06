<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}" readonly>
    <input type="hidden" name="cliente_codigo"  id="cliente_codigo" value="<?=$DatosGen['Session']->get('cliente_codigo')?>" readonly>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?=$DatosGen['NombreEmpresa'][0]->nombre?></title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/ionicons.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/simple-line-icons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/jquery-ui.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/plugins.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/theme-d8d06b13.css') }}"/>
    <link rel="stylesheet" href="assets/css/style.min.css" />
</head>
<body style="background:#F2F2F2">
<input type="hidden" id="Codigo" name="Codigo" value="<?=$Codigo?>" readonly/>
<input type="hidden" id="Order" name="Order" value="<?=$Order?>" readonly/>
<input type="hidden" id="Type" name="Type" value="<?=$Type?>" readonly/>
<input type="hidden" id="Texto" name="Texto" value="<?=$Texto?>" readonly/>
<input type="hidden" id="OrderCant" name="OrderCant" value="<?=$OrderCant?>" readonly/>
<div id="ModalSingleProduct" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="OcultarModalProducto();">CERRAR</button>
        </div>
      <div id="ModalSingleProductContent" class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="OcultarModalProducto();">CERRAR</button>
      </div>
    </div>
  </div>
</div>
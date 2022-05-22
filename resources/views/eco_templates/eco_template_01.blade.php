<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}">
    <input type="hidden" name="cliente_codigo"  id="cliente_codigo" value="<?=$DatosGen['Session']->get('cliente_codigo')?>">
    <input type="hidden" name="CantSliderContenido" name="CantSliderContenido" value="<?php if( isset($DatosGen['SliderContenidos']) ) { echo count($DatosGen['SliderContenidos']);} else { echo "0"; } ?>"
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?=$DatosGen['NombreEmpresa'][0]->nombre?></title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico" />

    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/style.css?<?=date("YmdHis")?>"/>
    <link rel="stylesheet" href="css/icon.css?<?=date("YmdHis")?>"/>
    <link rel="stylesheet" href="css/searchBar.css?<?=date("YmdHis")?>"/>
    <link rel="stylesheet" href="css/searchBarPlp.css?<?=date("YmdHis")?>"/>
    <link rel="stylesheet" href="css/font-awesome.min.css?<?=date("YmdHis")?>"/>
    <link rel="stylesheet" href="css/controls.css?<?=date("YmdHis")?>"/>
    <link rel="stylesheet" href="css/widgetSelect.css?<?=date("YmdHis")?>"/>
    <link rel="stylesheet" href="css/themes/default/default.css?<?=date("YmdHis")?>"/>
    <link rel="stylesheet" href="css/nivo-slider.css?<?=date("YmdHis")?>"/>
    
</head>

<body>
    @include("layouts.ecommerce_menumobil")
    @include("layouts.ecommerce_header")
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}">
    <meta name="description" content="" />
    <title><?=$NombreEmpresa[0]->nombre?></title>
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
<body>
    @include("layouts.ecommerce_menumobil")
    @include("layouts.ecommerce_header")
    <div id="eco_productos">
        @include("layouts.ecommerce_slider")
        @include("layouts.ecommerce_banners1")
        @include("layouts.ecommerce_productos1")
        @include("layouts.ecommerce_banners2")
        @include("layouts.ecommerce_productos2")
        @include("layouts.ecommerce_seccionroja")
        @include("layouts.ecommerce_banners1")
    </div>
    @include("layouts.ecommerce_footer")
    @include("layouts.ecommerce_modals")
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/js/vendor/jquery-migrate-3.3.2.min.js"></script>
    <script src="assets/js/vendor/modernizr-3.7.1.min.js"></script>
    <script src="assets/js/plugins/jquery-ui.min.js"></script>
    <script src="assets/js/plugins/plugins.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/js/eco_header.js"></script>
</body>
</html>

<!doctype html>
<html lang="en">


<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}">
	<!--favicon-->
	<link rel="icon" href="{{ asset('assets/images/favicon-32x32.png') }}" type="image/png" />
	<!--plugins-->
	@yield("style")

    <link rel="stylesheet" href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/pace.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/icons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/personalizado.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/css2.css?family=Roboto:wght@400;500&display=swap') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}"  />
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}"  />

    <title>BackOffice</title>
</head>
<body>
	<!--wrapper-->
	<div class="wrapper">
        <div id="Toaster" class="toast position-fixed bottom-0 end-0 p-3" style="z-index: 5;">
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            <div class="toast-body" id="ToastBody"></div>
        </div>
		<!--start header -->
		@include("layouts.header")
		<!--navigation-->
		@include("layouts.nav")
		<!--end navigation-->
		<!--start page wrapper -->
		@yield("wrapper")
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © 2021. All right reserved.</p>
		</footer>
	</div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <script src="{{ asset('assets/js/personalizado.js') }}"></script>
    <script src="{{ asset('assets/js/ValidateRut.js') }}"></script>
    <script src="{{ asset('assets/js/fontawsomeall.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

	@yield("script")
</body>

</html>

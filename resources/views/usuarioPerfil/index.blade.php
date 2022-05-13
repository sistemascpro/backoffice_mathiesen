		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/usuarioPerfil.obfuscated.js') }}"></script>
        @endsection
		@section("wrapper")
            <div class="page-wrapper">
                <div class="page-content">
                    <!--breadcrumb-->
                    <div class="page-breadcrumb align-items-center mb-3">
                        <div class="ps-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 p-0">
                                    <li class="breadcrumb-item pe-3"><a href="/home"><i class="fas fa-home fa-1x"></i></a></li>
                                    <li class="breadcrumb-item pe-3">PERFIL DE USUARIO</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="card border-top border-0 border-4 border-primary">
                        <form class="row g-3" method="post" id="FormActualizarContrasenia" enctype="multipart/form-data">@csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <div class="mt-3">
                                            <h4><?=session('nombre')?></h4>
                                            <p class="text-secondary mb-1"><?=session('rol')?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <h5 class="TituloText">ACTUALIZAR CONTRASEÑA</h5>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <p class="mb-0">CONTRASEÑA <i class="text-danger fas fa-asterisk fa-xs"></i></p>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="pass" class="form-control" id="contrasenia1" name="contrasenia1" required/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <p class="mb-0">REPETIR <i class="text-danger fas fa-asterisk fa-xs"></i></p>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                        <input type="pass" class="form-control" id="contrasenia2" name="contrasenia2" required/>
                                        </div>
                                    </div>
                                    <div class="row bb-3">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="button" class="btn btn-primary px-4" value="GUARDAR CONTRASEÑA" onclick="ActualizarContrasenia();" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="card border-top border-0 border-4 border-primary">
                        <form class="row g-3" method="post" id="FormActualizarInformacion" enctype="multipart/form-data">@csrf
                        <div class="card-body">
                            <h5 class="TituloText">INFORMACIÓN DEL USUARIO</h5>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">RUT <i class="text-danger fas fa-asterisk fa-xs"></i></p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="rut"
                                    name="rut"
                                    value="<?=$usuario[0]->rut?>"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">NOMBRES <i class="text-danger fas fa-asterisk fa-xs"></i></p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                    type="text"
                                    class="form-control"
                                    maxlength="250"
                                    id="nombres"
                                    name="nombres"
                                    value="<?=$usuario[0]->nombres?>"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">APELLIDOS <i class="text-danger fas fa-asterisk fa-xs"></i></p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                    type="text"
                                    class="form-control"
                                    maxlength="250"
                                    id="apellidos"
                                    name="apellidos"
                                    value="<?=$usuario[0]->apellidos?>"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">TELEFONO PRINCIPAL <i class="text-danger fas fa-asterisk fa-xs"></i></p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                    type="text"
                                    class="form-control"
                                    maxlength="50"
                                    id="telefono1"
                                    name="telefono1"
                                    value="<?=$usuario[0]->telefono1?>" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">TELEFONO SECUNDARIO</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                    type="text"
                                    class="form-control"
                                    maxlength="50"
                                    id="telefono2"
                                    name="telefono2"
                                    value="<?=$usuario[0]->telefono2?>" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">EMAIL <i class="text-danger fas fa-asterisk fa-xs"></i></p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                    type="text"
                                    class="form-control"
                                    maxlength="250"
                                    id="email"
                                    name="email"
                                    value="<?=$usuario[0]->email?>" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">USUARIO <i class="text-danger fas fa-asterisk fa-xs"></i></p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                    type="text"
                                    class="form-control"
                                    value="<?=$usuario[0]->usuario?>"
                                    readonly />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="button" class="btn btn-primary px-4" value="GUARDAR CAMBIOS" onclick="ActuaizarInformacion();" />
                                </div>
                            </div>

                        </div>
                        </form>
                    </div>
                </div>
            </div>
		@endsection





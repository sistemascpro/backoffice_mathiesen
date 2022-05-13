		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/mant_usuarios.obfuscated.js') }}"></script>
        @endsection
		@section("wrapper")
            <div class="page-wrapper">
                <div class="page-content">
                    <!--breadcrumb-->
                    <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
                        <div class="ps-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 p-0">
                                    <li class="breadcrumb-item pe-3"><a href="/home"><i class="fas fa-home fa-1x"></i></a></li>
                                    <li class="breadcrumb-item pe-3"><a href="mant_usuarios">MANTENEDOR DE USUARIOS</a></li>
                                    <li class="breadcrumb-item pe-3">CREAR/EDITAR USUARIO</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="card border-top border-0 border-4 border-primary">
                        <form class="row g-3" method="post" id="FormGuardar" enctype="multipart/form-data">@csrf
                            <input
                            type="hidden"
                            class="UsuRequired form-control"
                            value="<?=$Usuario[0]->id?>"
                            id="UsuarioId"
                            name="UsuarioId"
                            readonly
                            />
                        <div class="card-body">
                            <div class="col-sm-3 mb-3">
                                <h5 class="mb-0 text-primary">INFORMACIÓN</h5>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">USUARIO</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                    type="text"
                                    class="UsuRequired form-control"
                                    value="<?=$Usuario[0]->usuario?>"
                                    id="usuario"
                                    name="usuario"
                                    onkeyup="ValidarCaracteres('usuario')"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">ESTADO</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select
                                    class="UsuRequired form-select"
                                    maxlength="30"
                                    id="estado"
                                    name="estado"
                                    >
                                        <option value=true>ACTIVO</option>
                                        <option value=false>BLOQUEADO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">HABILITADO</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select
                                    class="UsuRequired form-select"
                                    maxlength="30"
                                    id="habilitado"
                                    name="habilitado"
                                    >
                                        <option value='SI'>SI</option>
                                        <option value='NO'>NO</option>
                                    </select>
                                </div>
                            </div>
                            <?php
                            if($Usuario[0]->habilitado=='PENDIENTE' || $Usuario[0]->habilitado=='SI')
                            {
                                ?>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0">HABILTADO</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <select
                                        class="UsuRequired form-select"
                                        maxlength="30"
                                        id="habilitado"
                                        name="habilitado"
                                        >
                                            <option value='SI' <?php if($Usuario[0]->habilitado=='SI'){ ?>selected<?php }?>>SI</option>
                                            <option value='NO' <?php if($Usuario[0]->habilitado=='NO'){ ?>selected<?php }?>>NO</option>
                                            <option value='PENDIENTE' <?php if($Usuario[0]->habilitado=='PENDIENTE'){ ?>selected<?php }?>>PENDIENTE</option>
                                        </select>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">CONTRASEÑA<span class="ml-1" style="font-size:10px">(minúsculas)</span></p>
                                </div>
                                <div class="col-sm-3 text-secondary">
                                    <input
                                    type="password"
                                    class="UsuRequired form-control"
                                    value=""
                                    id="contrasenia1"
                                    name="contrasenia1"
                                    onkeyup="ValidarCaracteres('contrasenia1')"
                                    />
                                </div>
                                <div class="col-sm-2">
                                    <p class="mb-0">REPETIR CONTRASEÑA</p>
                                </div>
                                <div class="col-sm-3 text-secondary">
                                    <input
                                    type="password"
                                    class="UsuRequired form-control"
                                    value=""
                                    id="contrasenia2"
                                    name="contrasenia2"
                                    onkeyup="ValidarCaracteres('contrasenia2')"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">ROL</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select
                                    type="text"
                                    class="UsuRequired form-select"
                                    maxlength="30"
                                    id="fk_rol"
                                    name="fk_rol"
                                    >
                                    <?php
                                    foreach ($Roles as $lsRol)
                                    {
                                        ?><option value="<?=$lsRol->id?>" <?=$lsRol->selected?>><?=$lsRol->nombre?></option><?php
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">RUT</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                    type="text"
                                    class="UsuRequired form-control"
                                    maxlength="30"
                                    id="rut"
                                    name="rut"
                                    value="<?=$Usuario[0]->rut?>"
                                    onkeyup="javascript:this.value=this.value.toUpperCase(); ValidateRut_Tipeando('rut');"
                                    onfocusout="ValidateRut_FocusOut('rut')"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">NOMBRES</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                    type="text"
                                    class="UsuRequired form-control"
                                    maxlength="250"
                                    id="nombres"
                                    name="nombres"
                                    value="<?=$Usuario[0]->nombres?>"
                                    onkeyup="ValidarCaracteres('nombres')"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">APELLIDOS</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                    type="text"
                                    class="UsuRequired form-control"
                                    maxlength="250"
                                    id="apellidos"
                                    name="apellidos"
                                    value="<?=$Usuario[0]->apellidos?>"
                                    onkeyup="ValidarCaracteres('apellidos')"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">TELEFONO PRINCIPAL</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                    type="text"
                                    class="UsuRequired form-control"
                                    maxlength="50"
                                    id="telefono1"
                                    name="telefono1"
                                    value="<?=$Usuario[0]->telefono1?>"
                                    onkeyup="ValidarCaracteres('telefono1')"
                                    />
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
                                    value="<?=$Usuario[0]->telefono2?>"
                                    onkeyup="ValidarCaracteres('telefono2')"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">EMAIL</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                    type="text"
                                    class="UsuRequired form-control"
                                    maxlength="250"
                                    id="email"
                                    name="email"
                                    value="<?=$Usuario[0]->email?>"
                                    onkeyup="ValidarCaracteres('email')"
                                    />
                                </div>
                            </div>
                            <span  class="row">
                                <div class="col-sm-4 text-secondary align-middle">
                                    <input type="button" class="btn btn-primary px-4" value="GUARDAR CAMBIOS" onclick="GuardarUsuario();" />
                                </div>
                            </span >
                        </div>
                        </form>
                    </div>
                </div>
            </div>
		@endsection





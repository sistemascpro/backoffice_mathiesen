		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/mant_roles.js') }}"></script>
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
                                    <li class="breadcrumb-item pe-3"><a href="mant_roles">MANTENEDOR DE ROLES</a></li>
                                    <li class="breadcrumb-item pe-3">CREAR/EDITAR ROL</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="card border-top border-0 border-4 border-primary">
                        <form class="row g-3" method="post" id="FormGuardar" enctype="multipart/form-data">@csrf
                            <input
                            type="hidden"
                            class="RolRequired form-control"
                            value="<?=$Rol[0]->id?>"
                            id="RolId"
                            name="RolId"
                            readonly
                            />
                        <div class="card-body">
                            <div class="col-12 mb-3">
                                <h5 class="mb-0 text-primary">INFORMACIÓN</h5>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">ESTADO</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select
                                    class="RolRequired form-select"
                                    maxlength="30"
                                    id="estado"
                                    name="estado"
                                    >
                                        <option value=true <?php if($Rol[0]->estado==true){ ?>selected<?php }?>>ACTIVO</option>
                                        <option value=false <?php if($Rol[0]->estado==false){ ?>selected<?php }?>>BLOQUEADO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">NOMBRE</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                    type="text"
                                    class="RolRequired form-control"
                                    maxlength="250"
                                    id="nombre"
                                    name="nombre"
                                    value="<?=$Rol[0]->nombre?>"
                                    onkeyup="ValidarCaracteres('nombre')"
                                    />
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="col-12 mb-3">
                                <h6 class="mb-0 text-primary">PERMISOS ASOCIADOS</h6>
                            </div>
                            <div class="container">
                                <div class="row">
                                <?php foreach($Permisos as $lsPer){
                                    ?>
                                    <div class="form-check col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                                        <input
                                        class="form-check-input chbk-20"
                                        type="checkbox"
                                        id="chkRol[]"
                                        name="chkRol[]"
                                        value="<?=$lsPer->id?>"
                                        id="flexCheckDefault"
                                        <?=$lsPer->checked?>>
                                        <label class="form-check-label" for="flexCheckDefault"><?=$lsPer->permiso?></label>
                                    </div>
                                    <?php
                                }
                                ?>
                                </div>
                            </div>
                            <hr>
                            <span  class="row mt-3">
                                <div class="col-sm-4 text-secondary align-middle">
                                    <input type="button" class="btn btn-primary px-4" value="GUARDAR CAMBIOS" onclick="GuardarRol();" />
                                </div>
                            </span >
                        </div>
                        </form>
                    </div>
                </div>
            </div>
		@endsection





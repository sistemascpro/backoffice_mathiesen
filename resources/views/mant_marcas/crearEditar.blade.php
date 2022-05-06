		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/mant_marcas.js') }}"></script>
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
                                    <li class="breadcrumb-item pe-3"><a href="mant_marcas">MANTENEDOR DE MARCAS</a></li>
                                    <li class="breadcrumb-item pe-3">CREAR/EDITAR MARCAS</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="card border-top border-0 border-4 border-primary">
                        <form class="row g-3" method="post" id="FormGuardarMarca" enctype="multipart/form-data">@csrf
                            <input
                            type="hidden"
                            class="MarcasRequired form-control"
                            value="<?=$Detalle[0]->id?>"
                            id="id"
                            name="id"
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
                                <div class="col-sm-8 text-secondary">
                                    <select
                                    class="RolRequired form-select"
                                    maxlength="30"
                                    id="estado"
                                    name="estado"
                                    >
                                        <option value=1 <?php if($Detalle[0]->estado==1){ ?>selected<?php }?>>ACTIVO</option>
                                        <option value=0 <?php if($Detalle[0]->estado==0){ ?>selected<?php }?>>BLOQUEADO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">POSICION</p>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <select
                                    class="RolRequired form-select"
                                    maxlength="30"
                                    id="posicion"
                                    name="posicion"
                                    >
                                        <option value=1 <?php if($Detalle[0]->posicion==1){ ?>selected<?php }?>>1</option>
                                        <option value=2 <?php if($Detalle[0]->posicion==2){ ?>selected<?php }?>>2</option>
                                        <option value=3 <?php if($Detalle[0]->posicion==3){ ?>selected<?php }?>>3</option>
                                        <option value=4 <?php if($Detalle[0]->posicion==4){ ?>selected<?php }?>>4</option>
                                        <option value=5 <?php if($Detalle[0]->posicion==5){ ?>selected<?php }?>>5</option>
                                        <option value=6 <?php if($Detalle[0]->posicion==6){ ?>selected<?php }?>>6</option>
                                        <option value=7 <?php if($Detalle[0]->posicion==7){ ?>selected<?php }?>>7</option>
                                        <option value=8 <?php if($Detalle[0]->posicion==8){ ?>selected<?php }?>>8</option>
                                        <option value=0 <?php if($Detalle[0]->posicion==0){ ?>selected<?php }?>>S/N</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">NOMBRE</p>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <input
                                    type="text"
                                    class="MarcasRequired form-control"
                                    maxlength="250"
                                    id="nombre"
                                    name="nombre"
                                    value="<?=$Detalle[0]->nombre?>"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">CABECERA</p>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <input
                                    type="file"
                                    class="form-control"
                                    maxlength="250"
                                    id="cabecera"
                                    name="cabecera"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">IMAGEN</p>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <input
                                    type="file"
                                    class="form-control"
                                    maxlength="250"
                                    id="archivo"
                                    name="archivo"
                                    />
                                </div>
                            </div>
                            <br>
                            <span  class="row">
                                <div class="col-sm-4 text-secondary align-middle">
                                    <input type="button" class="btn btn-primary px-4" value="GUARDAR CAMBIOS" onclick="MarcaGuardar();" />
                                </div>
                            </span>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
		@endsection





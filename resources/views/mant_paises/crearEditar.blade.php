		@extends("layouts.app")
        @section("script")
        <script src="assets/js/js/<?=$ModuloRuta?>.js"></script>
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
                                    <li class="breadcrumb-item pe-3"><a href="<?=$ModuloRuta?>"><?=$ModuloTitulo1?></a></li>
                                    <li class="breadcrumb-item pe-3"><?=$ModuloTitulo2?></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="card border-top border-0 border-4 border-primary">
                        <form class="row g-3" method="post" id="Paises_FormGuardar" enctype="multipart/form-data">@csrf
                            <input type="hidden" name="InputNombreRuta" id="InputNombreRuta" value="<?=$ModuloRuta?>" readonly/>
                            <input type="hidden" name="InputNombreRequired" id="InputNombreRequired" value="<?=$ModuloRequired?>" readonly/>
                            <input
                            type="hidden"
                            class="<?=$ModuloRequired?> form-control"
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
                                <div class="col-sm-6 text-secondary">
                                    <select
                                    class="<?=$ModuloRequired?> form-select"
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
                                    <p class="mb-0">CODIGO</p>
                                </div>
                                <div class="col-sm-6 text-secondary">
                                    <input
                                    type="text"
                                    class="<?=$ModuloRequired?> form-control"
                                    maxlength="250"
                                    id="codigo"
                                    name="codigo"
                                    value="<?=$Detalle[0]->codigo?>"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">NOMBRE</p>
                                </div>
                                <div class="col-sm-6 text-secondary">
                                    <input
                                    type="text"
                                    class="<?=$ModuloRequired?> form-control"
                                    maxlength="250"
                                    id="nombre"
                                    name="nombre"
                                    value="<?=$Detalle[0]->nombre?>"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">BANDERA</p>
                                </div>
                                <div class="col-sm-6 text-secondary">
                                    <input
                                    type="file"
                                    class="<?=$ModuloRequired?> form-control"
                                    maxlength="250"
                                    id="bandera"
                                    name="bandera"
                                    />
                                </div>
                            </div>
                            <br>
                            <span  class="row">
                                <div class="col-sm-4 text-secondary align-middle">
                                    <input type="button" class="btn btn-primary px-4" value="GUARDAR CAMBIOS" onclick="Paises_GuardarCambios();" />
                                </div>
                            </span>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
		@endsection





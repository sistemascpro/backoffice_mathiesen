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
                        <form class="row g-3" method="post" id="Caracteristicas_FormGuardar" enctype="multipart/form-data">@csrf
                            <input type="hidden" name="InputNombreRuta" id="InputNombreRuta" value="<?=$ModuloRuta?>" readonly/>
                            <input type="hidden" name="InputNombreRequired" id="InputNombreRequired" value="<?=$ModuloRequired?>" readonly/>
                            <input
                            type="hidden"
                            class="<?=$ModuloRequired?> form-control"
                            value="<?=$Caracteristica[0]->id?>"
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
                                <div class="col-sm-9 text-secondary">
                                    <select
                                    class="<?=$ModuloRequired?> form-select"
                                    maxlength="30"
                                    id="estado"
                                    name="estado"
                                    >
                                        <option value=1 <?php if($Caracteristica[0]->estado==1){ ?>selected<?php }?>>ACTIVA</option>
                                        <option value=0 <?php if($Caracteristica[0]->estado==0){ ?>selected<?php }?>>BLOQUEADA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">OBLIGATORIO</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select
                                    class="<?=$ModuloRequired?> form-select"
                                    maxlength="30"
                                    id="obligatorio"
                                    name="obligatorio"
                                    >
                                        <option value='' <?php if($Caracteristica[0]->obligatorio==''){ ?>selected<?php }?>>Seleccionar...</option>
                                        <option value='SI' <?php if($Caracteristica[0]->obligatorio=='SI'){ ?>selected<?php }?>>SI</option>
                                        <option value='NO' <?php if($Caracteristica[0]->obligatorio=='NO'){ ?>selected<?php }?>>NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">LIBRE</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select
                                    class="<?=$ModuloRequired?> form-select"
                                    maxlength="30"
                                    id="libre"
                                    name="libre"
                                    >
                                        <option value='' <?php if($Caracteristica[0]->libre==''){ ?>selected<?php }?>>Seleccionar...</option>
                                        <option value='SI' <?php if($Caracteristica[0]->libre=='SI'){ ?>selected<?php }?>>SI</option>
                                        <option value='NO' <?php if($Caracteristica[0]->libre=='NO'){ ?>selected<?php }?>>NO</option>
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
                                    class="<?=$ModuloRequired?>  form-control"
                                    maxlength="250"
                                    id="nombre"
                                    name="nombre"
                                    value="<?=$Caracteristica[0]->nombre?>"
                                    />
                                </div>
                            </div>                            
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">TIPO</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select
                                    class="<?=$ModuloRequired?> form-select"
                                    id="tipo"
                                    name="tipo"
                                    onChange="CargarFormaCaracteristica();"
                                    >
                                        <option value="" <?php if($Caracteristica[0]->tipo==0){ ?>selected<?php }?>>Seleccionar...</option>
                                        <?php for($i=0; $i<count($Tipos); $i++){ ?> 
                                        <option value="<?=$Tipos[$i]->id?>" <?php if($Tipos[$i]->id==$Caracteristica[0]->tipo){ ?>selected<?php }?>><?=$Tipos[$i]->nombre?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>    
                            <div id="DetalleCaracteristica">
                            </div>
                            <br>
                            <span  class="row mt-3">
                                <div class="col-sm-4 text-secondary align-middle">
                                    <input type="button" class="btn btn-primary px-4" value="GUARDAR CAMBIOS" onclick="Caracteristicas_GuardarCambios();" />
                                </div>
                            </span >
                        </div>
                        </form>
                    </div>
                </div>
            </div>
		@endsection





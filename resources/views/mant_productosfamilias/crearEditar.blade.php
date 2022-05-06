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
                        <form class="row g-3" method="post" id="FormGuardar" enctype="multipart/form-data">@csrf
                            <input type="hidden" name="InputNombreRuta" id="InputNombreRuta" value="<?=$ModuloRuta?>" readonly/>
                            <input type="hidden" name="InputNombreRequired" id="InputNombreRequired" value="<?=$ModuloRequired?>" readonly/>
                            <input
                            type="hidden"
                            class="FamiliaRequired form-control"
                            value="<?=$Familia[0]->id?>"
                            id="familiaid"
                            name="familiaid"
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
                                    class="FamiliaRequired form-select"
                                    maxlength="30"
                                    id="estado"
                                    name="estado"
                                    >
                                        <option value=true <?php if($Familia[0]->estado==true){ ?>selected<?php }?>>ACTIVA</option>
                                        <option value=false <?php if($Familia[0]->estado==false){ ?>selected<?php }?>>BLOQUEADA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">CODIGO</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                    type="text"
                                    class="FamiliaRequired form-control"
                                    maxlength="250"
                                    id="codigo"
                                    name="codigo"
                                    value="<?=$Familia[0]->codigo?>"
                                    onkeyup="ValidarCaracteres('codigo')"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">NOMBRE</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                    type="text"
                                    class="FamiliaRequired form-control"
                                    maxlength="250"
                                    id="nombre"
                                    name="nombre"
                                    value="<?=$Familia[0]->nombre?>"
                                    onkeyup="ValidarCaracteres('nombre')"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">DESCRIPCION</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <textarea
                                    type="text"
                                    class="FamiliaRequired form-control"
                                    maxlength="250"
                                    id="descripcion"
                                    name="descripcion"
                                    onkeyup="ValidarCaracteres('descripcion')"
                                    ><?=$Familia[0]->descripcion?></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">ICONO</p><br>
                                </div>
                                <div class="row col-sm-9 text-secondary">
                                    <div class="col-4">
                                        <?php if($Familia[0]->ruta!=null){ ?><a class="text-primary" href="<?=$Familia[0]->ruta?>" target="_blank">VER</a><?php } ?>
                                        <BR>
                                        <?php if($Familia[0]->ruta!=null){ ?><span class="cursor-pointer text-danger" onclick="ElimianrArchivoFamilia('<?=$Familia[0]->ruta?>', <?=$Familia[0]->id?>)">ELIMINAR</span><?php } ?>
                                    </div>
                                    <div class="col-8">
                                        <input
                                        type="file"
                                        class="form-control"
                                        maxlength="250"
                                        id="archivo"
                                        name="archivo"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">CABECERA</p><br>
                                </div>
                                <div class="row col-sm-9 text-secondary">
                                    <div class="col-4">
                                        <?php if($Familia[0]->ruta2!=null){ ?><a class="text-primary" href="<?=$Familia[0]->ruta2?>" target="_blank">VER</a><?php } ?>
                                        <BR>
                                        <?php if($Familia[0]->ruta2!=null){ ?><span class="cursor-pointer text-danger" onclick="ElimianrArchivoFamilia2('<?=$Familia[0]->ruta2?>', <?=$Familia[0]->id?>)">ELIMINAR</span><?php } ?>
                                    </div>
                                    <div class="col-8">
                                        <input
                                        type="file"
                                        class="form-control"
                                        maxlength="250"
                                        id="cabecera"
                                        name="cabecera"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">CARACTERISTICA</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select
                                    class="selectpicker form-select"
                                    data-live-search="true"
                                    id="IdSelectCaracteristica"
                                    name="IdSelectCaracteristica"
                                    onChange="CargarFormaCaracteristica();"
                                    >
                                        <option value="" selected>Seleccionar...</option>
                                        <?php for($i=0; $i<count($Caracteristicas); $i++){ ?> 
                                        <option data-tokens="<?=$Caracteristicas[$i]->tipo_nombre." - ".$Caracteristicas[$i]->nombre?>" value="<?=$Caracteristicas[$i]->id?>" ><?=$Caracteristicas[$i]->tipo." -- ".$Caracteristicas[$i]->tipo_nombre." - ".$Caracteristicas[$i]->nombre?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div id="DivFormularioCaracteristica">
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="col-12 mb-3">
                                <h6 class="mb-0 text-primary">CARACTERISTICAS AGREGADAS</h6>
                            </div>
                            <div id="DivCaractericasAgregadas"></div>
                            <hr>
                            <span  class="row mt-3">
                                <div class="col-sm-4 text-secondary align-middle">
                                    <input type="button" class="btn btn-primary px-4" value="GUARDAR CAMBIOS" onclick="Guardar();" />
                                </div>
                            </span >
                        </div>
                        </form>
                    </div>
                </div>
            </div>
		@endsection





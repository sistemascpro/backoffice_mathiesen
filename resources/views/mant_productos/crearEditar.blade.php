		@extends("layouts.app")
        @section("script")
        <script src="assets/js/js/<?=$ModuloRuta?>.js"></script>
        @endsection
		@section("wrapper")
            <div class="page-wrapper">
                <div class="modal fade" id="ModalHistorialArchivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">HISTORIAL DE ARCHIVOS</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="ModalHistorialArchivosContent">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                        </div>
                        </div>
                    </div>
                </div>
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
                            <input type="hidden" class="<?=$ModuloRequired?> form-control" value="<?=$Producto[0]->id?>" id="productoid" name="productoid" readonly/>
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
                                        <option value=1 <?php if($Producto[0]->estado==1){ ?>selected<?php }?>>ACTIVO</option>
                                        <option value=0 <?php if($Producto[0]->estado==0){ ?>selected<?php }?>>BLOQUEADO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">VISTA</p>
                                </div>
                                <div class="col-sm-6 text-secondary">
                                    <select
                                    class="<?=$ModuloRequired?> form-select"
                                    maxlength="30"
                                    id="vista"
                                    name="vista"
                                    >
                                        <option value='PUBLICO' <?php if($Producto[0]->vista=='PUBLICO'){ ?>selected<?php }?>>PUBLICO</option>
                                        <option value='REGISTRADO' <?php if($Producto[0]->vista=='REGISTRADO'){ ?>selected<?php }?>>REGISTRADO</option>
                                    </select>
                                </div>
                                </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">MARCA</p>
                                </div>
                                <div class="col-sm-6 text-secondary">
                                <select
                                    class="<?=$ModuloRequired?> form-select single-select"
                                    maxlength="30"
                                    id="fk_marca"
                                    name="fk_marca"
                                    data-live-search="true"
                                    >
                                        <option value="0">SELECCCIONAR...</option>
                                        <?php foreach($Marcas as $lsMarcas){
                                            ?><option value="<?=$lsMarcas->id?>" <?=$lsMarcas->selected?>><?=$lsMarcas->nombre?></option><?php
                                        }
                                        ?>
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
                                    id="CodProd"
                                    name="CodProd"
                                    value="<?=$Producto[0]->codigo?>"
                                    />
                                </div>
                                </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">DESCRIPCION 1</p>
                                </div>
                                <div class="col-sm-6 text-secondary">
                                    <input
                                    type="text"
                                    class="<?=$ModuloRequired?> form-control"
                                    maxlength="250"
                                    id="DesProd"
                                    name="DesProd"
                                    value="<?=$Producto[0]->descripcion?>"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">DESCRIPCION 2</p>
                                </div>
                                <div class="col-sm-6 text-secondary">
                                    <input
                                    type="text"
                                    class="<?=$ModuloRequired?> form-control"
                                    maxlength="250"
                                    id="DesProd2"
                                    name="DesProd2"
                                    value="<?=$Producto[0]->descripcion2?>"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">DESCRIPCION EXTRA</p>
                                </div>
                                <div class="col-sm-6 text-secondary">
                                    <textarea
                                    type="text"
                                    class="<?=$ModuloRequired?> form-control"
                                    id="DesExtra"
                                    name="DesExtra"
                                    rows="10"
                                    ><?=$Producto[0]->DesExtra?></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">FAMILIA PRINCIPAL</p>
                                </div>
                                <div class="col-sm-6 text-secondary">
                                <select
                                    class="<?=$ModuloRequired?> form-select single-select"
                                    maxlength="30"
                                    id="fk_familia"
                                    name="fk_familia"
                                    data-live-search="true"
                                    onChange="CargarFamiliasSecundarias(); CargarCaracteristicasFamilia(); "

                                    >
                                        <option value="0">SELECCCIONAR...</option>
                                        <?php foreach($Familia as $lsFamilia){
                                            ?><option value="<?=$lsFamilia->id?>" <?=$lsFamilia->selected?>><?=$lsFamilia->codigo." - ".$lsFamilia->nombre?></option><?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="row mb-3">
                            <hr>
                            <div class="col-12 mb-3 mt-10">
                                <h6 class="mb-0 text-primary">IMAGENES (500px X 500px)</h6>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">IMAGEN 1</p>
                                </div>
                                <div class="row col-sm-8 text-secondary">
                                    <div class="col-2">
                                        <?php if($Producto[0]->imagen1!=null){ ?><a class="text-primary" href="<?=$Producto[0]->imagen1?>" target="_blank">VER</a><?php } ?>
                                        <BR>
                                        <?php if($Producto[0]->imagen1!=null){ ?><span class="cursor-pointer text-danger" onclick="ElimianrArchivoProducto('<?=$Producto[0]->imagen1?>','<?=$Producto[0]->id?>','imagen1')">ELIMINAR</span><?php } ?>
                                    </div>
                                    <div class="col-10">
                                        <input
                                        type="file"
                                        class="form-control"
                                        maxlength="250"
                                        id="imagen1"
                                        name="imagen1"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">IMAGEN 2</p>
                                </div>
                                <div class="row col-sm-8 text-secondary">
                                    <div class="col-2">
                                        <?php if($Producto[0]->imagen2!=null){ ?><a class="text-primary" href="<?=$Producto[0]->imagen2?>" target="_blank">VER</a><?php } ?>
                                        <BR>
                                        <?php if($Producto[0]->imagen2!=null){ ?><span class="cursor-pointer text-danger" onclick="ElimianrArchivoProducto('<?=$Producto[0]->imagen2?>','<?=$Producto[0]->id?>','imagen2')">ELIMINAR</span><?php } ?>
                                    </div>
                                    <div class="col-10">
                                        <input
                                        type="file"
                                        class="form-control"
                                        maxlength="250"
                                        id="imagen2"
                                        name="imagen2"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">IMAGEN 3</p>
                                </div>
                                <div class="row col-sm-8 text-secondary">
                                    <div class="col-2">
                                        <?php if($Producto[0]->imagen3!=null){ ?><a class="text-primary" href="<?=$Producto[0]->imagen3?>" target="_blank">VER</a><?php } ?>
                                        <BR>
                                        <?php if($Producto[0]->imagen3!=null){ ?><span class="cursor-pointer text-danger" onclick="ElimianrArchivoProducto('<?=$Producto[0]->imagen3?>','<?=$Producto[0]->id?>','imagen3')">ELIMINAR</span><?php } ?>
                                    </div>
                                    <div class="col-10">
                                        <input
                                        type="file"
                                        class="form-control"
                                        maxlength="250"
                                        id="imagen3"
                                        name="imagen3"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">IMAGEN 4</p>
                                </div>
                                <div class="row col-sm-8 text-secondary">
                                    <div class="col-2">
                                        <?php if($Producto[0]->imagen4!=null){ ?><a class="text-primary" href="<?=$Producto[0]->imagen4?>" target="_blank">VER</a><?php } ?>
                                        <BR>
                                        <?php if($Producto[0]->imagen4!=null){ ?><span class="cursor-pointer text-danger" onclick="ElimianrArchivoProducto('<?=$Producto[0]->imagen4?>','<?=$Producto[0]->id?>','imagen4')">ELIMINAR</span><?php } ?>
                                    </div>
                                    <div class="col-10">
                                        <input
                                        type="file"
                                        class="form-control"
                                        maxlength="250"
                                        id="imagen4"
                                        name="imagen4"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">IMAGEN 5</p><br>
                                </div>
                                <div class="row col-sm-8 text-secondary">
                                    <div class="col-2">
                                        <?php if($Producto[0]->imagen5!=null){ ?><a class="text-primary" href="<?=$Producto[0]->imagen5?>" target="_blank">VER</a><?php } ?>
                                        <BR>
                                        <?php if($Producto[0]->imagen5!=null){ ?><span class="cursor-pointer text-danger" onclick="ElimianrArchivoProducto('<?=$Producto[0]->imagen5?>','<?=$Producto[0]->id?>','imagen5')">ELIMINAR</span><?php } ?>
                                    </div>
                                    <div class="col-10">
                                        <input
                                        type="file"
                                        class="form-control"
                                        maxlength="250"
                                        id="imagen5"
                                        name="imagen5"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">IMAGEN 6</p><br>
                                </div>
                                <div class="row col-sm-8 text-secondary">
                                    <div class="col-2">
                                        <?php if($Producto[0]->imagen6!=null){ ?><a class="text-primary" href="<?=$Producto[0]->imagen6?>" target="_blank">VER</a><?php } ?>
                                        <BR>
                                        <?php if($Producto[0]->imagen6!=null){ ?><span class="cursor-pointer text-danger" onclick="ElimianrArchivoProducto('<?=$Producto[0]->imagen6?>','<?=$Producto[0]->id?>','imagen6')">ELIMINAR</span><?php } ?>
                                    </div>
                                    <div class="col-10">
                                        <input
                                        type="file"
                                        class="form-control"
                                        maxlength="250"
                                        id="imagen6"
                                        name="imagen6"
                                        />
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="col-12 mb-3 mt-10">
                                <h6 class="mb-0 text-primary">ARCHIVOS <a class="mb-0 text-danger ml-5" style="font-size: 12px; cursor:pointer" onclick="VerHistorialArchivos();"><strong>VER HITORIAL</strong></a></h6>  
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">FICHA TÉCNICA</p><br>
                                </div>
                                <div class="row col-sm-8 text-secondary">
                                    <div class="col-2">
                                        <?php if($Producto[0]->fichatecnica!=null){ ?><a class="text-primary" href="<?=$Producto[0]->fichatecnica?>" target="_blank">VER</a><?php } ?>
                                        <BR>
                                        <?php if($Producto[0]->fichatecnica!=null){ ?><span class="cursor-pointer text-danger" onclick="ElimianrArchivoProducto('<?=$Producto[0]->fichatecnica?>','<?=$Producto[0]->id?>','fichatecnica')">ELIMINAR</span><?php } ?>
                                    </div>
                                    <div class="col-10">
                                        <input
                                        type="file"
                                        class="form-control"
                                        maxlength="250"
                                        id="fichatecnica"
                                        name="fichatecnica"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">HOJA SEGURIDAD</p>
                                </div>
                                <div class="row col-sm-8 text-secondary">
                                    <div class="col-2">
                                        <?php if($Producto[0]->hojaseguridad!=null){ ?><a class="text-primary" href="<?=$Producto[0]->hojaseguridad?>" target="_blank">VER</a><?php } ?>
                                        <BR>
                                        <?php if($Producto[0]->hojaseguridad!=null){ ?><span class="cursor-pointer text-danger" onclick="ElimianrArchivoProducto('<?=$Producto[0]->hojaseguridad?>','<?=$Producto[0]->id?>','hojaseguridad')">ELIMINAR</span><?php } ?>
                                    </div>
                                    <div class="col-10">
                                        <input
                                        type="file"
                                        class="form-control"
                                        maxlength="250"
                                        id="hojaseguridad"
                                        name="hojaseguridad"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">ARCHIVO EXTRA</p><br>
                                </div>
                                <div class="row col-sm-8 text-secondary">
                                    <div class="col-2">
                                        <?php if($Producto[0]->archivoextra!=null){ ?><a class="text-primary" href="<?=$Producto[0]->archivoextra?>" target="_blank">VER</a><?php } ?>
                                        <BR>
                                        <?php if($Producto[0]->archivoextra!=null){ ?><span class="cursor-pointer text-danger" onclick="ElimianrArchivoProducto('<?=$Producto[0]->archivoextra?>','<?=$Producto[0]->id?>','archivoextra')">ELIMINAR</span><?php } ?>
                                    </div>
                                    <div class="col-10">
                                        <input
                                        type="file"
                                        class="form-control"
                                        maxlength="250"
                                        id="archivoextra"
                                        name="archivoextra"
                                        />
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">NOMBRE</p>
                                </div>
                                <div class="row col-sm-8 text-secondary">
                                    <div class="col-2"></div>
                                    <div class="col-10">
                                        <input
                                        type="text"
                                        class="form-control"
                                        maxlength="250"
                                        id="archivoextranombre"
                                        name="archivoextranombre"
                                        />
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="col-12 mb-3 mt-10">
                                <h6 class="mb-0 text-primary">FAMILIAS SECUNDARIAS</h6>
                            </div>
                            <div id="DivFamiliasSecundarias" class="mt-3 mb-5 row"></div>

                            <hr>
                            <div class="col-12 mb-3 mt-10">
                                <h6 class="mb-0 text-primary">PAISES</h6>
                            </div>
                            <div class="mt-3 mb-5 row">
                            <?php foreach($Paises as $lsPaises){
                                ?>
                                <div class="col-4 row mb-3">
                                    <div class="col-sm-2 text-secondary">
                                        <input
                                        class="form-check-input chbk-20"
                                        type="checkbox"
                                        id="chkPaises[]"
                                        name="chkPaises[]"
                                        value="<?=$lsPaises->id?>"
                                        <?=$lsPaises->checked?>
                                        >
                                    </div>
                                    <div class="col-sm-9 text-secondary"><?=$lsPaises->codigo." - ".$lsPaises->nombre?></div>
                                </div>
                                <?php
                            }
                            ?>
                            </div>

                            <hr>
                            <div class="col-12 mb-3 mt-10">
                                <h6 class="mb-0 text-primary">PROVEEDORES</h6>
                            </div>
                            <div class="mt-3 mb-5 row">
                            <?php foreach($Proveedores as $lsProveedores){
                                ?>
                                <div class="col-4 row mb-3">
                                    <div class="col-sm-2 text-secondary">
                                        <input
                                        class="form-check-input chbk-20"
                                        type="checkbox"
                                        id="chkProveedores[]"
                                        name="chkProveedores[]"
                                        value="<?=$lsProveedores->id?>"
                                        <?=$lsProveedores->checked?>
                                        >
                                    </div>
                                    <div class="col-sm-10 text-secondary"><?=$lsProveedores->codigo." - ".$lsProveedores->nombre?></div>
                                </div>
                                <?php
                            }
                            ?>
                            </div>

                            <hr>
                            <div class="col-12 mb-3">
                                <h6 class="mb-0 text-primary">CARACTERISTICAS ESPECIALES</h6>
                            </div>
                            <div id="DivCaracteristicasEspeciales" class="row"></div>
                            <span  class="row">
                                <div class="col-sm-4 text-secondary align-middle">
                                    <input type="button" class="btn btn-primary px-4" value="GUARDAR CAMBIOS" onclick="GuardarCambios();" />
                                </div>
                            </span >
                        </div>
                        </form>
                    </div>
                </div>
            </div>
		@endsection





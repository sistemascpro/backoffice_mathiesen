		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/mant_banners.js') }}"></script>
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
                                    <li class="breadcrumb-item pe-3"><a href="mant_banners">MANTENEDOR DE BANNERS</a></li>
                                    <li class="breadcrumb-item pe-3">CREAR/EDITAR BANNERS</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="card border-top border-0 border-4 border-primary">
                        <form class="row g-3" method="post" id="FormGuardar" enctype="multipart/form-data">@csrf
                            <input
                            type="hidden"
                            class="BannerRequired form-control"
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
                                    <p class="mb-0">NOMBRE</p>
                                </div>
                                <div class="col-sm-6 text-secondary">
                                    <input
                                    type="text"
                                    class="BannerRequired form-control"
                                    maxlength="250"
                                    id="nombre"
                                    name="nombre"
                                    value="<?=$Detalle[0]->nombre?>"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">POSICION</p>
                                </div>
                                <div class="col-sm-6 text-secondary">
                                    <select
                                    class="BannRequired form-select"
                                    maxlength="30"
                                    id="posicion"
                                    name="posicion"
                                    >
                                    <?php
                                    $Selected = '';
                                    $AuxSelected = 0;
                                    for($i=1; $i<=18; $i++){
                                        if($i==$Detalle[0]->posicion) { $Selected = 'selected'; $AuxSelected++; } else { $Selected = ''; }
                                        ?><option value="<?=$i?>" <?=$Selected?>><?=$i?></option><?php
                                    }
                                    if($AuxSelected==0){
                                        ?><option value="0" selected>Seleccionar...</option><?php
                                    }else{
                                        ?><option value="0">Seleccionar...</option><?php
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">IMAGEN</p>
                                </div>
                                <div class="col-sm-6 text-secondary">
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
                                    <input type="button" class="btn btn-primary px-4" value="GUARDAR CAMBIOS" onclick="GuardarBanner();" />
                                </div>
                            </span>
                            <br><br>
                            <div class="col-12 mb-3">
                                <h5 class="mb-0 text-primary">PRODUCTOS</h5>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">CODIGO</p>
                                </div>
                                <div class="col-sm-2 text-secondary">
                                    <input
                                    type="text"
                                    class="form-control"
                                    maxlength="250"
                                    id="CodProd"
                                    name="CodProd"
                                    value=""
                                    />
                                </div>
                                <div class="col-sm-4 text-secondary align-middle">
                                    <input type="button" class="btn btn-primary px-4" value="AGREGAR" onclick="AgregarProducto();" />
                                </div>
                            </div>
                            <div id="DivListadoProductos"></div>
                            <br>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
		@endsection





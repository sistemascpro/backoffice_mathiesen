		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/mant_prodpromosregalos.js') }}"></script>
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
                                    <li class="breadcrumb-item pe-3"><a href="mant_prodpromosregalos">MANTENEDOR DE PROMOCIONES REGALOS</a></li>
                                    <li class="breadcrumb-item pe-3">CREAR/EDITAR PROMOCION REGALO</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="card border-top border-0 border-4 border-primary">
                        <form class="row g-3" method="post" id="FormGuardar" enctype="multipart/form-data">@csrf
                            <input
                            type="hidden"
                            class="PromRegaRequired form-control"
                            value="<?=$Detalle[0]->promoid?>"
                            id="promoid"
                            name="promoid"
                            readonly
                            />
                        <div class="card-body">
                            <div class="col-12 mb-3">
                                <h5 class="mb-0 text-primary">INFORMACIÓN</h5>
                            </div>
                            <hr>
                            <div class="col-12 mb-3">
                                <h5 class="mb-0 text-dark">PRODUCTO COMPRA</h5>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-1">
                                    <p class="mb-0">PRODUCTO</p>
                                </div>
                                <div class="col-sm-2 text-secondary">
                                    <input
                                    type="text"
                                    class="PromRegaRequired form-control"
                                    maxlength="250"
                                    id="prod1"
                                    name="prod1"
                                    value="<?=$Detalle[0]->prod1?>"
                                    onfocusout="CargarProducto('prod1','desc1')"
                                    />
                                </div>
                                <div class="col-sm-1">
                                    <p class="mb-0">DESCRIPCION</p>
                                </div>
                                <div class="col-sm-2 text-secondary">
                                    <input
                                    type="text"
                                    class="PromRegaRequired form-control"
                                    maxlength="250"
                                    id="desc1"
                                    name="desc1"
                                    value="<?=$Detalle[0]->desc1?>"
                                    readonly
                                    />
                                </div>
                                <div class="col-sm-1">
                                    <p class="mb-0">CANTIDAD</p>
                                </div>
                                <div class="col-sm-2 text-secondary">
                                    <input
                                    type="number"
                                    class="PromRegaRequired form-control"
                                    maxlength="250"
                                    id="cant1"
                                    name="cant1"
                                    value="<?=$Detalle[0]->cant1?>"
                                    />
                                </div>
                            </div> 
                            <div class="col-12 mb-3">
                                <h5 class="mb-0 text-dark">PRODUCTO REGALO</h5>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-1">
                                    <p class="mb-0">PRODUCTO</p>
                                </div>
                                <div class="col-sm-2 text-secondary">
                                    <input
                                    type="text"
                                    class="PromRegaRequired form-control"
                                    maxlength="250"
                                    id="prod2"
                                    name="prod2"
                                    onfocusout="CargarProducto('prod2','desc2')"
                                    value="<?=$Detalle[0]->prod2?>"
                                    />
                                </div>
                                <div class="col-sm-1">
                                    <p class="mb-0">DESCRIPCION</p>
                                </div>
                                <div class="col-sm-2 text-secondary">
                                    <input
                                    type="text"
                                    class="PromRegaRequired form-control"
                                    maxlength="250"
                                    id="desc2"
                                    name="desc2"
                                    value="<?=$Detalle[0]->desc2?>"
                                    readonly
                                    />
                                </div>
                                <div class="col-sm-1">
                                    <p class="mb-0">CANTIDAD</p>
                                </div>
                                <div class="col-sm-2 text-secondary">
                                    <input
                                    type="number"
                                    class="PromRegaRequired form-control"
                                    maxlength="250"
                                    id="cant2"
                                    name="cant2"
                                    value="<?=$Detalle[0]->cant2?>"
                                    />
                                </div>
                                <div class="col-sm-1">
                                    <p class="mb-0">PRECIO</p>
                                </div>
                                <div class="col-sm-2 text-secondary">
                                    <input
                                    type="number"
                                    class="PromRegaRequired form-control"
                                    maxlength="250"
                                    id="precio2"
                                    name="precio2"
                                    value="<?=$Detalle[0]->precio2?>"
                                    />
                                </div>
                            </div>    
                            <div class="col-12 mb-3">
                                <h5 class="mb-0 text-dark">VALIDEZ</h5>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-1">
                                    <p class="mb-0">DESDE</p>
                                </div>
                                <div class="col-sm-2 text-secondary">
                                    <input
                                    type="date"
                                    class="PromRegaRequired form-control"
                                    maxlength="250"
                                    id="fecha1"
                                    name="fecha1"
                                    value="<?=$Detalle[0]->fecha1?>"
                                    />
                                </div>
                                <div class="col-sm-1">
                                    <p class="mb-0">HASTA</p>
                                </div>
                                <div class="col-sm-2 text-secondary">
                                    <input
                                    type="date"
                                    class="PromRegaRequired form-control"
                                    maxlength="250"
                                    id="fecha2"
                                    name="fecha2"
                                    value="<?=$Detalle[0]->fecha2?>"
                                    />
                                </div>
                            </div>                                                                                                                                            
                            <br>
                            <br>
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





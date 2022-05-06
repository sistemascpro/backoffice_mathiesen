		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/mant_codigosdescuentos.js') }}"></script>
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
                                    <li class="breadcrumb-item pe-3"><a href="mant_codigosdescuentos">MANTENEDOR DE CODIGOS DE DESCUENTOS</a></li>
                                    <li class="breadcrumb-item pe-3">CREAR/EDITAR CODIGOS DE DESCUENTOS</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="card border-top border-0 border-4 border-primary">
                        <form class="row g-3" method="post" id="FormGuardar" enctype="multipart/form-data">@csrf
                            <input
                            type="hidden"
                            class="CodDescRequired form-control"
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
                                <div class="col-sm-1">
                                    <p class="mb-0">CODIGO</p>
                                </div>
                                <div class="col-sm-2 text-secondary">
                                    <input
                                    type="text"
                                    class="CodDescRequired form-control"
                                    maxlength="250"
                                    id="codigo"
                                    name="codigo"
                                    value="<?=$Detalle[0]->codigo?>"
                                    />
                                </div>
                                <div class="col-sm-1">
                                    <p class="mb-0">DESCRIPCION</p>
                                </div>
                                <div class="col-sm-3 text-secondary">
                                    <input
                                    type="text"
                                    class="CodDescRequired form-control"
                                    maxlength="250"
                                    id="descripcion"
                                    name="descripcion"
                                    value="<?=$Detalle[0]->descripcion?>"
                                    />
                                </div>
                                <div class="col-sm-1">
                                    <p class="mb-0">VALOR</p>
                                </div>
                                <div class="col-sm-2 text-secondary">
                                    <input
                                    type="number"
                                    class="CodDescRequired form-control"
                                    maxlength="250"
                                    id="valor"
                                    name="valor"
                                    value="<?=$Detalle[0]->descripcion?>"
                                    />
                                </div>                                
                            </div> 
                            <div class="row mb-3">
                                <div class="col-sm-1">
                                    <p class="mb-0">DESDE</p>
                                </div>
                                <div class="col-sm-2 text-secondary">
                                    <input
                                    type="date"
                                    class="CodDescRequired form-control"
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
                                    class="CodDescRequired form-control"
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
                            <br>
                            <br>
                            <div class="col-12 mb-3">
                                <h5 class="mb-0 text-primary">CLIENTES</h5>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-1">
                                    <p class="mb-0">CLIENTE</p>
                                </div>
                                <div class="col-sm-2 text-secondary">
                                    <input
                                    type="text"
                                    class="form-control"
                                    maxlength="250"
                                    id="codigo"
                                    name="codigo"
                                    value=""
                                    />
                                </div>
                                <div class="col-sm-4 text-secondary align-middle">
                                    <input type="button" class="btn btn-primary px-4" value="BUSCAR" onclick="BuscarClientes();" />
                                </div>
                                <div class="col-sm-4 text-secondary align-middle">
                                    <input type="button" class="btn btn-secondary px-4" value="LIMPIAR" onclick="LimpiarClientes();" />
                                </div>                                
                            </div>
                            <hr>                            
                            <div id="DivListadoClientesEncontrados"></div>
                            <div class="col-12 mb-3">
                                <h5 class="mb-0 text-primary">CLIENTES AGREGADOS</h5>
                            </div>
                            <hr>
                            <div id="DivListadoClientesAgregados"></div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
		@endsection





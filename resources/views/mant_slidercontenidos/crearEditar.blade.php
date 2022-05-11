		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/mant_slidercontenidos.js') }}"></script>
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
                                    <li class="breadcrumb-item pe-3"><a href="mant_slidercontenidos">MANTENEDOR DE SLIDER CONTENIDOS</a></li>
                                    <li class="breadcrumb-item pe-3">CREAR/EDITAR SLIDER CONTENIDOS</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="card border-top border-0 border-4 border-primary">
                        <form class="row g-3" method="post" id="FormGuardar" enctype="multipart/form-data">@csrf
                            <input
                            type="hidden"
                            class="form-control"
                            value="<?=$SliderContenidos[0]->id?>"
                            id="id"
                            name="id"
                            readonly
                            />
                        <div class="card-body row">
                            <div class="col-6">
                                <div class="col-sm-12">
                                    <h5 class="mb-0 text-primary">SLIDER CONTENIDOS</h5>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0">TEXTO</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <textarea
                                        type="text"
                                        class="SliderContenidosRequired form-control"
                                        id="texto"
                                        name="texto"
                                        onkeyup="ValidarCaracteres('texto')"
                                        ><?=$SliderContenidos[0]->texto?></textarea>
                                    </div>
                                </div>  
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0">IMAGEN</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input
                                        type="file"
                                        class="SliderContenidosRequired form-control"
                                        id="imagen"
                                        name="imagen"
                                        />
                                    </div>
                                </div>
                                <div class="col-sm-4 text-secondary align-middle">
                                    <input type="button" class="btn btn-primary px-4" value="GUARDAR" onclick="Guardar();" />
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
		@endsection





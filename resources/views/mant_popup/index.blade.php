		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/mant_popup.js') }}"></script>
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
                                    <li class="breadcrumb-item pe-3"><a href="mant_prodsincanje">MANTENEDOR DE POPUP</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="card border-top border-0 border-4 border-primary">
                        <form class="row g-3" method="post" id="FormGuardar" enctype="multipart/form-data">@csrf
                        <div class="card-body">
                            <div class="col-12 mb-3">
                                <h5 class="mb-0 text-primary">INFORMACIÓN</h5>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <p class="mb-0">MENSAJE</p>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <textarea
                                    type="text"
                                    class="form-control"
                                    maxlength="250"
                                    id="Mensaje"
                                    name="Mensaje"
                                    rows="10"
                                    ><?=$Lista[0]->popup?></textarea>
                                </div>
                            </div>
                            <br>
                            <span  class="row">
                                <div class="col-sm-4 text-secondary align-middle">
                                    <input type="button" class="btn btn-primary px-4" value="AGREGAR" onclick="Agregar();" />
                                </div>
                            </span >
                        </div>
                        </form>
                    </div>
                </div>
            </div>
		@endsection





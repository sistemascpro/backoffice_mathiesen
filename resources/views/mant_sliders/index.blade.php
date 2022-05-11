		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/mant_sliders.js') }}"></script>
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
                                    <li class="breadcrumb-item pe-3"><a href="#">MANTENEDOR DE SLIDERS</a></li>
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
                                    <input type="button" class="btn btn-primary px-4" value="GUARDAR CAMBIOS" onclick="GuardarSlider();" />
                                </div>
                            </span>
                            <br><br>
                            <div class="card-title d-flex align-items-center">
                            <h5 class="mb-0 text-primary">SLIDERS</h5>
                        </div>
                        <hr>
                        <table id="Tabla_Listado" class="table table-striped table-responive table-bordered" style="font-size:12px">
                            <thead>
                                <tr>
                                    <th>ACCIONES</th>
                                    <th>SLIDER</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($Lista as $lsRows)
                                {
                                    ?>
                                    <tr class="table-hover">
                                        <td>
                                            <span class="pointer badge badge-pill bg-danger" onclick="EliminarSlider('<?=$lsRows->id?>', '<?=$lsRows->ruta?>')">ELIMINAR</span>
                                        </td>
                                        <td><img src="<?=$lsRows->ruta?>" width="400px"></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
		@endsection





		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/mant_codigosdescuentos.js') }}"></script>
        @endsection
		@section("wrapper")
            <div class="page-wrapper">
                <div class="page-content">
                    <!--breadcrumb-->
                    <div class="page-breadcrumb align-items-center mb-3">
                        <div class="ps-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 p-0">
                                    <li class="breadcrumb-item pe-3"><a href="/home"><i class="fas fa-home fa-1x"></i></a></li>
                                    <li class="breadcrumb-item pe-3">MANTENEDOR DE CODIGOS DE DESCUENTO</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="row">
                        <input
                        type="hidden"
                        class="CodDescRequired form-control"
                        value="0"
                        id="id"
                        name="id"
                        readonly
                        />
                        <div class="card border-top border-0 border-4 border-primary">
                            <div class="card-body" style="overflow-x: auto; white-space: nowrap;">
                                <div class="card-title d-flex align-items-center">
                                    <h5 class="mb-0 text-primary">CODIGOS DE DESCUENTO</h5><span class="pointer ml-3 badge badge-pill bg-primary" onclick="crearEditar(-1)">CREAR</span>
                                </div>
                                <hr>
                                <table id="TablaLista" class="table table-striped table-responive table-bordered" style="font-size:12px">
                                    <thead>
                                        <tr>
                                            <th>ACCIONES</th>
                                            <th>CODIGO</th>
                                            <th>VALOR</th>
                                            <th>CLIENTES</th>
                                            <th>FECHA DESDE</th>
                                            <th>FECHA HASTA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($Lista as $Rows)
                                        {
                                            ?>
                                            <tr class="table-hover">
                                                <td>
                                                    <span class="pointer badge badge-pill bg-purple" onclick="crearEditar('<?=$Rows->id?>')">EDITAR</span>
                                                </td>
                                                <td><?=$Rows->codigo?></td>
                                                <td><?=$Rows->valor?></td>
                                                <td><?=$Rows->clientes?></td>
                                                <td><?=$Rows->fecha1?></td>
                                                <td><?=$Rows->fecha2?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		@endsection





		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/mant_prodpromosregalos.js') }}"></script>
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
                                    <li class="breadcrumb-item pe-3">MANTENEDOR DE PROMOCIONES REGALOS</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="row">
                        <div class="card border-top border-0 border-4 border-primary">
                            <div class="card-body" style="overflow-x: auto; white-space: nowrap;">
                                <div class="card-title d-flex align-items-center">
                                    <h5 class="mb-0 text-primary">PROMOCIONES REGALOS</h5><span class="pointer ml-3 badge badge-pill bg-primary" onclick="crearEditar(-1)">CREAR</span>
                                </div>
                                <hr>
                                <table id="TablaLista" class="table table-striped table-responive table-bordered" style="font-size:12px">
                                    <thead>
                                        <tr>
                                            <th>ACCIONES</th>
                                            <th>PRODUCTO COMPRA</th>
                                            <th>CANTIDAD COMPRA</th>
                                            <th>PROD REGALO</th>
                                            <th>CANT REGALO</th>
                                            <th>PRECIO REGALO</th>
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
                                                    <span class="pointer badge badge-pill bg-purple" onclick="crearEditar('<?=$Rows->promoid?>')">EDITAR</span>
                                                </td>
                                                <td><?=$Rows->prod1." - ".$Rows->desc1?></td>
                                                <td><?=$Rows->cant1?></td>
                                                <td><?=$Rows->prod2." - ".$Rows->desc2?></td>
                                                <td><?=$Rows->cant2?></td>
                                                <td><?=$Rows->precio2?></td>
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





		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/mant_productossubfamilias.js') }}"></script>
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
                                    <li class="breadcrumb-item pe-3">MANTENEDOR DE SUB FAMILIAS</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="row">
                        <div class="card border-top border-0 border-4 border-primary">
                            <div class="card-body" style="overflow-x: auto; white-space: nowrap;">
                                <div class="card-title d-flex align-items-center">
                                    <h5 class="mb-0 text-primary">SUB FAMILIAS</h5><span class="pointer ml-3 badge badge-pill bg-primary" onclick="crearEditar(-1)">CREAR</span>
                                </div>
                                <hr>
                                <table id="Lista" class="table table-striped table-responive table-bordered" style="font-size:12px">
                                    <thead>
                                        <tr>
                                            <th>ACCIONES</th>
                                            <th>FAMILIA</th>
                                            <th>CODIGO</th>
                                            <th>NOMBRE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($SubFamilias_List as $Rows)
                                        {
                                            ?>
                                            <tr class="table-hover">
                                                <td>
                                                    <span class="pointer badge badge-pill bg-purple" onclick="crearEditar(<?=$Rows->id?>)">EDITAR</span>
                                                    <?php
                                                    if($Rows->estado==1){ ?>
                                                    <span class="pointer badge badge-pill bg-dark" onclick="actualizarEstado(<?=$Rows->id?>, 0)">BLOQUEAR</span>
                                                    <?php }
                                                    else{ ?>
                                                    <span class="pointer badge badge-pill bg-success" onclick="actualizarEstado(<?=$Rows->id?>, 1)">ACTIVAR</span>
                                                    <?php }
                                                    ?>
                                                </td>                                                
                                                <td><?=$Rows->familianombre?></td>
                                                <td><?=$Rows->codigo?></td>
                                                <td><?=$Rows->nombre?></td>
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





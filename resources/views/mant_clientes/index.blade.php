		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/mant_clientes.obfuscated.js') }}"></script>
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
                                    <li class="breadcrumb-item pe-3">MANTENEDOR DE CLIENTES</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="row">
                        <div class="card border-top border-0 border-4 border-primary">
                            <div class="card-body" style="overflow-x: auto; white-space: nowrap;">
                                <div class="card-title d-flex align-items-center">
                                    <h5 class="mb-0 text-primary">CLIENTES</h5>
                                </div>
                                <hr>
                                <table id="Clientes_List" class="table table-striped table-responive table-bordered" style="font-size:12px">
                                    <thead>
                                        <tr>
                                            <th>ACCIONES</th>
                                            <th>CODIGO</th>
                                            <th>NOMBRE</th>
                                            <th>EMAIL</th>
                                            <th>TELEFONO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($Clientes_List as $Rows)
                                        {
                                            ?>
                                            <tr class="table-hover">
                                                <td><span class="pointer badge badge-pill bg-success" onclick="crearEditar(<?=$Rows->codigo?>)">VER</span></td>
                                                <td><?php if(isset($Rows->codigo)){ echo $Rows->codigo; }?></td>
                                                <td><?php if(isset($Rows->nombre)){ echo $Rows->nombre; }?></td>
                                                <td><?php if(isset($Rows->email)){ echo $Rows->email; }?></td>
                                                <td><?php if(isset($Rows->fono)){ echo $Rows->fono; }?></td>
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





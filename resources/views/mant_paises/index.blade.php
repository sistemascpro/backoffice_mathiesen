		@extends("layouts.app")
        @section("script")
        <script src="assets/js/js/<?=$ModuloRuta?>.js"></script>
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
                                    <li class="breadcrumb-item pe-3"><?=$ModuloTitulo1?></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="row">
                        <div class="card border-top border-0 border-4 border-primary">
                            <div class="card-body" style="overflow-x: auto; white-space: nowrap;">
                                <div class="card-title d-flex align-items-center"><h5 class="mb-0 text-primary">PROVEEDORES</h5><span class="pointer ml-3 badge badge-pill bg-primary" onclick="Paises_CrearEditar(-1)">CREAR</span></div>
                                <input type="hidden" name="InputNombreRuta" id="InputNombreRuta" value="<?=$ModuloRuta?>" readonly/>
                                <input type="hidden" name="InputNombreRequired" id="InputNombreRequired" value="<?=$ModuloRequired?>" readonly/>
                                <hr>
                                <table id="Tabla_Listado" class="table table-striped table-responive table-bordered" style="font-size:12px">
                                    <thead>
                                        <tr>
                                            <th>ACCIONES</th>
                                            <th>CODIGO</th>
                                            <th>NOMBRE</th>
                                            <th>BANDERA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($Lista as $lsRows)
                                        {
                                            ?>
                                            <tr class="table-hover">
                                                <td>
                                                    <span class="pointer badge badge-pill bg-purple" onclick="Paises_CrearEditar(<?=$lsRows->id?>)">EDITAR</span>
                                                    <?php
                                                    if($lsRows->estado==1){ ?>
                                                    <span class="pointer badge badge-pill bg-dark" onclick="Paises_UpdateEstado(<?=$lsRows->id?>, 0)">BLOQUEAR</span>
                                                    <?php }
                                                    else{ ?>
                                                    <span class="pointer badge badge-pill bg-success" onclick="Paises_UpdateEstado(<?=$lsRows->id?>, 1)">ACTIVAR</span>
                                                    <?php }
                                                    ?>
                                                </td>
                                                <td><?=$lsRows->codigo?></td>
                                                <td><?=$lsRows->nombre?></td>
                                                <td><?php
                                                if($lsRows->bandera!=null){
                                                    ?><a href="<?=$lsRows->bandera?>" target="_blank"><img style="max-width:30px!important;" src="<?=$lsRows->bandera?>?<?=date("YmdHis")?>" alt="logo icon"></a><?php
                                                }
                                                ?></td>
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





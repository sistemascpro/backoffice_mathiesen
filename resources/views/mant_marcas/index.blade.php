		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/mant_marcas.js') }}"></script>
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
                                    <li class="breadcrumb-item pe-3">MANTENEDOR DE MARCAS</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="row">
                        <div class="card border-top border-0 border-4 border-primary">
                            <div class="card-body" style="overflow-x: auto; white-space: nowrap;">
                                <input
                                type="hidden"
                                class="form-control"
                                value="0"
                                id="id"
                                name="id"
                                readonly
                                />
                                <div class="card-title d-flex align-items-center">
                                    <h5 class="mb-0 text-primary">MARCAS</h5><span class="pointer ml-3 badge badge-pill bg-primary" onclick="MarcaCrearEditar(-1)">CREAR</span>
                                </div>
                                <hr>
                                <table id="Tabla_Listado" class="table table-striped table-responive table-bordered" style="font-size:12px">
                                    <thead>
                                        <tr>
                                            <th>ACCIONES</th>
                                            <th>POSICION</th>
                                            <th>NOMBRE</th>
                                            <th>CABECERA</th>
                                            <th>IMAGEN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($Lista as $lsRows)
                                        {
                                            ?>
                                            <tr class="table-hover">
                                                <td>
                                                    <span class="pointer badge badge-pill bg-purple" onclick="MarcaCrearEditar(<?=$lsRows->id?>)">EDITAR</span>
                                                    <?php
                                                    if($lsRows->estado==1){ ?>
                                                    <span class="pointer badge badge-pill bg-dark" onclick="MarcaUpdateEstado(<?=$lsRows->id?>, 0)">BLOQUEAR</span>
                                                    <?php }
                                                    else{ ?>
                                                    <span class="pointer badge badge-pill bg-success" onclick="MarcaUpdateEstado(<?=$lsRows->id?>, 1)">ACTIVAR</span>
                                                    <?php }
                                                    ?>
                                                </td>
                                                <td><?php if($lsRows->posicion==0){ echo "S/N"; } else { echo $lsRows->posicion; } ?></td>
                                                <td><?=$lsRows->nombre?></td>
                                                <td><?php
                                                if($lsRows->cabecera!=null){
                                                    ?><a href="<?=$lsRows->cabecera?>" target="_blank"><img style="max-width:200px!important;" src="<?=$lsRows->cabecera?>?<?=date("YmdHis")?>" alt="logo icon"></a><?php
                                                }
                                                ?></td>
                                                <td><?php
                                                if($lsRows->ruta!=null){
                                                    ?><a href="<?=$lsRows->ruta?>" target="_blank"><img style="max-width:200px!important;" src="<?=$lsRows->ruta?>?<?=date("YmdHis")?>" alt="logo icon"></a><?php
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





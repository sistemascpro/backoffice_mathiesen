		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/mant_productossubfamilias.js') }}"></script>
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
                                    <li class="breadcrumb-item pe-3"><a href="mant_productossubfamilias">MANTENEDOR DE SUB FAMILIAS</a></li>
                                    <li class="breadcrumb-item pe-3">CREAR/EDITAR SUB FAMILIA</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="card border-top border-0 border-4 border-primary">
                        <form class="row g-3" method="post" id="FormGuardar" enctype="multipart/form-data">@csrf
                            <input
                            type="hidden"
                            class="SubFamiliaRequired form-control"
                            value="<?=$SubFamilia[0]->id?>"
                            id="subfamiliaid"
                            name="subfamiliaid"
                            readonly
                            />
                        <div class="card-body">
                            <div class="col-12 mb-3">
                                <h5 class="mb-0 text-primary">INFORMACIÓN</h5>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">ESTADO</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select
                                    class="SubFamiliaRequired form-select"
                                    maxlength="30"
                                    id="estado"
                                    name="estado"
                                    >
                                        <option value=1 <?php if($SubFamilia[0]->estado==true){ ?>selected<?php }?>>ACTIVO</option>
                                        <option value=0 <?php if($SubFamilia[0]->estado==false){ ?>selected<?php }?>>BLOQUEADO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">FAMILIA</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select
                                    class="SubFamiliaRequired form-select single-select"
                                    maxlength="30"
                                    id="fk_familia"
                                    name="fk_familia"
                                    data-live-search="true"
                                    >
                                        <option value="">SELECCCIONAR...</option>
                                        <?php foreach($Familias as $lsFamilia){
                                            ?><option value="<?=$lsFamilia->id?>" <?=$lsFamilia->selected?>><?=$lsFamilia->codigo." ".$lsFamilia->nombre?></option><?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">CODIGO</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                    type="text"
                                    class="SubFamiliaRequired form-control"
                                    maxlength="250"
                                    id="codigo"
                                    name="codigo"
                                    value="<?=$SubFamilia[0]->codigo?>"
                                    onkeyup="ValidarCaracteres('codigo')"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">NOMBRE</p>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                    type="text"
                                    class="SubFamiliaRequired form-control"
                                    maxlength="250"
                                    id="nombre"
                                    name="nombre"
                                    value="<?=$SubFamilia[0]->nombre?>"
                                    onkeyup="ValidarCaracteres('nombre')"
                                    />
                                </div>
                            </div>
                            <br>
                            <br>
                            <span  class="row mt-3">
                                <div class="col-sm-4 text-secondary align-middle">
                                    <input type="button" class="btn btn-primary px-4" value="GUARDAR CAMBIOS" onclick="Guardar();" />
                                </div>
                            </span >
                        </div>
                        </form>
                    </div>
                </div>
            </div>
		@endsection





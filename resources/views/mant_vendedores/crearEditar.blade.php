		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/mant_vendedores.obfuscated.js') }}"></script>
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
                                    <li class="breadcrumb-item pe-3"><a href="mant_vendedores">MANTENEDOR DE VENDEDORES</a></li>
                                    <li class="breadcrumb-item pe-3">CREAR/EDITAR VENDEDOR</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="card border-top border-0 border-4 border-primary">
                        <form class="row g-3" method="post" id="FormGuardarVendedor" enctype="multipart/form-data">@csrf
                            <input
                            type="hidden"
                            class="VendRequired form-control"
                            value="<?=$Vendedor[0]->vendedorid?>"
                            id="VendedorId"
                            name="VendedorId"
                            readonly
                            />
                        <div class="card-body">
                            <div class="col-12 mb-3">
                                <h5 class="mb-0 text-primary">INFORMACIÓN</h5>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="row mb-3 col-6">
                                    <div class="col-sm-3">
                                        <p class="mb-0">USUARIO</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input
                                        type="text"
                                        class="VendRequired form-control"
                                        value="<?=$Vendedor[0]->usuario?>"
                                        id="usuario"
                                        name="usuario"
                                        onkeyup="ValidarCaracteres('usuario')"
                                        />
                                    </div>
                                </div>
                                <div class="row mb-3 col-6">
                                    <div class="col-sm-3">
                                        <p class="mb-0">ESTADO</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <select
                                        class="VendRequired form-select"
                                        maxlength="30"
                                        id="estado"
                                        name="estado"
                                        >
                                        <option value=true <?php if($Vendedor[0]->estado==true){ ?>selected<?php }?>>ACTIVO</option>
                                        <option value=false <?php if($Vendedor[0]->estado==false){ ?>selected<?php }?>>BLOQUEADO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="row mb-3 col-6">
                                    <div class="col-sm-3">
                                        <p class="mb-0">CONTRASEÑA</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input
                                        type="password"
                                        class="form-control"
                                        value=""
                                        id="contrasenia1"
                                        name="contrasenia1"
                                        onkeyup="ValidarCaracteres('contrasenia1')"
                                        />
                                    </div>
                                </div>
                                <div class="row mb-3 col-6">
                                    <div class="col-sm-3">
                                        <p class="mb-0">REPETIR</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input
                                        type="password"
                                        class="form-control"
                                        value=""
                                        id="contrasenia2"
                                        name="contrasenia2"
                                        onkeyup="ValidarCaracteres('contrasenia2')"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="row mb-3 col-6">
                                    <div class="col-sm-3">
                                        <p class="mb-0">ROL</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <select
                                        type="text"
                                        class="VendRequired form-select"
                                        maxlength="30"
                                        id="fk_rol"
                                        name="fk_rol"
                                        >
                                        <option value="2">VENDEDOR</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3 col-6">
                                    <div class="col-sm-3">
                                        <p class="mb-0">RUT</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input
                                        type="text"
                                        class="VendRequired form-control"
                                        maxlength="30"
                                        id="rut"
                                        name="rut"
                                        value="<?=$Vendedor[0]->rut?>"
                                        onkeyup="javascript:this.value=this.value.toUpperCase(); ValidateRut_Tipeando('rut');"
                                        onfocusout="ValidateRut_FocusOut('rut')"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="row mb-3 col-6">
                                    <div class="col-sm-3">
                                        <p class="mb-0">NOMBRES</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input
                                        type="text"
                                        class="VendRequired form-control"
                                        maxlength="250"
                                        id="nombres"
                                        name="nombres"
                                        value="<?=$Vendedor[0]->nombres?>"
                                        onkeyup="ValidarCaracteres('nombres')"
                                        />
                                    </div>
                                </div>
                                <div class="row mb-3 col-6">
                                    <div class="col-sm-3">
                                        <p class="mb-0">APELLIDOS</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input
                                        type="text"
                                        class="VendRequired form-control"
                                        maxlength="250"
                                        id="apellidos"
                                        name="apellidos"
                                        value="<?=$Vendedor[0]->apellidos?>"
                                        onkeyup="ValidarCaracteres('apellidos')"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="row mb-3 col-6">
                                    <div class="col-sm-3">
                                        <p class="mb-0">TELEFONO PRINCIPAL</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input
                                        type="text"
                                        class="VendRequired form-control"
                                        maxlength="50"
                                        id="telefono1"
                                        name="telefono1"
                                        value="<?=$Vendedor[0]->telefono1?>"
                                        onkeyup="ValidarCaracteres('telefono1')"
                                        />
                                    </div>
                                </div>
                                <div class="row mb-3 col-6">
                                    <div class="col-sm-3">
                                        <p class="mb-0">TELEFONO SECUNDARIO</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input
                                        type="text"
                                        class="form-control"
                                        maxlength="50"
                                        id="telefono2"
                                        name="telefono2"
                                        value="<?=$Vendedor[0]->telefono2?>"
                                        onkeyup="ValidarCaracteres('telefono2')"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="row mb-3 col-6">
                                    <div class="col-sm-3">
                                        <p class="mb-0">EMAIL</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input
                                        type="text"
                                        class="VendRequired form-control"
                                        maxlength="250"
                                        id="email"
                                        name="email"
                                        value="<?=$Vendedor[0]->email?>"
                                        onkeyup="ValidarCaracteres('email')"
                                        />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <span  class="row">
                                <div class="col-sm-4 text-secondary align-middle">
                                    <input type="button" class="btn btn-primary px-4" value="GUARDAR CAMBIOS" onclick="GuardarVendedor();" />
                                </div>
                            </span >
                            <br>
                            <br>
                            <div class="col-12 mb-3">
                                <h6 class="mb-0 text-primary">CLIENTES ASOCIADOS</h6>
                            </div>
                            <table id="Clientes_List" class="table table-striped table-responive table-bordered" style="font-size:12px">
                                <thead>
                                    <tr>
                                        <th>CODIGO</th>
                                        <th>CLIENTE</th>
                                        <th>CONTACTO</th>
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
                                            <td><?=$Rows->codigo?></td>
                                            <td><?=$Rows->nombre?></td>
                                            <td><?=$Rows->contacto?></td>
                                            <td><?=$Rows->email?></td>
                                            <td><?=$Rows->telefono?></td>
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





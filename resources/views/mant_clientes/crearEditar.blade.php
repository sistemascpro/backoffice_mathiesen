		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/mant_clientes.js') }}"></script>
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
                                    <li class="breadcrumb-item pe-3"><a href="mant_clientes">MANTENEDOR DE CLIENTES</a></li>
                                    <li class="breadcrumb-item pe-3">VER CLIENTE</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body">
                            <form class="row g-3" method="post" id="FormGuardarCliente" enctype="multipart/form-data">@csrf
                                <div class="col-12 mb-3">
                                    <h5 class="mb-0 text-primary">CLIENTE: <?php if(isset($Cliente[0]->nombre)){echo $Cliente[0]->nombre;} ?></h5>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                        <div class="col-sm-4">
                                            <p class="mb-0">CODIGO</p>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                            <input
                                            type="text"
                                            class="CliRequired form-control"
                                            value="<?php if(isset($Cliente[0]->codigo)){echo $Cliente[0]->codigo;} ?>"
                                            id="cli_codigo"
                                            name="cli_codigo"
                                            readonly
                                            />
                                        </div>
                                    </div>
                                    <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                        <div class="col-sm-4">
                                            <p class="mb-0">NOMBRE</p>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                            <input
                                            type="text"
                                            class="CliRequired form-control"
                                            value="<?php if(isset($Cliente[0]->nombre)){echo $Cliente[0]->nombre;} ?>"
                                            id="cli_nombre"
                                            name="cli_nombre"
                                            readonly
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                        <div class="col-sm-4">
                                            <p class="mb-0">GIRO</p>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                            <input
                                            type="text"
                                            class="CliRequired form-control"
                                            value="<?php if(isset($Cliente[0]->giro)){echo $Cliente[0]->giro;} ?>"
                                            id="cli_giro"
                                            name="cli_giro"
                                            readonly
                                            />
                                        </div>
                                    </div>
                                    <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                        <div class="col-sm-4">
                                            <p class="mb-0">DIRECCION</p>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                            <input
                                            type="text"
                                            class="CliRequired form-control"
                                            value="<?php if(isset($Cliente[0]->direccion)){echo $Cliente[0]->direccion;} ?>"
                                            id="cli_direccion"
                                            name="cli_direccion"
                                            readonly
                                            />
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                        <div class="col-sm-4">
                                            <p class="mb-0">VENDEDOR</p>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                            <input
                                            type="text"
                                            class="CliRequired form-control"
                                            value="<?php if(isset($Cliente[0]->vendedor)){echo $Cliente[0]->vendedor;} ?>"
                                            id="cli_vendedor"
                                            name="cli_vendedor"
                                            readonly
                                            />
                                        </div>
                                    </div>
                                    <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                        <div class="col-sm-4">
                                            <p class="mb-0">FORMA DE PAGO</p>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                            <input
                                            type="text"
                                            class="CliRequired form-control"
                                            value="<?php if(isset($Cliente[0]->condicionventa)){echo $Cliente[0]->condicionventa;} ?>"
                                            id="cli_formapago"
                                            name="cli_formapago"
                                            readonly
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                        <div class="col-sm-4">
                                            <p class="mb-0">LISTA DE PRECIO</p>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                            <input
                                            type="text"
                                            class="CliRequired form-control"
                                            value="<?php if(isset($Cliente[0]->listaprecio)){echo $Cliente[0]->listaprecio;} ?>"
                                            id="cli_nombrelistaprecio"
                                            name="cli_nombrelistaprecio"
                                            readonly
                                            />
                                        </div>
                                    </div>
                                    <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                        <div class="col-sm-4">
                                            <p class="mb-0">TELEFONO</p>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                            <input
                                            type="text"
                                            class="CliRequired form-control"
                                            value="<?php if(isset($Cliente[0]->fono)){echo $Cliente[0]->fono;} ?>"
                                            id="cli_email"
                                            name="cli_email"
                                            readonly
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                        <div class="col-sm-4">
                                            <p class="mb-0">EMAIL</p>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                            <input
                                            type="text"
                                            class="CliRequired form-control"
                                            value="<?php if(isset($Cliente[0]->email)){echo $Cliente[0]->email;} ?>"
                                            id="cli_contacto"
                                            name="cli_contacto"
                                            readonly
                                            />
                                        </div>
                                    </div>
                                    <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                        <div class="col-sm-4">
                                            <p class="mb-0">EMAIL FACTURACION</p>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                            <input
                                            type="text"
                                            class="CliRequired form-control"
                                            value="<?php if(isset($Cliente[0]->emaildte)){echo $Cliente[0]->emaildte;} ?>"
                                            id="cli_telefono"
                                            name="cli_telefono"
                                            readonly
                                            />
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <ul class="nav nav-tabs nav-primary" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#primaryusuarios" role="tab" aria-selected="true">
                                        <div class="d-flex align-items-center">
                                            <div class="tab-icon"><i class='bx bx-user-circle font-18 me-1'></i>
                                            </div>
                                            <div class="tab-title">USUARIOS</div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content py-3 border p-2">
                                </br>
                                <div class="tab-pane fade show active" id="primaryusuarios" role="tabpanel">
                                    <form class="row g-3" method="post" id="FormGuardarUsuario" enctype="multipart/form-data">@csrf
                                        <input
                                        type="hidden"
                                        class="UsuRequired form-control"
                                        value="<?php if(isset($Cliente[0]->codigo)){echo $Cliente[0]->codigo;} ?>"
                                        id="ClienteId"
                                        name="ClienteId"
                                        readonly
                                        />
                                        <input
                                        type="hidden"
                                        class="UsuRequired form-control"
                                        value="<?=$UsuarioId?>"
                                        id="UsuarioId"
                                        name="UsuarioId"
                                        readonly
                                        />
                                        <div class="row">
                                            <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">USUARIO</p>
                                                </div>
                                                <div class="col-sm-8 text-secondary">
                                                    <input
                                                    type="text"
                                                    class="UsuRequired form-control"
                                                    id="usuario"
                                                    name="usuario"
                                                    />
                                                </div>
                                            </div>
                                            <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">ESTADO</p>
                                                </div>
                                                <div class="col-sm-8 text-secondary">
                                                    <select
                                                    class="UsuRequired form-select"
                                                    maxlength="30"
                                                    id="estado"
                                                    name="estado"
                                                    >
                                                        <option value=true>ACTIVO</option>
                                                        <option value=false>BLOQUEADO</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">CONTRASEÑA</p>
                                                </div>
                                                <div class="col-sm-8 text-secondary">
                                                    <input
                                                    type="password"
                                                    class="form-control"
                                                    id="contrasenia1"
                                                    name="contrasenia1"
                                                    onkeyup="ValidarCaracteres('contrasenia1')"
                                                    />
                                                </div>
                                            </div>
                                            <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">REPETIR</p>
                                                </div>
                                                <div class="col-sm-8 text-secondary">
                                                    <input
                                                    type="password"
                                                    class="form-control"
                                                    id="contrasenia2"
                                                    name="contrasenia2"
                                                    onkeyup="ValidarCaracteres('contrasenia2')"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">ROL</p>
                                                </div>
                                                <div class="col-sm-8 text-secondary">
                                                    <select
                                                    type="text"
                                                    class="UsuRequired form-select"
                                                    maxlength="30"
                                                    id="fk_rol"
                                                    name="fk_rol"
                                                    >
                                                    <option value="<?=$Rol[0]->id?>">CLIENTE</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">RUT</p>
                                                </div>
                                                <div class="col-sm-8 text-secondary">
                                                    <input
                                                    type="text"
                                                    class="UsuRequired form-control"
                                                    maxlength="30"
                                                    id="rut"
                                                    name="rut"
                                                    onkeyup="javascript:this.value=this.value.toUpperCase(); ValidateRut_Tipeando('rut');"
                                                    onfocusout="ValidateRut_FocusOut('rut')"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">NOMBRES</p>
                                                </div>
                                                <div class="col-sm-8 text-secondary">
                                                    <input
                                                    type="text"
                                                    class="UsuRequired form-control"
                                                    maxlength="250"
                                                    id="nombres"
                                                    name="nombres"
                                                    onkeyup="ValidarCaracteres('nombres')"
                                                    />
                                                </div>
                                            </div>
                                            <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">APELLIDOS</p>
                                                </div>
                                                <div class="col-sm-8 text-secondary">
                                                    <input
                                                    type="text"
                                                    class="UsuRequired form-control"
                                                    maxlength="250"
                                                    id="apellidos"
                                                    name="apellidos"
                                                    onkeyup="ValidarCaracteres('apellidos')"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">TELEFONO PRINCIPAL</p>
                                                </div>
                                                <div class="col-sm-8 text-secondary">
                                                    <input
                                                    type="text"
                                                    class="UsuRequired form-control"
                                                    maxlength="50"
                                                    id="telefono1"
                                                    name="telefono1"
                                                    onkeyup="ValidarCaracteres('telefono1')"
                                                    />
                                                </div>
                                            </div>
                                            <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">TELEFONO SECUNDARIO</p>
                                                </div>
                                                <div class="col-sm-8 text-secondary">
                                                    <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="50"
                                                    id="telefono2"
                                                    name="telefono2"
                                                    onkeyup="ValidarCaracteres('telefono2')"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="row mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">EMAIL</p>
                                                </div>
                                                <div class="col-sm-8 text-secondary">
                                                    <input
                                                    type="text"
                                                    class="UsuRequired form-control"
                                                    maxlength="250"
                                                    id="email"
                                                    name="email"
                                                    onkeyup="ValidarCaracteres('email')"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <span  class="row">
                                        <div class="col-sm-4 text-secondary align-middle">
                                            <input type="button" class="btn btn-primary px-4" value="GUARDAR CAMBIOS" onclick="GuardarUsuario();" />
                                        </div>
                                    </span >
                                    <div class="row mb-3 mt-6">
                                        <div class="col-sm-2">
                                            <p class="mb-0">USUARIO</p>
                                        </div>
                                        <div class="col-sm-6 text-secondary">
                                            <select
                                            type="text"
                                            class="form-select"
                                            maxlength="30"
                                            id="UsuarioExistente"
                                            name="UsuarioExistente"
                                            >
                                            <option value="" selected>Seleccionar...</option>
                                            <?php
                                            foreach ($UsuariosNo_List as $lsUsuario)
                                            {
                                                ?><option value="<?=$lsUsuario->id?>"><?=$lsUsuario->nombres." ".$lsUsuario->apellidos?></option><?php
                                            }
                                            ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 text-secondary align-middle">
                                            <input type="button" class="btn bg-purple px-4" value="GUARDAR EXISTENTE" onclick="GuardarUsuarioExistente();" />
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="col-12 mb-3">
                                        <h6 class="mb-0 text-primary">USUARIOS ASOCIADOS</h6>
                                    </div>
                                    <table id="Usuarios_List" class="table table-striped table-responive table-bordered" style="font-size:12px">
                                        <thead>
                                            <tr>
                                                <th>ACCIONES</th>
                                                <th>ID</th>
                                                <th>ESTADO</th>
                                                <th>USUARIO</th>
                                                <th>RUT</th>
                                                <th>NOMBRES</th>
                                                <th>APELLIDOS</th>
                                                <th>TELEF 1</th>
                                                <th>EMAIL</th>
                                                <th>ROL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($Usuarios_List as $Rows)
                                            {
                                                ?>
                                                <tr class="table-hover">
                                                    <td>
                                                        <span class="pointer badge badge-pill bg-purple" onclick="editarUsuario('<?=$Rows->id?>')">EDITAR</span>
                                                        <?php
                                                        if($Rows->estado){ ?>
                                                        <span class="pointer badge badge-pill bg-dark" onclick="bloquearUsuario('<?=$Rows->id?>', false)">BLOQUEAR</span>
                                                        <?php }
                                                        else{ ?>
                                                        <span class="pointer badge badge-pill bg-success" onclick="bloquearUsuario('<?=$Rows->id?>', true)">ACTIVAR</span>
                                                        <?php }
                                                        ?>
                                                    </td>
                                                    <td><?=$Rows->id?></td>
                                                    <td><strong><?php
                                                    if($Rows->estado){ ?><span class="text-success">ACTIVO</span><?php }
                                                    else{ ?><span class="text-danger">BLOQUEADO</span><?php }
                                                    ?></strong></td>
                                                    <td><?=$Rows->usuario?></td>
                                                    <td><?=$Rows->rut?></td>
                                                    <td><?=$Rows->nombres?></td>
                                                    <td><?=$Rows->apellidos?></td>
                                                    <td><?=$Rows->telefono1?></td>
                                                    <td><?=$Rows->email?></td>
                                                    <td><?=$Rows->rol_nombre?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- -->
                                <!-- -->
                            </div>
                            <span  class="row mt-3">
                                <div class="col-sm-4 text-secondary align-middle">
                                    <a href="mant_clientes"><input type="button" class="btn btn-success px-4" value="VOLVER"/></a>
                                </div>
                            </span >
                        </div>
                    </div>
                </div>
            </div>
		@endsection





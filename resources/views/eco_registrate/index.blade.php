@include("eco_templates.eco_template_01")
    <div id="eco_productos">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Página de inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Registro</li>
            </ol>
        </nav>
        <div class="container-flow fullBanner-sm2 "  style="background-image: url('img/headerregistro.jpg'); background-repeat: no-repeat; background-size: cover; background-position:top center" >
        </div>

<div class="container contContact" style="position:relative; top:-100px">
    <div class="row">
        <div class="col-xl-6">
        <div id="DivRegistroProcesando" style="display:none"></div>
        <div id="DivRegistroBotones">
            <div class="col-12" onclick="CargarRegistro('Comprador');">
                <h1> Registro</h1>
                <a href="#">
                    <div class="col registroItem">
                        <h1>Soy un comprador</h1>
                        <span class="subtitle-r">Comprar productos en Mathiesen</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 64 64">
                            <path fill="currentColor" fill-rule="evenodd"
                            d="M31.991 25.056L7.49 49.558c-1.148 1.148-3.003 1.155-4.181-.024l-2.44-2.44c-1.162-1.161-1.145-3.061-.025-4.181L29.89 13.868c1.161-1.162 3.061-1.145 4.181-.025l29.07 29.07c1.148 1.148 1.154 3.002-.025 4.181l-2.44 2.44c-1.16 1.161-3.06 1.144-4.18.024L31.99 25.056z">
                            </path>
                        </svg>
                    </div>
                </a>
            </div>

            <div class="col-12" onclick="CargarRegistro('Proveedor');">
                <a href="#">
                    <div class="col registroItem">
                        <h1>Soy un proveedor</h1>
                        <span class="subtitle-r">Vender productos en Mathiesen</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 64 64">
                            <path fill="currentColor" fill-rule="evenodd"
                            d="M31.991 25.056L7.49 49.558c-1.148 1.148-3.003 1.155-4.181-.024l-2.44-2.44c-1.162-1.161-1.145-3.061-.025-4.181L29.89 13.868c1.161-1.162 3.061-1.145 4.181-.025l29.07 29.07c1.148 1.148 1.154 3.002-.025 4.181l-2.44 2.44c-1.16 1.161-3.06 1.144-4.18.024L31.99 25.056z">
                            </path>
                        </svg>
                    </div>
                </a>
                <div style="margin-top: 30px;">
                    ¿Ya tienes cuenta? <a href="/login">Inicia sesión</a>
                </div>
            </div>
        </div>


        <div id="DivFormRegistro" class="col-12" style="display:none">
            <h1> Registro <span style="color:var(--acent-500)"><span id="IdRegistroName"></span></span></h1>
            <form id="FormClienteNuevo" enctype="multipart/form-data">
                @csrf
                <input type="hidden" readonly class="ContCliente form-control" id="RegTipo" name="RegTipo" aria-describedby="name">
                <div class="col">
                    <label for="exampleInputEmail1" class="form-label">Nombre</label>
                    <input type="text" class="ContCliente form-control" id="RegNombre" name="RegNombre" aria-describedby="name">
                    <div id="name" class="form-text">Ingresa tu nombre.</div>
                </div>
                <div class="col">
                    <label for="exampleInputEmail1" class="form-label">Apellido</label>
                    <input type="text" class="ContCliente form-control" id="RegApellido" name="RegApellido" aria-describedby="name">
                    <div id="lastname" class="form-text">Ingresa tu apellido</div>
                </div>
                <div class="col">
                    <label for="exampleInputEmail1" class="form-label">Nombre de la empresa</label>
                    <input type="text" class="ContCliente form-control" id="RegEmpresa" name="RegEmpresa" aria-describedby="name">
                    <div id="name" class="form-text">Ingresa el nombre de tu empresa</div>
                </div>
                <div class="col">
                    <label for="exampleInputEmail1" class="form-label">Email de la empresa</label>
                    <input type="text" class="ContCliente form-control" id="RegEmail" name="RegEmail" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">Ingresa un correo valido de empresa</div>
                </div>
                <div class="col">
                    <label for="exampleInputEmail1" class="form-label">Teléfono de la empresa</label>
                    <input class="ContCliente form-control" id="RegTelefono" name="RegTelefono" aria-describedby="emailHelp">
                </div>
                <div class="col">
                    <label for="exampleInputpassword" class="form-label">Contraseña</label>
                    <input type="password" class="ContCliente form-control" id="RegContrasenia1" name="RegContrasenia1">
                    <div id="name" class="form-text">Se guardará en minúsculas</div>
                </div>
                <div class="col">
                    <label for="exampleInputpassword" class="form-label">Validar Contraseña</label>
                    <input type="password" class="ContCliente form-control" id="RegContrasenia2" name="RegContrasenia2">
                    <div id="name" class="form-text">Se guardará en minúsculas</div>
                </div>
            </form>
            <div class="btn btn-primar btn-lg btn-primary-mat" style="width:100%; margin-top:20px" onclick="EnviarRegistro();">Enviar</div>
        </div>
        </div>
        <div class="col-xl-6 imgContact">
            <img src="/img/Registro.jpg" alt="imagen de página de contacto" />
        </div>
    </div>
     </div>
</div>
</div>
    @include("eco_templates.eco_template_02")
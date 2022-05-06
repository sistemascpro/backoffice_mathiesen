    @include("eco_templates.eco_template_01")
        <div id="eco_productos" class="containerEco">
            <div id="eco_productos" class="row d-flex justify-content-center bg-white p-5" style="min-width:100%">

                <div class="text-center mb-10">
                    <h1 class=" title text-danger text-capitalize">SEA NUESTRO CLIENTE</h1>
                </div>
                
                <span class="main-container blockquote text-justify">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae erat et ipsum elementum posuere sed eu augue. Proin mi velit, faucibus sit amet euismod a, dictum scelerisque sem. Fusce sit amet leo leo. Sed suscipit iaculis dui eget dignissim. Vestibulum egestas semper est nec dictum. Praesent vehicula sodales ipsum, id aliquam turpis vehicula in. Aenean nibh ante, facilisis lacinia posuere vitae, blandit eu dolor. Praesent iaculis metus sit amet luctus laoreet.
                </span>

                <div class="text-center mt-30 mb-30">
                    <h6 class=" title text-danger text-capitalize"><a href="#" target="_blank">VER POLITICAS COMERCIALES</a></h6>
                </div>

                <form method="post" id="FormClienteNuevo" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxx-6">
                            <input class="ContCliente form-control mb-2" type="hidden" placeholder="* Razon Social" id="Reg_Id" name="Reg_Id" value="2">
                            <input class="ContCliente form-control mb-2" type="text" placeholder="* Razon Social" id="Reg_RazonSocial" name="Reg_RazonSocial">
                            <input class="ContCliente form-control mb-2" type="email" placeholder="* Rut" id="Reg_Rut" name="Reg_Rut">
                            <input class="ContCliente form-control mb-2" type="text" placeholder="* Giro Comercial" id="Reg_GiroComercial" name="Reg_GiroComercial">
                            <input class="ContCliente form-control mb-2" type="email" placeholder="* Direccion" id="Reg_Direccion1" name="Reg_Direccion1">
                            <input class="ContCliente form-control mb-2" type="text" placeholder="* Ciudad" id="Reg_Ciudad1" name="Reg_Ciudad1">
                            <input class="ContCliente form-control mb-2" type="email" placeholder="* Comuna" id="Reg_Comuna1" name="Reg_Comuna1">
                            <input class="ContCliente form-control mb-2" type="text" placeholder="* Telefono" id="Reg_Telefono1" name="Reg_Telefono1">
                            <input class="ContCliente form-control mb-2" type="text" placeholder="* Nombre Contacto" id="Reg_Contacto1" name="Reg_Contacto1">
                            <input class="ContCliente form-control mb-2" type="text" placeholder="* Email Contacto" id="Reg_Email2" name="Reg_Email2">
                            <input class="ContCliente form-control mb-2" type="text" placeholder="* Telefono Contacto" id="Reg_Telefono2" name="Reg_Telefono2">
                            <select type="tex" class="ContCliente form-control" id="FacturaBoleta" name="FacturaBoleta" onchange="CargarEmailDte();">
                                <option value="">Seleccionar...</option>
                                <option value="Factura">Factura</option>
                                <option value="Boleta">Boleta</option>
                            </select><br>
                            <div id="DivEmailDTE" style="display: none">
                                <input type="tex" class="form2" id="Reg_EmailDTE" name="Reg_EmailDTE" placeholder="* Email DTE">
                            </div>  
                        </div>
                </form>
                <div class="text-center col-12 mb-4">
                    <span class="col-3 btn btn-primary">Enviar</span>
                </div>
            </div>
        </div>
    </div>
    @include("eco_templates.eco_template_02")


function LogOutFeria(){
    $.ajax({
        url: '/eco_LogOutFeria',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
        },
        success:function(data) {
            location.reload();
        },error:function(XMLHttpRequest,textStatus,errorThrown) {
            location.reload();
        }
    });
}

function LoginFeria(){
    $.ajax({
        url: '/eco_LoginFeria',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , user:$("#user").val()
            , password:$("#password").val()
        },
        success:function(data) {
            if(data=='OK'){
                location.reload();
            }else{
                Swal.fire({
                    title:"",
                    text: "LA INFORMACIÓN INGRESADA NO ES VÁLIDA",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonClass: "btn-warning",
                    confirmButtonText: "OK!",
                    closeOnConfirm: false
                });
            }
        },error:function(XMLHttpRequest,textStatus,errorThrown) {
            Swal.fire({
                title:"",
                text: "LA INFORMACIÓN INGRESADA NO ES VÁLIDA",
                type: "warning",
                showCancelButton: false,
                confirmButtonClass: "btn-warning",
                confirmButtonText: "OK!",
                closeOnConfirm: false
            });
        }
    });
}
function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  } 
function EnviarRegistro(Id)
{
    var ErrorMailFactura = 0;
    if ($('#FacturaBoleta').val()=='Factura')
    {
        if(validateEmail($('#Reg_EmailDTE').val())==false)
        {
            ErrorMailFactura = 1;
        }
    }

    var ErrorMailCertificado = 0;
    if (document.getElementById('Requiero').checked) 
    {
        if(validateEmail($('#Reg_Mail2').val())==false)
        {
            ErrorMailCertificado = 1;
        }
    }

    if(ValidateRut($('#Reg_Rut').val())==false)
    {
        Swal.fire({
            title:"Error",
            text: "El rut ingresado no es valido",
            type: "warning",
            showCancelButton: false,
            confirmButtonClass: "btn-warning",
            confirmButtonText: "OK!",
            closeOnConfirm: false
        });
    }
    else if(ErrorMailFactura==1)
    {
        Swal.fire({
            title:"Error",
            text: "Debe ingresar un email de DTE valido",
            type: "warning",
            showCancelButton: false,
            confirmButtonClass: "btn-warning",
            confirmButtonText: "OK!",
            closeOnConfirm: false
        });
    }
    else if(ErrorMailCertificado==1)
    {
        Swal.fire({
            title:"Error",
            text: "Debe ingresar un email de medico valido",
            type: "warning",
            showCancelButton: false,
            confirmButtonClass: "btn-warning",
            confirmButtonText: "OK!",
            closeOnConfirm: false
        });
    }        
    else if(validateEmail($('#Reg_Email2').val())==false)
    {
        Swal.fire({
            title:"Error",
            text: "Debe ingresar un email de contacto valido",
            type: "warning",
            showCancelButton: false,
            confirmButtonClass: "btn-warning",
            confirmButtonText: "OK!",
            closeOnConfirm: false
        });
    }
    else if(ValidarRequeridos('ContCliente')==0)
    {
        $('#Reg_Rut').val(ValidateRut($('#Reg_Rut').val()));
        window.scrollTo(0,0);
        var formInfo = new FormData($("#FormClienteNuevo")[0]);
        $.ajax({
                url: 'eco_EnviarRegistro',
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: formInfo,
                contentType: false,
                processData: false,
                success:function(data)
                {
                    if(data=="OK")
                    {
                        Swal.fire({
                            title: "",
                            text: "Su mensaje fue enviado correctamente",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-warning",
                            confirmButtonText: "OK!",
                            closeOnConfirm: false
                        });
                    }
                    else
                    {
                        Swal.fire({
                            title: "",
                            text: "No se pudo enviar el correo, favor intentar mas tarde",
                            type: "error",
                            showCancelButton: false,
                            confirmButtonClass: "btn-warning",
                            confirmButtonText: "OK!",
                            closeOnConfirm: false
                        });
                    }
                }
            });
    }
}        
function EnviarContacto()
{
    if(validateEmail($('#Con_Correo').val())==false)
    {
        Swal.fire({
            title:"Error",
            text: "Debe ingresar un email valido",
            type: "warning",
            showCancelButton: false,
            confirmButtonClass: "btn-warning",
            confirmButtonText: "OK!",
            closeOnConfirm: false
        });
    }
    if(!$('#Con_Nombre').val() || !$('#Con_Telefono').val() || !$('#Con_Correo').val() || !$('#Con_Mensaje').val())
    {
        Swal.fire({
            title: "",
            text: "Debe ingresar toda la informacion del formulario de contacto",
            type: "warning",
            showCancelButton: false,
            confirmButtonClass: "btn-warning",
            confirmButtonText: "OK!",
            closeOnConfirm: false
        });
    }
    else
    {
        window.scrollTo(0,0);
        $.ajax({
                url: '/eco_EnviarCorreoContacto',
                type: 'POST',
                //headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data:{
                    plataforma:'web'
                    , Nombre:$('#Con_Nombre').val()
                    , Correo:$('#Con_Correo').val()
                    , Telefono:$('#Con_Telefono').val()
                    , Mensaje:$('#Con_Mensaje').val()
                    , _token : $("#_token").val()
                },
                success:function(data)
                {
                    if(data=="OK")
                    {
                        
                        Swal.fire({
                            title: "",
                            text: "Su mensaje fue enviado correctamente",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-warning",
                            confirmButtonText: "OK!",
                            closeOnConfirm: false
                        });
                    }
                    else
                    {
                        Swal.fire({
                            title: "",
                            text: "No se pudo enviar el correo, favor intentar mas tarde",
                            type: "error",
                            showCancelButton: false,
                            confirmButtonClass: "btn-warning",
                            confirmButtonText: "OK!",
                            closeOnConfirm: false
                        });
                    }
                }
            });
    }
}
function CargarRequiero()
{
    if (document.getElementById('Requiero').checked) 
    {
        document.getElementById('DivMedicamentosControlados').style.display = 'Block';
        $('#Certificado').addClass('ContCliente');
        $('#Rut2').addClass('ContCliente');
        $('#Direccion2').addClass('ContCliente');
        $('#Ciudad2').addClass('ContCliente');
        $('#Comuna2').addClass('ContCliente');
        $('#Mail2').addClass('ContCliente');
        $('#Telefono2').addClass('ContCliente');
        $('#Mensaje2').addClass('ContCliente');
    } 
    else 
    {
        document.getElementById('DivMedicamentosControlados').style.display = 'none';
        $('#Certificado').removeClass('ContCliente');
        $('#Rut2').removeClass('ContCliente');
        $('#Direccion2').removeClass('ContCliente');
        $('#Ciudad2').removeClass('ContCliente');
        $('#Comuna2').removeClass('ContCliente');
        $('#Mail2').removeClass('ContCliente');
        $('#Telefono2').removeClass('ContCliente');
        $('#Mensaje2').addClass('ContCliente');            
    }
}

function CargarEmailDte()
{
    if($('#FacturaBoleta').val()=='Factura')
    {
        document.getElementById('DivEmailDTE').style.display = 'block';
        $('#Mensaje2').addClass('ContCliente');
    }
    else
    {
        document.getElementById('DivEmailDTE').style.display = 'none';
        $('#Mensaje2').removeClass('ContCliente');
    }
}

function SuccessAutoClose(){
    Swal.fire({ position:'top-center', icon: 'success', title: '', showConfirmButton: false, timer: 800 });
}

function RealizarPago(Tipo, Url){
    $.ajax({
        url: 'eco_RealizarPago',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
        },
        success:function(data) {
            if(data=='ERROR_SinPedido'){
                Swal.fire('', ' NO TIENE UN PEDIDO EN PROCESO!', 'error' );
            } else if(data=='ERROR_SinProductos'){
                Swal.fire('', ' EL PEDIDO NO TIENE PRODUCTOS!', 'error' );
            } else if(data=='ERROR_DespachoCodigo'){
                Swal.fire('', ' EL PEDIDO NO TIENE DIRECCION DESPACHO!', 'error' );
            } else if(data=='ERROR_DespachoOpcion'){
                Swal.fire('', ' EL PEDIDO NO TIENE OPCION DE DESPACHO!', 'error' );
            } else if(data=='ERROR_MontoTotal'){
                Swal.fire('', ' EL PEDIDO NO CUMPLE CON LA CONDICION DEL MONTO TOTAL!', 'error' );
            } else if(data=='ERROR_MontoRegion'){
                Swal.fire('', ' EL PEDIDO NO CUMPLE CON LA CONDICION DEL MONTO DE REGION!', 'error' );
            }else if( data.includes('ERROR_StockProductos') ){
                Swal.fire('', 'LOS SIGUIENTES PRODUCTOS NO SE PUEDEN PROCESAR POR STOCK INSUFICIENTE <br><br><strong>'+data.substring(20,data.length)+'</strong>', 'error' );    
            }else if(data=='OK'){
                Swal.fire({ 
                    title: '',
                    text: "PEDIDO PROCESADO CORRECTAMENTE!",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'OK!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                        $('#CodigoDescuento').val('');
                        if(Url=='Web'){
                            window.location.href = "/";
                        }else{
                            location.reload();
                        }
                        
                    }
                });
            }
        },error:function(XMLHttpRequest,textStatus,errorThrown) {
            Swal.fire('', 'ERROR AL ACTUALIZAR EL COMENTARIO!', 'error' );
        }
    });
}

function UpdateComentario(){
    $.ajax({
        url: 'eco_UpdateComentario',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , Comentario: $('#Comentario').val()
        },
        success:function(data) {
            if(data=='ERROR_SinPedido'){
                Swal.fire('', ' NO TIENE UN PEDIDO EN PROCESO!', 'error' );
            }
        },error:function(XMLHttpRequest,textStatus,errorThrown) {
            Swal.fire('', 'ERROR AL ACTUALIZAR EL COMENTARIO!', 'error' );
        }
    });
}

function ValidarCodigoDescuento(){
    $.ajax({
        url: 'eco_ValidarCodigoDescuento',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , codigo: $('#CodigoDescuento').val()
        },
        success:function(data) {
            if(data=='ERROR_Sincodigo'){
                Swal.fire({ 
                    title: '',
                    text: "EL CODIGO INGRESADO NO ES VALIDO!",
                    icon: 'error',
                    showCancelButton: false,
                    confirmButtonText: 'OK!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                        $('#CodigoDescuento').val('');
                        CargarCarrito();
                    }
                });
            }else if(data=='ERROR_SinPedido'){
                Swal.fire('', 'NO TIENE UN PEDIDO EN PROCESO!', 'error' );
                $('#CodigoDescuento').val('');
            }else if(data=='ERROR_CodigoUsado'){
                Swal.fire('', 'EL CODIGO YA FUE USADO!', 'error' );
                $('#CodigoDescuento').val('');
            }else if(data=='ERROR_CodigoActual'){
            }else{
                CargarCarrito();
            }

            
        },error:function(XMLHttpRequest,textStatus,errorThrown) {
            Swal.fire('', 'ERROR AL VALIDAR EL CODIGO DE DESCUENTO!', 'error' );
        }
    });
}

function ActualizarDireccion(){
    
    $.ajax({
        url: 'eco_UpdateDireccionDespacho',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , id:$('#DireccionDespacho').val()
        },
        success:function(data) {
            if(data=='ERROR_SinPedido'){
                Swal.fire('', 'NO EXISTE UN PEDIDO TEMPORAL!', 'error' );
            }else if(data.length>0){
                $('#ComunaDespacho').val(data[0]['Comuna']);
                $('#RegionDespacho').val(data[0]['Region']);
            }else{
                $('#ComunaDespacho').val('');
                $('#RegionDespacho').val('');
            }
        },error:function(XMLHttpRequest,textStatus,errorThrown) {
            Swal.fire('', 'ERROR AL ACTUALIZAR LA DIRECCION!', 'error' );
        }
    });
}

function MostrarAlertaOpciones()
{
    if ($('#OpcionDespacho').val() == "1")
    {
        Swal.fire('', 'LUNES a VIERNES Región Metropolitana, radio urbano, los despachos se realizarán de Lunes a Viernes en un plazo de 48 hrs hábiles.', 'warning' );
    }
    else if ($('#OpcionDespacho').val() == "2")
    {
        Swal.fire('', 'Solo MARTES y JUEVES, cualquier pedido realizado durante la semana previa y/o entre los días asignados a reparto hasta las 18:30 PM del día anterior al despacho, serán entregado entre las 09:00 AM hasta las 20:00 PM. Si requiere despacho en día distinto favor contactar al 228769909.', 'warning' );
    }    
    else if ($('#OpcionDespacho').val() == "3")
    {
        Swal.fire('', 'Solo MIERCOLES, todo pedido realizado durante la semana previa hasta las 09:45 AM, del día de despacho será entregado hasta las 20:00 PM. Si requiere despacho en día distinto favor contactar al 228769909.', 'warning' );
    }   
    else if ($('#OpcionDespacho').val() == "4")
    {
        Swal.fire('', 'Solo LUNES, todo pedido realizado durante la semana anterior hasta las 18:30 PM, del día viernes previo al despacho será entregado entre las 09:00 AM hasta las 20:00 PM. Si requiere despacho en día distinto favor contactar al 228769909.', 'warning' );
    }  
    else if ($('#OpcionDespacho').val() == "5")
    {
        Swal.fire('', 'LUNES a VIERNES_Provincias, todo pedido con hora de recepción hasta las 15:00 PM, se realizara despacho el mismo día, y desde las 15:01 PM el despacho se efectuara el día hábil siguiente, en caso de incluir PRODUCTOS REFRIGERADOS el despacho solo se realiza entre LUNES a JUEVES.', 'warning' );
    }  
    else if ($('#OpcionDespacho').val() == "6")
    {
        Swal.fire('', 'LUNES a VIERNES_Provincias, todo pedido con hora de recepción hasta las 15:00 PM, se realizara despacho el mismo día, y desde las 15:01 PM el despacho se efectuara el día hábil siguiente, en caso de incluir PRODUCTOS REFRIGERADOS el despacho solo se realiza entre LUNES a JUEVES.', 'warning' );
    }  
    else if ($('#OpcionDespacho').val() == "7")
    {
        Swal.fire('', 'LUNES a VIERNES_Provincias, todo pedido con hora de recepción hasta las 13:30 PM, se realizara despacho el mismo día, y desde las 13:31 PM el despacho se efectuara el día hábil siguiente, en caso de incluir PRODUCTOS REFRIGERADOS el despacho solo se realiza entre LUNES a JUEVES.', 'warning' );
    }  
    else if ($('#OpcionDespacho').val() == "8")
    {
        Swal.fire('', 'LUNES a VIERNES_Provincias, todo pedido con hora de recepción hasta las 13:30 PM, se realizara despacho el mismo día, y desde las 13:31 PM el despacho se efectuara el día hábil siguiente, en caso de incluir PRODUCTOS REFRIGERADOS el despacho solo se realiza entre LUNES a JUEVES.', 'warning' );
    }  

    $.ajax({
        url: 'eco_UpdateOpcionDespacho',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , id:$('#OpcionDespacho').val()
        },
        success:function(data) {
            if(data=='ERROR_SinPedido'){
                Swal.fire('', 'NO EXISTE UN PEDIDO TEMPORAL!', 'error' );
            }
        },error:function(XMLHttpRequest,textStatus,errorThrown) {
            Swal.fire('', 'ERROR AL ACTUALIZAR LA OPCION DE DESPACHO!', 'error' );
        }
    });
}

function QuitarLinea(id, Url){
    $('#eco_productos').html(`<div id="eco_productos" class="row d-flex justify-content-center bg-white" style="min-width:100%">
        <div class=" contenedorBoxLoading col-12 text-center p-5">
            <div class="BoxLoading">
                <div class="containerBoxLoading">
                    <span class="circleBoxLoading"></span>
                    <span class="circleBoxLoading"></span>
                    <span class="circleBoxLoading"></span>
                    <span class="circleBoxLoading"></span>
                </div>
            </div>
        </div>
    </div>`);
    $.ajax({
        url: 'eco_addQuitarLinea',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , id:id
        },
        success:function(data) {
            if(data=='error'){
                Swal.fire('', 'ERROR AL ELIMINAR EL PRODUCTO!', 'error' );
            }else{
                if(Url=='Feria'){
                    CargarCarritoFeria();
                }else{
                    CargarCarrito();
                }
            }
        },error:function(XMLHttpRequest,textStatus,errorThrown) {
            Swal.fire('', 'ERROR AL ELIMINAR EL PRODUCTO!', 'error' );
        }
    });
}

function ModificarUno(id, cant, Url){
    $('#eco_productos').html(`<div id="eco_productos" class="row d-flex justify-content-center bg-white" style="min-width:100%">
        <div class=" contenedorBoxLoading col-12 text-center p-5">
            <div class="BoxLoading">
                <div class="containerBoxLoading">
                    <span class="circleBoxLoading"></span>
                    <span class="circleBoxLoading"></span>
                    <span class="circleBoxLoading"></span>
                    <span class="circleBoxLoading"></span>
                </div>
            </div>
        </div>
    </div>`);
    $.ajax({
        url: 'eco_ModificarUno',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , id:id
            , cant:cant
        },
        success:function(data) {
            if(data=='error'){
                Swal.fire('', 'ERROR AL ACTUALIZAR EL PRODUCTO!', 'error' );
            }else{
                if(Url=='Feria'){
                    CargarCarritoFeria();
                }else{
                    CargarCarrito();
                }
            }
        },error:function(XMLHttpRequest,textStatus,errorThrown) {
            Swal.fire('', 'ERROR AL ACTUALIZAR EL PRODUCTO!', 'error' );
        }
    });
}

function GetDetalleBolsa(){
    $('#eco_productos').html(`<div id="eco_productos" class="row d-flex justify-content-center bg-white" style="min-width:100%">
        <div class=" contenedorBoxLoading col-12 text-center p-5">
            <div class="BoxLoading">
                <div class="containerBoxLoading">
                    <span class="circleBoxLoading"></span>
                    <span class="circleBoxLoading"></span>
                    <span class="circleBoxLoading"></span>
                    <span class="circleBoxLoading"></span>
                </div>
            </div>
        </div>
    </div>`);
    $.ajax({
        url: 'eco_getDetalleBolsa',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
        },
        success:function(data) {
            if(data=='error'){
                $('#eco_productos').html(ProductosNoEncontrados());
            }else if(data!='ERROR'){
                $('#eco_productos').html(data);
            }else{
                $('#eco_productos').html(ProductosNoEncontrados());
            }
        },error:function(XMLHttpRequest,textStatus,errorThrown) {
            $('#eco_productos').html(ProductosNoEncontrados());
        }
    });
}

function AgregarProducto(Codigo, Tipo){
    if( !$('#txtCant'+Tipo+''+Codigo).val() || $('#txtCant'+Tipo+''+Codigo).val()<=0){
        if(Tipo==2){
            $('#EstadoAgregar').html('<div class="alert alert-danger" role="alert">DEBE INGRESAR UNA CANTIDAD</div>');
        }else{
            Swal.fire('', 'DEBE INGRESAR UNA CANTIDAD!', 'error' );
        }
    }else{
        $.ajax({
            url: 'eco_addProducto',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                _token : $("#_token").val()
                , codigo:Codigo
                , cantidad:$('#txtCant'+Tipo+''+Codigo).val()
            },
            success:function(data) {
                
                if( data=='ERROR_ClienteActivo' ){ 
                    if(Tipo==2){ $('#EstadoAgregar').html('<div class="alert alert-danger" role="alert">NO SE DETECTO UN CLIENTE ACTIVO</div>'); }
                    else{ Swal.fire('', 'NO SE DETECTO UN CLIENTE ACTIVO!', 'error' ); }
                } else if( data=='ERROR_InfoCliente' ){ 
                    if(Tipo==2){ $('#EstadoAgregar').html('<div class="alert alert-danger" role="alert">NO SE DETECTO INFORMACIÓN DE CLIENTE</div>'); }
                    else{ Swal.fire('', 'NO SE DETECTO INFORMACIÓN DE CLIENTE!', 'error' ); }
                } else if( data=='ERROR_InfoProducto' ){ 
                    if(Tipo==2){ $('#EstadoAgregar').html('<div class="alert alert-danger" role="alert">NO ENCONTRO INFORMACIÓN DEL PRODUCTO</div>'); }
                    else{ Swal.fire('', 'NO SE ENCONTRO INFORMACIÓN DEL PRODUCTO!', 'error' ); }
                } else if( data=='ERROR_Stock' ){ 
                    if(Tipo==2){ $('#EstadoAgregar').html('<div class="alert alert-danger" role="alert">NO TENEMOS STOCK SUFICIENTE</div>'); }
                    else{ Swal.fire('', 'NO TENEMOS STOCK SUFICIENTE!', 'error' ); }
                } else if( data=='ERROR_Pedido' ){ 
                    if(Tipo==2){ $('#EstadoAgregar').html('<div class="alert alert-danger" role="alert">NO SE DETECTO UN PEDIDO TEMPORAL</div>'); }
                    else{ Swal.fire('', 'NO SE DETECTO UN PEDIDO TEMPORAL!', 'error' ); }
                } else if( data=='ERROR_GuardarProducto' ){ 
                    if(Tipo==2){ $('#EstadoAgregar').html('<div class="alert alert-danger" role="alert">ERROR AL GUARDAR EL PRODUCTO</div>'); }
                    else{ Swal.fire('', 'ERROR AL GUARDAR EL PRODUCTO!', 'error' ); }
                } else if( data=='ERROR_GuardarProductoRegalo' ){ 
                    if(Tipo==2){ $('#EstadoAgregar').html('<div class="alert alert-danger" role="alert">ERROR AL GUARDAR EL PRODUCTO REGALO</div>'); }
                    else{ Swal.fire('', 'ERROR AL GUARDAR EL PRODUCTO REGALO!', 'error' ); }
                } else {
                    SuccessAutoClose();
                    GetSubtotalBolsa();
                    $('#CantAgregada1'+Codigo).html(data[0]['cantidad']);
                    $('#txtCant'+Tipo+''+Codigo).val('');
                    $('#ModalSingleProduct').modal('hide');
                }
            },error:function(XMLHttpRequest,textStatus,errorThrown) {
                $('#ModalSingleProduct').modal('hide');
                Swal.fire('', 'NO SE LOGRO AGREGAR EL PRODUCTO, FAVOR CONTACTAR A SOPORTE!', 'error' );
            }
        });
        
    }
}

function GetSubtotalBolsa(){
    $.ajax({
        url: 'eco_getSubTotalBolsa',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
        },
        success:function(data) {
            CargarPreContenidoCarro(data);
        },error:function(XMLHttpRequest,textStatus,errorThrown) {
            $('#DivBolsaCantProductos').html(0);
            $('#DivBolsaTotal').html('$ 0');
        }
    });
}

function OcultarModalProducto(Codigo){
    $('#ModalSingleProductContent').html('');
    $('#ModalSingleProduct').modal('hide');
}

function CargarModalProducto(Codigo){
    $.ajax({
        url: 'eco_getProductosDetalle',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , codigo:Codigo
        },
        success:function(data) {
            if(data=='error'){
                $('#ModalSingleProductContent').html('<div class="alert alert-danger" role="alert"><h6 class="text-danger">NO SE LOGRÓ CAPTURAR EL DETALLE DEL PRODUCTO</h6></div>');
            }else if(data!='ERROR'){
                $('#ModalSingleProductContent').html(data);
            }else{
                $('#ModalSingleProductContent').html('<div class="alert alert-danger" role="alert"><h6 class="text-danger">NO SE LOGRÓ CAPTURAR EL DETALLE DEL PRODUCTO</h6></div>');
            }
        },error:function(XMLHttpRequest,textStatus,errorThrown) {
            $('#ModalSingleProductContent').html('<div class="alert alert-danger" role="alert"><h6 class="text-danger">NO SE LOGRÓ CAPTURAR EL DETALLE DEL PRODUCTO</h6></div>');
        }
    });
    $('#ModalSingleProduct').modal('show');
}

function LoadGrillaProductos(){
    $.ajax({
        url: '/eco_getProductosActivos',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , Codigo:$("#Codigo").val()
            , Order:$("#Order").val()
            , OrderCant:$("#OrderCant").val()
            , Type:$("#Type").val()
            , Texto:$("#Texto").val()
        },
        success:function(data) {
            if(data=='error'){
                $('#eco_productos').html(ProductosNoEncontrados());
            }else{
                $('#eco_productos').html(data);
            }
        },error:function(XMLHttpRequest,textStatus,errorThrown) {
            $('#eco_productos').html(ProductosNoEncontrados());
        }
    });
}

function CargarCarrito()
{
    var form = document.createElement("form");
    form.method = "POST";
    form.action = '/carrito';
    form.target = '_parent';

    var element1 = document.createElement("input");
    element1.value=$("#_token").val();
    element1.name="_token";
    element1.id="_token";
    element1.type="hidden";
    form.appendChild(element1);

    var element2 = document.createElement("input");
    element2.value='Web';
    element2.name="tipo";
    element2.id="tipo";
    element2.type="hidden";
    form.appendChild(element2);

    document.body.appendChild(form);
    form.submit();
}

function CargarCarritoFeria()
{
    var form = document.createElement("form");
    form.method = "POST";
    form.action = '/carrito';
    form.target = '_parent';

    var element1 = document.createElement("input");
    element1.value=$("#_token").val();
    element1.id="_token";
    element1.name="_token";
    element1.type="hidden";
    form.appendChild(element1);

    var element2 = document.createElement("input");
    element2.value='Feria';
    element2.id="tipo";
    element2.name="tipo";
    element2.type="hidden";
    form.appendChild(element2);

    document.body.appendChild(form);
    form.submit();
}

function CargarProductosDesc()
{
    var tipo='Desc';

    if( !$('#OrdenoMetro').val() ) { var Order=1; } else { var Order = $('#OrdenoMetro').val(); }
    if( !$('#OrderCant').val() ) { var OrderCant=12; } else { var OrderCant = $('#OrderCant').val(); }
    if( !$('#BuscSelecet').val() ) { var codigo='ALL'; } else { var codigo = $('#BuscSelecet').val(); }
    if( !$('#BuscText').val() ) { var texto=''; } else { var texto = $('#BuscText').val(); }

    var form = document.createElement("form");
    form.method = "POST";
    form.action = '/category';
    form.target = '_parent';

    var element1 = document.createElement("input");
    element1.value=$("#_token").val();
    element1.name="_token";
    element1.type="hidden";
    form.appendChild(element1);

    var element2 = document.createElement("input");
    element2.value=Order;
    element2.name='Order';
    element2.type='hidden';
    form.appendChild(element2);

    var element3 = document.createElement("input");
    element3.value=tipo;
    element3.name='Type';
    element3.type='hidden';
    form.appendChild(element3);

    var element4 = document.createElement("input");
    element4.value=codigo;
    element4.name='id';
    element4.type='hidden';
    form.appendChild(element4);

    var element5= document.createElement("input");
    element5.value=texto;
    element5.name='texto';
    element5.type='hidden';
    form.appendChild(element5);

    var element6= document.createElement("input");
    element6.value=OrderCant;
    element6.name='OrderCant';
    element6.type='hidden';
    form.appendChild(element6);

    document.body.appendChild(form);
    form.submit();
}

function CargarProductos(tipo, codigo)
{
    if(tipo=='DESC' && !$('#inp_prod_desc').val() ) { codigo = 'S1nD3sCr1pC10n'; } 
    else if(tipo=='DESC' ) { codigo = $('#inp_prod_desc').val(); }
    
    if( !$('#OrdenoMetro').val() ) { var Order=1; } else { var Order = $('#OrdenoMetro').val(); }
    if( !$('#OrdenoMetroCant').val() ) { var OrderCant=12; } else { var OrderCant = $('#OrdenoMetroCant').val(); }

    if(tipo=='Feria'){
        var form = document.createElement("form");
        form.method = "GET";
        form.action = '/categoryFeria';
        form.target = '_parent';
    }else{
        var form = document.createElement("form");
        form.method = "POST";
        form.action = '/category';
        form.target = '_parent';
    }

    var element1 = document.createElement("input");
    element1.value=$("#_token").val();
    element1.name="_token";
    element1.type="hidden";
    form.appendChild(element1);

    var element2 = document.createElement("input");
    element2.value=Order;
    element2.name='Order';
    element2.type='hidden';
    form.appendChild(element2);

    var element3 = document.createElement("input");
    element3.value=tipo;
    element3.name='Type';
    element3.type='hidden';
    form.appendChild(element3);

    var element4 = document.createElement("input");
    element4.value=codigo;
    element4.name='id';
    element4.type='hidden';
    form.appendChild(element4);

    var element5= document.createElement("input");
    element5.value='';
    element5.name='texto';
    element5.type='hidden';
    form.appendChild(element5);

    var element6= document.createElement("input");
    element6.value=OrderCant;
    element6.name='OrderCant';
    element6.type='hidden';
    form.appendChild(element6);

    document.body.appendChild(form);
    form.submit();
}

function CargarPaginator(id){
    $('.page-id-ordenometro').each(function(index, element){
        element.style.display = 'none';
    });

    $('.page-item-btn').each(function(index, element){
        element.classList.remove("active");
    });


    document.getElementById("page-id-"+id).style.display = 'block';
    document.getElementById("page-item-btn-"+id+"_1").classList.add('active');
    document.getElementById("page-item-btn-"+id+"_2").classList.add('active');

    $(window).scrollTop(0);
}

function SetClienteActivo(id){
    Swal.fire({
    title: '',
    text: 'ACTIVAR CLIENTE',
    showDenyButton: false,
    showCancelButton: true,
    confirmButtonText: `SI`,
    confirmButtonColor: `#52BE80`,
    denyButtonText: `NO`,
    cancelButtonText: `NO`,
    width: '50%'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'eco_SetClienteActivo',
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    _token : $("#_token").val()
                    , cliente:$("#ClienteActivo"+id).val()
                },
                success:function(data) {
                    if(data=='error'){
                        location.reload();
                    }else{
                        location.reload();
                    }
                },error:function(XMLHttpRequest,textStatus,errorThrown) {
                    $('#eco_productos').html(ProductosNoEncontrados());
                }
            });
        }
    })
}

$(document).ready(function() {

    GetSubtotalBolsa();

    $("#inp_prod_desc").on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            CargarProductos('DESC', '');
        }
    });

    $('#ModalSingleProduct').modal({backdrop: 'static', keyboard: false})  

    if (
        typeof $('#Codigo').val() !== 'undefined'
        && typeof $('#Order').val() !== 'undefined'
        && typeof $('#Type').val() !== 'undefined'
        && typeof $('#OrderCant').val() !== 'undefined'
        && $('#Codigo').val()!=''
        && $('#Order').val()!=''
        && $('#Type').val()!=''
        && $('#OrderCant').val()!=''
    ) {
        LoadGrillaProductos();
    }

    

});



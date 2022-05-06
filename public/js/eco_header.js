
function SetImagenProducto(Imagen)
{
    $('#ImgDetalleProducto').html('<img src="'+Imagen+'">');
}

function DefinirPais(Pais)
{
    $('#SearchPais').val(Pais);
    if (
        typeof $('#Codigo').val() !== 'undefined'
        && typeof $('#Order').val() !== 'undefined'
        && typeof $('#Type').val() !== 'undefined'
        && typeof $('#OrderCant').val() !== 'undefined'
        && $('#Codigo').val()!=''
        && $('#Order').val()!=''
        && $('#Type').val()!=''
        && $('#OrderCant').val()!=''
    )
    {
        LoadGrillaProductos();
    }
}
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

function RealizarPago(){

    Swal.fire({ 
        title: '',
        text: "DESEA SOLICITAR LA COTIZACIÓN!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'SI!',
        cancelButtonText: 'NO',
      }).then((result) => {
        if (result.isConfirmed) {
            $('#DivContenidoCotizacion').html(`
            <div style="width: 100% !important; text-align:center !important;">
            <h2 class="title-Section2"> Procesando <span class="textBrandAcent">cotización</span> </h2>
            <img src="img/EnviandoEmail.gif" style="width: 500px !important;">
            </div>
            `);
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
                    }else if(data=='ERROR_SinProductos'){
                        Swal.fire('', ' EL PEDIDO NO TIENE PRODUCTOS!', 'error' );
                    }else if(data=='OK'){
                        Swal.fire({ 
                            title: '',
                            text: "SOLICITUD ENVIADA CORRECTAMENTE!",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'OK!'
                          }).then((result) => {
                            if (result.isConfirmed) {
                                
                                window.location.href = "/";
                                
                            }
                        });
                    }
                },error:function(XMLHttpRequest,textStatus,errorThrown) {
                    Swal.fire('', 'ERROR AL ACTUALIZAR EL COMENTARIO!', 'error' );
                }
            });
            
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

    Swal.fire({
    title: '',
    text: 'CONFIRMA QUITAR EL PRODUCTO',
    showDenyButton: false,
    showCancelButton: true,
    confirmButtonText: `SI`,
    confirmButtonColor: `#52BE80`,
    denyButtonText: `NO`,
    cancelButtonText: `NO`,
    }).then((result) => {
        if (result.isConfirmed) {
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
        } else if (result.isDenied) {

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

function AgregarProducto(Codigo){
    
    $.ajax({
        url: 'eco_addProducto',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , codigo:Codigo
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
            } else if( data=='ERROR_Pedido' ){ 
                if(Tipo==2){ $('#EstadoAgregar').html('<div class="alert alert-danger" role="alert">NO SE DETECTO UN PEDIDO TEMPORAL</div>'); }
                else{ Swal.fire('', 'NO SE DETECTO UN PEDIDO TEMPORAL!', 'error' ); }
            } else if( data=='ERROR_GuardarProducto' ){ 
                if(Tipo==2){ $('#EstadoAgregar').html('<div class="alert alert-danger" role="alert">ERROR AL GUARDAR EL PRODUCTO</div>'); }
                else{ Swal.fire('', 'ERROR AL GUARDAR EL PRODUCTO!', 'error' ); }
            } else {
                SuccessAutoClose();
                GetSubtotalBolsa();
                $('#ModalSingleProduct').modal('hide');
            }
        },error:function(XMLHttpRequest,textStatus,errorThrown) {
            $('#ModalSingleProduct').modal('hide');
            Swal.fire('', 'NO SE LOGRO AGREGAR EL PRODUCTO, FAVOR CONTACTAR A SOPORTE!', 'error' );
        }
    });
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

function LoadFiltrarGrillaProductos(){

    var formInfo = new FormData($("#FormFiltrarGrillaProductos")[0]);
    formInfo.set('Pais', $("#SearchPais").val());

    $.ajax({
        url: 'eco_getProductosActivos',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: formInfo,
        contentType: false,
        processData: false,
        success:function(data)
        {
            if(data=='error'){
                $('#eco_productos').html(ProductosNoEncontrados());
            }else{
                $('#eco_productos').html(data);
            }
        }
    });
}


function LoadGrillaProductos(){

    var formInfo = new FormData($("#FormLoadGrillaProductos")[0]);
    formInfo.set('Pais', $("#SearchPais").val());
    $.ajax({
        url: 'eco_getProductosActivos',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: formInfo,
        contentType: false,
        processData: false,
        success:function(data)
        {
            if(data=='error'){
                $('#eco_productos').html(ProductosNoEncontrados());
            }else{
                $('#eco_productos').html(data);
            }
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

    var element7= document.createElement("input");
    element7.value=$('#SearchPais').val();
    element7.name='Pais';
    element7.type='hidden';
    form.appendChild(element7);

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

    var element6= document.createElement("input");
    element6.value=$('#SearchPais').val();
    element6.name='Pais';
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










function EnviarRegistro(Id)
{

    var ErrorEmail = 0;
    if(validateEmail($('#RegEmail').val())==false)
    {
        ErrorEmail = 1;
    }

    if(ErrorEmail==1)
    {
        Swal.fire('', 'El email ingresado no es válido!', 'error' );
    }
    else if( $('#RegContrasenia1').val()!=$('#RegContrasenia2').val() )
    {
        Swal.fire('', 'Las contraseñas no coinciden!', 'error' );
    }
    else if(ValidarRequeridos('ContCliente')==0)
    {
        document.getElementById('DivRegistroProcesando').style.display = 'block';
        document.getElementById('DivRegistroBotones').style.display = 'none';
        document.getElementById('DivFormRegistro').style.display = 'none';

        $('#DivRegistroProcesando').html(`
        <div style="width: 100% !important; text-align:center !important;">
        <h2 class="title-Section2"> Procesando <span class="textBrandAcent">registro</span> </h2>
        <img src="img/EnviandoEmail.gif" style="width: 500px !important;">
        </div>
        `);
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
                        Swal.fire('Cuenta registrada correctamente!', 'Gracias por llenar nuestro formulario de registro, tu ficha ha sido asignada a un ejecutivo, y en breve te contactaremos, indicándote que la cuenta de usuario fue activada, para que puedas usar nuestro portal!', 'success' );
                        document.getElementById('DivRegistroProcesando').style.display = 'none';
                        document.getElementById('DivFormRegistro').style.display = 'block';
                    }
                    else
                    {
                        document.getElementById('DivFormRegistro').style.display = 'block';
                        document.getElementById('DivRegistroProcesando').style.display = 'none';
                        Swal.fire('', data+'!', 'error' );
                    }
                }
            });
    }
}

function EnviarContacto()
{
    if(validateEmail($('#ContEmail').val())==false)
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
    else if(ValidarRequeridos('ContCliente')==0)
    {
        window.scrollTo(0,0);
        $.ajax({
                url: '/eco_EnviarCorreoContacto',
                type: 'POST',
                //headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data:{
                    plataforma:'web'
                    , ContNombre:$('#ContNombre').val()
                    , ContPais:$('#ContPais').val()
                    , ContEmail:$('#ContEmail').val()
                    , ContTelefono:$('#ContTelefono').val()
                    , ContAsunto:$('#ContAsunto').val()
                    , ContIndustria:$('#ContIndustria').val()
                    , ContMensaje:$('#ContMensaje').val()
                    , _token : $("#_token").val()
                },
                success:function(data)
                {
                    if(data=="OK")
                    {
                        Swal.fire('', 'Su mensaje fue enviado correctamente!', 'success' );
                    }
                    else
                    {
                        Swal.fire('', 'No se pudo enviar el correo, favor intentar mas tarde!', 'error' );
                    }
                }
            });
    }
}

function ValidarRequeridos(clase)
{
    var requeridos = 0;
    $('.'+clase).each(function(index, element){
        if( element.value.length==0 ) {
            element.classList.add("is-invalid");
            requeridos++;
        }
        else {
            element.classList.remove("is-invalid");
        }
    });
    if(requeridos>0)
    {
        Swal.fire('', 'Debe ingresar toda la informacion!', 'error' );
    }
    return requeridos;
}

function CargarRegistro(Tipo)
{
    $('#IdRegistroName').html(Tipo);
    document.getElementById('DivRegistroBotones').style.display = 'none';
    document.getElementById('DivFormRegistro').style.display = 'none';

    if(Tipo=='Botones')
    {
        document.getElementById('DivRegistroBotones').style.display = 'block';
    }
    else
    {
        $('#RegTipo').val(Tipo);
        document.getElementById('DivFormRegistro').style.display = 'block';
    }
}

   

$(document).ready(function() {

    if(typeof  $('#BuscadorCategorias').val() !== 'undefined' )
    {
        var input = document.getElementById("BuscadorCategorias");
        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                CargarProductos('Buscador', $('#BuscadorCategorias').val());
            }
        });
    }

    if (
        typeof $('#Codigo').val() !== 'undefined'
        && typeof $('#Order').val() !== 'undefined'
        && typeof $('#Type').val() !== 'undefined'
        && typeof $('#OrderCant').val() !== 'undefined'
        && $('#Codigo').val()!=''
        && $('#Order').val()!=''
        && $('#Type').val()!=''
        && $('#OrderCant').val()!=''
    )
    {
        LoadGrillaProductos();
    }

    $('#slider').nivoSlider({
        effect: 'random',
        slices: 15,
        boxCols: 8,
        boxRows: 4,
        animSpeed: 500,
        pauseTime: 3000,
        startSlide: 0,
        directionNav: true,
        controlNav: true,
        controlNavThumbs: true,
        pauseOnHover: true,
        manualAdvance: true,
        prevText: '<',
        nextText: '>',
        randomStart: false,
        beforeChange: function(){},
        afterChange: function(){},
        slideshowEnd: function(){},
        lastSlide: function(){},
        afterLoad: function(){}
        });


 const select = document.querySelector('#select');
   const opciones = document.querySelector('#opciones');
   const contenidoSelect = document.querySelector('#select .contenido-select');
   const hiddenInput = document.querySelector('#inputSelect');
   const navButton = document.querySelector('#navbar-toggler');
   
   document.querySelectorAll('#opciones > .opcion').forEach((opcion) => {
     opcion.addEventListener('click', (e) => {
       e.preventDefault();
       contenidoSelect.innerHTML = e.currentTarget.innerHTML;
       select.classList.toggle('active');
       opciones.classList.toggle('active');
       navButton.classList.toggle('active');
       hiddenInput.value = e.currentTarget.querySelector('.titulo').innerText;
     });
   });
   
   select.addEventListener('click', () => {
     select.classList.toggle('active');
     opciones.classList.toggle('active');
     navButton.classList.toggle('active');
   });

});
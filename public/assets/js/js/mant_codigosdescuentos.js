function EliminarCliente(id)
{
    Swal.fire({
    title: 'ELIMINAR?',
    text: 'LA INFORMACIÓN NO PODRA SER RECUPERADA',
    showDenyButton: false,
    showCancelButton: true,
    confirmButtonText: `SI`,
    confirmButtonColor: `#52BE80`,
    denyButtonText: `NO`,
    cancelButtonText: `NO`,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'mant_codigosdescuentosEliminarCliente',
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    _token : $("#_token").val()
                    , Id : id
                },
                success:function(data)
                {
                    if(data=='OK')
                    {
                        CargarDetalle();
                        BuscarClientes();
                        QuitarFondoToast();
                        $('#ToastBody').html('CLIENTE ELIMINADO CORRECTAMENTE')
                        $("#Toaster").addClass("bg-success").addClass("text-white");
                        $('#Toaster').toast("show");
                    }
                    else{
                        QuitarFondoToast();
                        $('#ToastBody').html(data)
                        $("#Toaster").addClass("bg-danger").addClass("text-white");
                        $('#Toaster').toast("show");
                    }
                },error:function(XMLHttpRequest,textStatus,errorThrown){
                    ToastSessionExpirada();
                }
            });
        } else if (result.isDenied) {

        }
    })
}

function AgregarCliente(codigo)
{
    if( $('#id').val()=='0'){
        QuitarFondoToast();
        $('#ToastBody').html("NO SE DETECTO UN CODIGO DE PROMOCION ASOCIADO");
        $("#Toaster").addClass("bg-danger").addClass("text-white");
        $('#Toaster').toast("show");
    }else{
        $.ajax({
            url: 'mant_codigosdescuentosAgregarCliente',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                _token : $("#_token").val()
                , codigo : codigo
                , Id : $('#id').val()
            },
            success:function(data)
            {
                if(data=='EL CLIENTE YA ESTA ASOCIADO'){
                    QuitarFondoToast();
                    $('#ToastBody').html(data);
                    $("#Toaster").addClass("bg-danger").addClass("text-white");
                    $('#Toaster').toast("show");
                }
                CargarDetalle();
                BuscarClientes();
            },error:function(XMLHttpRequest,textStatus,errorThrown){
                ToastSessionExpirada();
            }
        });
    }
}

function LimpiarClientes(){
    $('#DivListadoClientesEncontrados').html('');            
    $('#codigo').val('');
}

function BuscarClientes()
{
    if($('#codigo').val().length>0){
    $('#DivListadoClientesEncontrados').html('');            
    $.ajax({
        url: 'mant_codigosdescuentosBuscarClientes',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , codigo : $('#codigo').val()
            , Id : $('#id').val()
        },
        success:function(data)
        {
            var Salida = `<table id="Tabla_BuscarClientes" class="table table-striped table-responive table-bordered" style="font-size:12px">
            <thead><tr><th>ACCIONES</th><th>CLIENTE</th><th>NOMBRE</th></tr></thead><tbody>`;

            for(var i=0; i<data.length; i++){
                Salida += `
                <tr class="table-hover">
                    <td>
                        <span class="pointer badge badge-pill bg-success" onclick="AgregarCliente('`+data[i]['codigo']+`')">AGREGAR</span>
                    </td>
                    <td>`+data[i]['codigo']+`</td>
                    <td>`+data[i]['nombre']+`</td>
                </tr>
                `;
            }
            Salida += `       
                </tbody>
            </table>`;
            $('#DivListadoClientesEncontrados').html(Salida);    
            $('#Tabla_BuscarClientes').DataTable();        
        },error:function(XMLHttpRequest,textStatus,errorThrown){
            ToastSessionExpirada();
        }
    });
    }
}


function CargarDetalle()
{
    $('#DivListadoClientesAgregados').html('');            
    $.ajax({
        url: 'mant_codigosdescuentosCargarDetalle',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , Id : $('#id').val()
        },
        success:function(data)
        {
            var Salida = `<table id="Tabla_Productos" class="table table-striped table-responive table-bordered" style="font-size:12px">
            <thead><tr><th>ACCIONES</th><th>USADO</th><th>CLIENTE</th><th>NOMBRE</th></tr></thead><tbody>`;

            for(var i=0; i<data.length; i++){
                Salida += `<tr class="table-hover">`;

                if(data[i]['usado'].trim()=='NO'){
                    Salida +=`<td><span class="pointer badge badge-pill bg-danger" onclick="EliminarCliente(`+data[i]['id']+`)">ELIMINAR</span></td>`;
                }else{
                    Salida +=`<td></td>`;
                }

                Salida +=`
                    <td>`+data[i]['usado']+`</td>
                    <td>`+data[i]['codigo']+`</td>
                    <td>`+data[i]['nombre']+`</td>
                </tr>
                `;
            }
            Salida += `       
                </tbody>
            </table>`;
            $('#DivListadoClientesAgregados').html(Salida);            
        },error:function(XMLHttpRequest,textStatus,errorThrown){
            ToastSessionExpirada();
        }
    });
}

function GuardarCambios()
{
    var Requeridos = ValidarRequeridos('CodDescRequired');

    if(Requeridos<=0){
        var formInfo = new FormData($("#FormGuardar")[0]);
        $.ajax({
            url: 'mant_codigosdescuentosGuardar',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: formInfo,
            contentType: false,
            processData: false,
            success:function(data)
            {
                if(data=='error'){
                    QuitarFondoToast();
                    $('#ToastBody').html("ERROR AL GUARDAR INFORMACION");
                    $("#Toaster").addClass("bg-danger").addClass("text-white");
                    $('#Toaster').toast("show");
                }else if(data=='EL CODIGO YA ESTA EN USO' || data=='FALTA INFORMACION') {
                    QuitarFondoToast();
                    $('#ToastBody').html(data);
                    $("#Toaster").addClass("bg-danger").addClass("text-white");
                    $('#Toaster').toast("show");
                } else {
                    QuitarFondoToast();
                    $('#ToastBody').html("INFORMACION GUARDADA CORRECTAMENTE");
                    $("#Toaster").addClass("bg-success").addClass("text-white");
                    $('#Toaster').toast("show");
                    $('#id').val(data);
                    CargarDetalle();
                }
            }
        });
    }
}

function crearEditar(id)
{
    var form = document.createElement("form");
    form.method = "POST";
    form.action = "mant_codigosdescuentosCrearEditar";
    form.target = '_self';

    var element1 = document.createElement("input");
    element1.value=$("#_token").val();
    element1.name="_token";
    element1.type="hidden";
    form.appendChild(element1);

    var element2 = document.createElement("input");
    element2.value=id;
    element2.name="id";
    element2.type="hidden";
    form.appendChild(element2);

    document.body.appendChild(form);
    form.submit();
}

$(document).ready(function() {

    if($('#id').val()!=0){
        CargarDetalle();
    }

    $('#TablaLista').DataTable(
    );
});

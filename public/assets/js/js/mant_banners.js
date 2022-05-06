function EliminarBanner(id)
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
                url: 'mant_bannersEliminarBanner',
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    _token : $("#_token").val()
                    , id : id
                },
                success:function(data)
                {
                    if(data=='OK')
                    {
                        ToastInformacionEliminada();
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

function EliminarProducto(id)
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
                url: 'mant_bannersEliminarProducto',
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    _token : $("#_token").val()
                    , id : id
                },
                success:function(data)
                {
                    if(data=='OK')
                    {
                        CargarDetalleBanner();
                        QuitarFondoToast();
                        $('#ToastBody').html('PRODUCTO ELIMINADO CORRECTAMENTE')
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

function CargarDetalleBanner()
{
    $.ajax({
        url: 'mant_bannersCargarDetalleBanner',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , Id : $('#id').val()
        },
        success:function(data)
        {
            var Salida = `<table id="Tabla_Productos" class="table table-striped table-responive table-bordered" style="font-size:12px">
            <thead><tr><th>ACCIONES</th><th>CODIGO</th><th>DESCRIPCION</th></tr></thead><tbody>`;

            for(var i=0; i<data.length; i++){
                Salida += `
                <tr class="table-hover">
                    <td>
                        <span class="pointer badge badge-pill bg-danger" onclick="EliminarProducto(`+data[i]['id']+`)">ELIMINAR</span>
                    </td>
                    <td>`+data[i]['CodProd']+`</td>
                    <td>`+data[i]['descripcion']+`</td>
                </tr>
                `;
            }
            Salida += `       
                </tbody>
            </table>`;
            $('#DivListadoProductos').html(Salida);            
        },error:function(XMLHttpRequest,textStatus,errorThrown){
            ToastSessionExpirada();
        }
    });
}

function AgregarProducto()
{
    $.ajax({
        url: 'mant_bannersAgregarProducto',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , CodProd : $('#CodProd').val()
            , Id : $('#id').val()
        },
        success:function(data)
        {
            if(data=="EL PRODUCTO YA ESTA AGREGADO")
            {
                QuitarFondoToast();
                $('#ToastBody').html(data)
                $("#Toaster").addClass("bg-danger").addClass("text-white");
                $('#Toaster').toast("show");
            }else{
                
                CargarDetalleBanner($('#id').val());

                $('#CodProd').val('');                
            }
            
        },error:function(XMLHttpRequest,textStatus,errorThrown){
            ToastSessionExpirada();
        }
    });
}

function GuardarBanner()
{
    var Requeridos = ValidarRequeridos('BannerRequired');

    if(Requeridos<=0){
        var formInfo = new FormData($("#FormGuardar")[0]);
        $.ajax({
            url: 'mant_bannersGuardar',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: formInfo,
            contentType: false,
            processData: false,
            success:function(data)
            {
                if(data=='LA IMAGEN PARA EL BANNER ES OBLIGATORIA'){
                    $('#id').val(0);
                    $('#DivListadoProductos').html('');
                    $('#ToastBody').html(data);
                    $("#Toaster").addClass("bg-danger").addClass("text-white");
                    $('#Toaster').toast("show");
                }else if(data=='LA POSICION YA ESTA UTILIZADA'){
                    $('#id').val(0);
                    $('#DivListadoProductos').html('');
                    $('#ToastBody').html(data);
                    $("#Toaster").addClass("bg-danger").addClass("text-white");
                    $('#Toaster').toast("show");
                }else{
                    $('#id').val(data);
                    QuitarFondoToast();
                    $('#ToastBody').html('INFORMACION GUARDADA CORRECTAMENTE');
                    $("#Toaster").addClass("bg-success").addClass("text-white");
                    $('#Toaster').toast("show");
                    CargarDetalleBanner();
                }
            }
        });
    }
}

function crearEditar(id)
{
    var form = document.createElement("form");
    form.method = "POST";
    form.action = "mant_banners_crearEditar";
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

function cambiarEstado(id, estado)
{
    $.ajax({
        url: 'mant_roles_updateEstado',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , id : id
            , estado : estado
        },
        success:function(data)
        {
            if(data=='OK')
            {
                ToastInformacionActualizada();
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
}

function actualizarEstado(id, estado)
{
    if(estado==true)
    {
        var titulo = 'ACTIVAR?';
        var texto = 'EL ROL ACTIVADO PODRA SER ASIGNADO A LOS USUARIOS!';
    }
    else
    {
        var titulo = 'BLOQUEAR?';
        var texto = 'EL ROL ASOCIADO NO PODRA SER USADO POR LOS USUARIOS!';
    }
    Swal.fire({
    title: titulo,
    text: texto,
    showDenyButton: false,
    showCancelButton: true,
    confirmButtonText: `SI`,
    confirmButtonColor: `#52BE80`,
    denyButtonText: `NO`,
    cancelButtonText: `NO`,
    }).then((result) => {
        if (result.isConfirmed) {
            cambiarEstado(id, estado)
        } else if (result.isDenied) {

        }
    })
}

$(document).ready(function() {
    $('#Tabla_Listado').DataTable(
    );

    if($('#id').val()!=0){
        CargarDetalleBanner();
    }
});
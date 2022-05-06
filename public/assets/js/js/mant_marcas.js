function MarcaGuardar()
{
    var Requeridos = ValidarRequeridos('MarcasRequired');

    if(Requeridos<=0){
        var formInfo = new FormData($("#FormGuardarMarca")[0]);
        $.ajax({
            url: 'mant_marcasGuardar',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: formInfo,
            contentType: false,
            processData: false,
            success:function(data)
            {
                if(data=='EL NOMBRE YA ESTA EN USO'){
                    $('#id').val(0);
                    $('#ToastBody').html(data);
                    $("#Toaster").addClass("bg-danger").addClass("text-white");
                    $('#Toaster').toast("show");
                }
                else if(data=='LA POSICION YA ESTA ASIGNADA'){
                    $('#id').val(0);
                    $('#ToastBody').html(data);
                    $("#Toaster").addClass("bg-danger").addClass("text-white");
                    $('#Toaster').toast("show");
                }
                else
                {
                    ToastInformacionGuardada();
                }
            }
        });
    }
}

function MarcaCrearEditar(id)
{
    var form = document.createElement("form");
    form.method = "POST";
    form.action = "mant_marcasCrearEditar";
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
        url: 'mant_marcasUpdateEstado',
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

function MarcaUpdateEstado(id, estado)
{
    if(estado==true)
    {
        var titulo = 'ACTIVAR?';
        var texto = 'LA MARCA ACTIVADA PODRA SER UTILIZADA EN LOS PRODUCTOS!';
    }
    else
    {
        var titulo = 'BLOQUEAR?';
        var texto = 'LA MARCA BLOQUEADA NO PODRA SER UTILIZADA EN LOS PRODUCTOS!';
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
});
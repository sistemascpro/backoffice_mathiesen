function Paises_GuardarCambios()
{
    var Requeridos = ValidarRequeridos($('#InputNombreRequired').val());

    if(Requeridos<=0){
        var formInfo = new FormData($("#Paises_FormGuardar")[0]);
        $.ajax({
            url: $('#InputNombreRuta').val()+'Guardar',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: formInfo,
            contentType: false,
            processData: false,
            success:function(data)
            {
                if(data!='OK') {
                    $('#ToastBody').html(data);
                    $("#Toaster").addClass("bg-danger").addClass("text-white");
                    $('#Toaster').toast("show");
                } else {
                    ToastInformacionGuardada();
                }
            }
        });
    }
}

function Paises_CrearEditar(id)
{
    var form = document.createElement("form");
    form.method = "POST";
    form.action = $('#InputNombreRuta').val()+"CrearEditar";
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

function Paises_CambiarEstado(id, estado)
{
    $.ajax({
        url: $('#InputNombreRuta').val()+'UpdateEstado',
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

function Paises_UpdateEstado(id, estado)
{
    if(estado==true)
    {
        var titulo = 'ACTIVAR?';
        var texto = 'EL PAIS ACTIVADO PODRA SER UTIIZADO EN LOS PRODUCTOS!';
    }
    else
    {
        var titulo = 'BLOQUEAR?';
        var texto = 'EL PAIS BLOQUEADO NO PODRA SER UTILIZADO EN LOS PRODUCTOS!';
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
            Paises_CambiarEstado(id, estado)
        } else if (result.isDenied) {

        }
    })
}

$(document).ready(function() {
    $('#Tabla_Listado').DataTable();
});
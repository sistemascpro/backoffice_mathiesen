function EliminarNoticia(id)
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
                url: 'mant_noticiasEliminar',
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

function Guardar(Tipo)
{
    $('#Tipo').val(Tipo);

    var Requeridos = ValidarRequeridos(Tipo+'Required');

    if(Requeridos<=0){
        var formInfo = new FormData($("#FormGuardar")[0]);
        $.ajax({
            url: 'mant_noticiasGuardar',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: formInfo,
            contentType: false,
            processData: false,
            success:function(data)
            {
                if(data=='OK')
                {
                    ToastInformacionGuardada();
                }
                else
                {
                    QuitarFondoToast();
                    ToastError(data);
                }
            }
        });
    }
}

function crearEditar(id)
{
    var form = document.createElement("form");
    form.method = "POST";
    form.action = "mant_noticias_crearEditar";
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

    $('#Noticias_List').DataTable(
    );

});

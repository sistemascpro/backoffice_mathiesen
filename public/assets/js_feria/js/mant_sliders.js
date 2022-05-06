function EliminarSlider(id)
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
                url: 'mant_slidersEliminar',
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

function GuardarSlider()
{
    var formInfo = new FormData($("#FormGuardar")[0]);
    $.ajax({
        url: 'mant_slidersGuardar',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: formInfo,
        contentType: false,
        processData: false,
        success:function(data)
        {
            if(data!='OK'){
                $('#ToastBody').html(data);
                $("#Toaster").addClass("bg-danger").addClass("text-white");
                $('#Toaster').toast("show");
            }else{
                ToastInformacionGuardada();
            }
        }
    });
}

$(document).ready(function() {
    $('#Tabla_Listado').DataTable();
});
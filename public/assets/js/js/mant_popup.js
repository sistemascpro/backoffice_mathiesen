function Agregar()
{
    var formInfo = new FormData($("#FormGuardar")[0]);
    $.ajax({
        url: 'mant_popupAgregar',
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

$(document).ready(function() {
    $('#Tabla_Listado').DataTable(
    );
});

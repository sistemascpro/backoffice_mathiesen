function GuardarRol()
{
    var Requeridos = ValidarRequeridos('RolRequired');

    if(Requeridos<=0){
        var formInfo = new FormData($("#FormGuardar")[0]);
        $.ajax({
            url: 'mant_roles_Guardar',
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

$(document).ready(function() {

});

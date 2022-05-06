function GuardarUsuario()
{
    var Requeridos = ValidarRequeridos('UsuRequired');

    if(Requeridos<=0){
        var formInfo = new FormData($("#FormGuardar")[0]);
        $.ajax({
            url: 'mant_usuariosGuardar',
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

    if($('#UsuarioId').val()=='dcfcd07e645d245babe887e5e2daa016'){
        $('#contrasenia1').addClass('UsuRequired');
        $('#contrasenia2').addClass('UsuRequired');
    }
    else {
        $('#contrasenia1').removeClass('UsuRequired');
        $('#contrasenia2').removeClass('UsuRequired');
    }
});

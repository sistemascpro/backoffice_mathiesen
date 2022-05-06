function ActualizarContrasenia()
{
    var requeridos = 0;
    if(!$("#contrasenia1").val() || $("#contrasenia1").val().trim().length==0) { $("#contrasenia1").addClass('is-invalid'); requeridos++; }
    if(!$("#contrasenia2").val() || $("#contrasenia2").val().trim().length==0) { $("#contrasenia2").addClass('is-invalid'); requeridos++; }

    if(requeridos>0)
    {
        QuitarFondoToast();
        $('#ToastBody').html('DEBE INGRESAR TODA LA INFORMACIÓN SOLICITADA')
        $("#Toaster").addClass("bg-danger").addClass("text-white");
        $('#Toaster').toast("show");
    }
    else{

        $("#contrasenia1").removeClass('is-invalid');
        $("#contrasenia2").removeClass('is-invalid');
        var formInfo = new FormData($("#FormActualizarContrasenia")[0]);
        $.ajax({
            url: 'usuarioPerfilUpdateContasenia',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: formInfo,
            contentType: false,
            processData: false,
            success:function(data)
            {
                if(data=='OK')
                {
                    $("#contrasenia1").val('');
                    $("#contrasenia2").val('');
                    QuitarFondoToast();
                    $('#ToastBody').html('INFORMACIÓN ACTUALIZADA')
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
                alert(textStatus);
                ToastSessionExpirada()
            }
        });
    }
}

function ActuaizarInformacion()
{
    var requeridos = 0;
    if(!$("#rut").val() || $("#rut").val().trim().length==0) { $("#rut").addClass('is-invalid'); requeridos++; }
    if(!$("#nombres").val() || $("#nombres").val().trim().length==0) { $("#nombres").addClass('is-invalid'); requeridos++; }
    if(!$("#apellidos").val() || $("#apellidos").val().trim().length==0) { $("#apellidos").addClass('is-invalid'); requeridos++; }
    if(!$("#telefono1").val() || $("#telefono1").val().trim().length==0) { $("#telefono1").addClass('is-invalid'); requeridos++; }
    if(!$("#email").val() || $("#email").val().trim().length==0) { $("#email").addClass('is-invalid'); requeridos++; }

    if(requeridos>0)
    {
        QuitarFondoToast();
        $('#ToastBody').html('DEBE INGRESAR TODA LA INFORMACIÓN SOLICITADA')
        $("#Toaster").addClass("bg-danger").addClass("text-white");
        $('#Toaster').toast("show");
    }
    else{

        var formInfo = new FormData($("#FormActualizarInformacion")[0]);
        $.ajax({
            url: 'usuarioPerfilUpdateInformacion',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: formInfo,
            contentType: false,
            processData: false,
            success:function(data)
            {
                if(data!='[]' || data!='error')
                {
                    var datos=JSON.parse(data);
                    $('#AvatarUsuario').html('<img src="'+datos[0]['avatar']+'" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">');
                    $('#AvatarUsuarioHeader').html('<img src="'+datos[0]['avatar']+'" class="user-img" alt="user avatar">');

                    QuitarFondoToast();
                    $('#ToastBody').html('INFORMACIÓN ACTUALIZADA')
                    $("#Toaster").addClass("bg-success").addClass("text-white");
                    $('#Toaster').toast("show");
                }
                else
                {
                    QuitarFondoToast();
                    $('#ToastBody').html('ERROR AL ACTUALIZAR LA INFORMACIÓN')
                    $("#Toaster").addClass("bg-danger").addClass("text-white");
                    $('#Toaster').toast("show");
                }
            }
        });

    }
}

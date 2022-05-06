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

function crearEditar(id)
{
    var form = document.createElement("form");
    form.method = "POST";
    form.action = "mant_usuarios_crearEditar";
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
        url: 'mant_usuarios_updateEstado',
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
        var texto = 'EL USUARIO ACTIVADO TENDRA ACCESO AL SISTEMA, Y LA INFORMACIÓN CONTENIDA EN ESTE!';
    }
    else
    {
        var titulo = 'BLOQUEAR?';
        var texto = 'EL USUARIO BLOQUEADO NO PUEDE HACER USO DEL SISTEMA!';
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

    $('#Usuarios_List').DataTable(
    );

    if($('#UsuarioId').val()=='dcfcd07e645d245babe887e5e2daa016'){
        $('#contrasenia1').addClass('UsuRequired');
        $('#contrasenia2').addClass('UsuRequired');
    }
    else {
        $('#contrasenia1').removeClass('UsuRequired');
        $('#contrasenia2').removeClass('UsuRequired');
    }

});

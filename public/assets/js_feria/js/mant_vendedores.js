function GuardarVendedor()
{
    var Requeridos = ValidarRequeridos('VendRequired');

    var Contrasenias=0;
    if($('#VendedorId').val()=='dcfcd07e645d245babe887e5e2daa016' && $('#contrasenia1').val().trim().length==0){
        Contrasenias++;
        $('#contrasenia1').addClass("is-invalid");
    }
    else if($('#VendedorId').val()=='dcfcd07e645d245babe887e5e2daa016' && $('#contrasenia2').val().trim().length==0){
        Contrasenias++;
        $('#contrasenia2').addClass("is-invalid");
    }

    if(Contrasenias>0) {
        ToastFaltaInformacion();
    }
    else if(Requeridos<=0 && Contrasenias==0){
        var formInfo = new FormData($("#FormGuardarVendedor")[0]);
        $.ajax({
            url: 'mant_vendedores_Guardar',
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
    form.action = "mant_vendedores_crearEditar";
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
        url: 'mant_vendedores_updateEstado',
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
    $('#Vendedores_List').DataTable(
    );

    $('#Clientes_List').DataTable(
    );

});

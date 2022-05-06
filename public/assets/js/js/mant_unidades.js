function Guardar()
{
    var Requeridos = ValidarRequeridos('UnidadRequired');

    if(Requeridos<=0){
        var formInfo = new FormData($("#FormGuardar")[0]);
        $.ajax({
            url: 'mant_unidades_Guardar',
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

function eliminar(id)
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
                url: 'mant_unidades_eliminar',
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

function crearEditar(id)
{
    var form = document.createElement("form");
    form.method = "POST";
    form.action = "mant_unidades_crearEditar";
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
        url: 'mant_unidades_updateEstado',
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
        var texto = '';
    }
    else
    {
        var titulo = 'BLOQUEAR?';
        var texto = '';
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

    $('.single-select').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
    });
});

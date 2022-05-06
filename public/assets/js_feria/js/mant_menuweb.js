function Guardar()
{
    var Requeridos = ValidarRequeridos('ItemRequired');

    if(Requeridos<=0){
        if( (!$('#fk_familia').val() || $('#fk_familia').val().length==0) && (!$('#fk_subfamilia').val() || $('#fk_subfamilia').val().length==0)  ){
            ToastError('DEBE SELECCIONAR UNA CLASE O SUB CLASE');
        }
        var formInfo = new FormData($("#FormGuardar")[0]);
        $.ajax({
            url: 'mant_menuweb_Guardar',
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
                url: 'mant_menuweb_eliminar',
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

function CargarSubFamilia()
{
    var Salida = `
    <select
    class="ProductoRequired form-select single-select"
    maxlength="30"
    id="fk_subfamilia"
    name="fk_subfamilia"
    data-live-search="true"
    >`;
    if($('#fk_familia').val()==''){
        Salida += `<option value="">SIN DATOS</option>`;
        Salida += `</select>`;
        $('#div_sub_familia').html(Salida);
    }
    else{
        $.ajax({
            url: 'mant_menuweb_CargarSubFamilia',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                _token : $("#_token").val()
                , fk_familia : $('#fk_familia').val()
            },
            success:function(data)
            {

                var datos=JSON.parse(data);
                if(datos.length>0){
                    Salida += `<option value="">SELECCCIONAR...</option>`;
                    for(var i=0; i<datos.length; i++){
                        Salida += `<option value='`+datos[i]['codigo']+`' `+datos[i]['selected']+`>`+datos[i]['codigo']+` `+datos[i]['nombre']+`</option>`;
                    }
                }
                else{
                    Salida += `<option value="">SIN DATOS</option>`;
                }
                Salida += `</select>`;
                $('#div_sub_familia').html(Salida);
            },error:function(XMLHttpRequest,textStatus,errorThrown){
                ToastSessionExpirada();
            }
        });
    }
}

function crearEditar(id)
{
    var form = document.createElement("form");
    form.method = "POST";
    form.action = "mant_menuweb_crearEditar";
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
        url: 'mant_menuweb_updateEstado',
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
    $('#Lista').DataTable(
    );

    $('.single-select').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
    });
});

function VerHistorialArchivos()
{
    $('#ModalHistorialArchivosContent').html('');
    $.ajax({
        url:  $('#InputNombreRuta').val()+'GetHistorialArchivos',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , fk_producto : $('#productoid').val()
        },
        success:function(data)
        {
            var Salida = '';
            var datos=JSON.parse(data);
            if(datos.length>0){
                Salida = '<table class="table table-striped"><tr><th>FECHA</th><th>RESPONSABLE</th><th>TIPO</th><th>NOMBRE</th><th>VER</th></tr>'
                for(var i=0; i<datos.length; i++){
                    Salida += `
                    <tr><td>`+datos[i]['fecha']+`</td><td>`+datos[i]['responsable']+`</td><td>`+datos[i]['tipo']+`</td><td>`+datos[i]['nombre']+`</td><td><a class="text-primary" href="`+datos[i]['archivo']+`" target="_blank" download><h6> VER</h6></a></td></tr>
                    `;
                }
                Salida += `</table>`;
            }
            $('#ModalHistorialArchivosContent').html(Salida);
        },error:function(XMLHttpRequest,textStatus,errorThrown){
            ToastSessionExpirada();
        }
    });
    $('#ModalHistorialArchivos').modal('show');

}
function ElimianrArchivoProducto(archivo, producto, tipo)
{
    Swal.fire({
    title: '',
    text: 'DESEA ELIMINAR EL ARCHIVO',
    showDenyButton: false,
    showCancelButton: true,
    confirmButtonText: `SI`,
    confirmButtonColor: `#52BE80`,
    denyButtonText: `NO`,
    cancelButtonText: `NO`,
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url:  $('#InputNombreRuta').val()+'EliminarArchivo',
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    _token : $("#_token").val()
                    , archivo:archivo
                    , producto:producto
                    , tipo:tipo
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

        } else if (result.isDenied) {

        }
    })
}

function CargarCaracteristicasFamilia()
{
    $('#DivCaracteristicasEspeciales').html('');
    $.ajax({
        url:  $('#InputNombreRuta').val()+'CargarCaracteristicasFamilia',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , fk_familia : $('#fk_familia').val()
            , fk_producto : $('#productoid').val()
        },
        success:function(data)
        {
            $('#DivCaracteristicasEspeciales').html(data);
        },error:function(XMLHttpRequest,textStatus,errorThrown){
            ToastSessionExpirada();
        }
    });
}

function CargarFamiliasSecundarias()
{
    $('#DivFamiliasSecundarias').html('');
    $.ajax({
        url:  $('#InputNombreRuta').val()+'CargarFamiliasSecundarias',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , fk_familia : $('#fk_familia').val()
            , fk_producto : $('#productoid').val()
        },
        success:function(data)
        {
            var Salida = '';
            var datos=JSON.parse(data);
            if(datos.length>0){
                for(var i=0; i<datos.length; i++){
                    Salida += `
                    <div class="col-4 row mb-3">
                        <div class="col-sm-2 text-secondary">
                            <input
                            class="form-check-input chbk-20"
                            type="checkbox"
                            id="chkFamiliaSecundaria[]"
                            name="chkFamiliaSecundaria[]"
                            value="`+datos[i]['id']+`"
                            `+datos[i]['checked']+`
                            >
                        </div>
                        <div class="col-sm-10 text-secondary">
                            `+datos[i]['codigo']+` - `+datos[i]['nombre']+`
                        </div>
                    </div>
                    `;
                }
            }
            $('#DivFamiliasSecundarias').html(Salida);
        },error:function(XMLHttpRequest,textStatus,errorThrown){
            ToastSessionExpirada();
        }
    });
}

function GuardarCambios()
{
    var Requeridos = ValidarRequeridos('ProdExtRequired');

    if(Requeridos<=0){
        var formInfo = new FormData($("#FormGuardar")[0]);
        $.ajax({
            url:  $('#InputNombreRuta').val()+'Guardar',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: formInfo,
            contentType: false,
            processData: false,
            success:function(data)
            {
                if(data=='OK')
                {
                    alert("OK");
                    //ToastInformacionGuardada();
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

function Productos_CrearEditar(id)
{
    var form = document.createElement("form");
    form.method = "POST";
    form.action =  $('#InputNombreRuta').val()+"CrearEditar";
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

function Productos_CambiarEstado(id, estado)
{
    $.ajax({
        url: $('#InputNombreRuta').val()+'UpdateEstado',
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

function Productos_UpdateEstado(id, estado)
{
    if(estado==true)
    {
        var titulo = 'ACTIVAR PRODUCTO?';
        var texto = '';
    }
    else
    {
        var titulo = 'BLOQUEAR PRODUCTO?';
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
            Productos_CambiarEstado(id, estado)
        } else if (result.isDenied) {

        }
    })
}

$(document).ready(function() {
    $('#Tabla_Listado').DataTable();

    if( $('#productoid').val()!='0' ) { CargarCaracteristicasFamilia(); }
    if( $('#productoid').val()!='0' ) { CargarFamiliasSecundarias(); }

    var _URL = window.URL || window.webkitURL;
    $("#imagen1").change(function (e) {
        var file, img;
        if ((file = this.files[0])) {
            img = new Image();
            var objectUrl = _URL.createObjectURL(file);
            img.onload = function () {
                if(this.width!=500 || this.height!=500)
                {
                    $('#ToastBody').html('LA IMAGEN NO CUMPLE CON LAS DIMENSIONES DE 500x500')
                    $("#Toaster").addClass("bg-danger").addClass("text-white");
                    $('#Toaster').toast("show");
                    $("#imagen1").val('');
                }

                _URL.revokeObjectURL(objectUrl);
            };
            img.src = objectUrl;
        }
    });
});

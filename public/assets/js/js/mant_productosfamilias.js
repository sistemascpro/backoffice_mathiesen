function ElimianrArchivoFamilia2(ruta, id)
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
                url:  $('#InputNombreRuta').val()+'EliminarArchivo2',
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    _token : $("#_token").val()
                    , id:id
                    , ruta:ruta
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

function ElimianrArchivoFamilia(ruta, id)
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
                url:  $('#InputNombreRuta').val()+'EliminarArchivo1',
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    _token : $("#_token").val()
                    , id:id
                    , ruta:ruta
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

function EliminarCaracteristica(id)
{
    Swal.fire({
    title: 'DESEA ELIMINAR?',
    text: 'DESEA ELIMINAR LA CARACTERISTICA',
    showDenyButton: false,
    showCancelButton: true,
    confirmButtonText: `SI`,
    confirmButtonColor: `#52BE80`,
    denyButtonText: `NO`,
    cancelButtonText: `NO`,
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url:  $('#InputNombreRuta').val()+'EliminarCaracteristica',
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
                        CargarCaracteristicasFamilias();
                    }
                    else
                    {
                        QuitarFondoToast();
                        $('#ToastBody').html('LA CARACTERISTICA NO SE PUEDE ELIMINAR, POR QUE TIENE PRODUCTOS RELACIONADOS')
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

function CargarCaracteristicasFamilias()
{
    $('#DivCaractericasAgregadas').html('');
    $.ajax({
        url:  $('#InputNombreRuta').val()+'CargarCaracteristicasFamilias',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , id : $('#familiaid').val()
        },
        success:function(data)
        {
            var Salida = `
            <table id="ContenidoOpciones" class="table table-striped table-responive table-bordered">
                <thead><tr><th>ACCIONES</th><th>ES FILTRO</th><th>TIPO</th><th>CARACTERISTICA</th><th>VALOR</th></tr></thead>
                <tbody>`;

            var datos=JSON.parse(data);
            if(datos.length>0)
            {
                for(var i=0; i<datos.length; i++)
                {
                    Salida += `
                    <tr>
                    <td><input type="button" class="btn btn-danger px-4" value="QUITAR" onclick="EliminarCaracteristica(`+datos[i]['id']+`);"/></td>
                    <td>`+datos[i]['es_filtro']+`</td>
                    <td>`+datos[i]['caract_tipo']+`</td>
                    <td>`+datos[i]['caract_nombre']+`</td>
                    <td>`+datos[i]['valor']+`</td>
                    </tr>
                    `;
                }
            }   
            Salida += `
            </tbody>
            </table>
            `;
            $('#DivCaractericasAgregadas').html(Salida);

        },error:function(XMLHttpRequest,textStatus,errorThrown){
            ToastSessionExpirada();
        }
    });
}

function Caracteristicas_GuardarCaracteristica()
{
    var Requeridos = ValidarRequeridos('FamiliaRequired');

    if(Requeridos<=0){
        var formInfo = new FormData($("#FormGuardar")[0]);
        $.ajax({
            url:  $('#InputNombreRuta').val()+'GuardarCaracteristica',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: formInfo,
            contentType: false,
            processData: false,
            success:function(data)
            {
                if(
                    data=='NO SE DETECTO EL TIPO DE CARACTERISTICA'
                    || data=='FALTA INFORMACION'
                    || data=='EL NOMBRE YA ESTÁ REGISTRADO'
                    || data=='EL CÓDIGO YA ESTÁ REGISTRADO'
                    || data=='EL CÓDIGO YA ESTÁ REGISTRADO'
                )
                {
                    QuitarFondoToast();
                    ToastError(data);
                }
                else
                {
                    QuitarFondoToast();
                    $('#ToastBody').html('INFORMACIÓN GUARDADA CORRECTAMENTE')
                    $("#Toaster").addClass("bg-success").addClass("text-white");
                    $('#Toaster').toast("show");
                    $('#familiaid').val(data);
                    $('#DivFormularioCaracteristica').html('');
                    $('#IdSelectCaracteristica').val('');
                    CargarCaracteristicasFamilias();
                }
            }
        });
    }
}

function CargarFormaCaracteristica(){
    $('#DivFormularioCaracteristica').html('');
    if( $('#IdSelectCaracteristica').val()!='')
    {
        $.ajax({
            url:  $('#InputNombreRuta').val()+'CargarFormaCaracteristica',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                _token : $("#_token").val()
                , id : $('#IdSelectCaracteristica').val()
            },
            success:function(data)
            {
                var datos=JSON.parse(data);
                if(datos.length>0)
                {
                    if(datos[0]['libre']=='NO') { var readonly =' readonly '; } else { var readonly = ''; }
                    if(datos[0]['obligatorio']=='SI') { var DetCaractRequired =' DetCaractRequired '; } else { var DetCaractRequired = ''; }

                    var Salida = `<div class="col-12 mb-3"><h6 class="mb-0 text-primary">FORMULARIO CARACTERISTICAS</h6></div>`;

                    if(datos[0]['tipo']==0)
                    {
                        Salida = ``;
                    }
                    else if( datos[0]['tipo']==1)
                    {
                        Salida +=`
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0">SOLO NUMERO</p>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input
                                type="number"
                                class="`+DetCaractRequired+` form-control"
                                maxlength="250"
                                id="solonumero"
                                name="solonumero"
                                value=""
                                `+readonly+`
                                />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0">ES FILTRO</p>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <select
                                class="selectpicker form-select"
                                data-live-search="true"
                                id="EsFiltro"
                                name="EsFiltro"
                                >
                                    <option value="SI" selected>SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <input type="button" class="btn btn-primary px-4" value="AGREGAR CARACTERISTICA" onclick="Caracteristicas_GuardarCaracteristica(`+datos[0]['tipo']+`);" />
                        </div>
                        <hr>
                        `;
                    }
                    else if( datos[0]['tipo']==2)
                    {
                        Salida +=`
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0">AREA DE TEXTO</p>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <textarea
                                type="text"
                                class="`+DetCaractRequired+` form-control"
                                rows="10"
                                id="areadetexto"
                                name="areadetexto"
                                value=""
                                `+readonly+`
                                /></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0">ES FILTRO</p>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <select
                                class="selectpicker form-select"
                                data-live-search="true"
                                id="EsFiltro"
                                name="EsFiltro"
                                >
                                    <option value="SI" selected>SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <input type="button" class="btn btn-primary px-4" value="AGREGAR CARACTERISTICA" onclick="Caracteristicas_GuardarCaracteristica(`+datos[0]['tipo']+`);" />
                        </div>
                        <hr>
                        `;
                    }
                    else if( datos[0]['tipo']==3)
                    {
                        Salida +=`
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0">CAMPO DE TEXTO</p>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input
                                type="text"
                                class="`+DetCaractRequired+` form-control"
                                maxlength="250"
                                id="campodetexto"
                                name="campodetexto"
                                value=""
                                `+readonly+`
                                />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0">ES FILTRO</p>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <select
                                class="selectpicker form-select"
                                data-live-search="true"
                                id="EsFiltro"
                                name="EsFiltro"
                                >
                                    <option value="SI" selected>SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <input type="button" class="btn btn-primary px-4" value="AGREGAR CARACTERISTICA" onclick="Caracteristicas_GuardarCaracteristica(`+datos[0]['tipo']+`);" />
                        </div>
                        <hr>
                        `;
                    }
                    else if( datos[0]['tipo']==4 || datos[0]['tipo']==5)
                    {
                        Salida +=`
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0">ES FILTRO</p>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <select
                                class="selectpicker form-select"
                                data-live-search="true"
                                id="EsFiltro"
                                name="EsFiltro"
                                >
                                    <option value="SI" selected>SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <input type="button" class="btn btn-primary px-4" value="AGREGAR CARACTERISTICA" onclick="Caracteristicas_GuardarCaracteristica(`+datos[0]['tipo']+`);" />
                        </div>
                        <hr>
                        `;
                    }
                    $('#DivFormularioCaracteristica').html(Salida);
                }
            },error:function(XMLHttpRequest,textStatus,errorThrown){
                ToastSessionExpirada();
            }
        });
    }

}

function ConfirmarDeseaAgregarCaracterstica(id, nombre)
{
    Swal.fire({
    title: 'DESEA AGREGAR?',
    text: 'DESEA AGREGAR LA CARACTERISTICA DE SELECCION DE '+nombre,
    showDenyButton: false,
    showCancelButton: true,
    confirmButtonText: `SI`,
    confirmButtonColor: `#52BE80`,
    denyButtonText: `NO`,
    cancelButtonText: `NO`,
    }).then((result) => {
        if (result.isConfirmed) {
            Caracteristicas_GuardarCaracteristica();
        } else if (result.isDenied) {

        }
    })
}

function Guardar()
{
    var Requeridos = ValidarRequeridos('FamiliaRequired');

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
                url:  $('#InputNombreRuta').val()+'Eliminar',
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

function Familias_CrearEditar(id)
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

function Familias_CambiarEstado(id, estado)
{
    $.ajax({
        url:  $('#InputNombreRuta').val()+'UpdateEstado',
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

function Familias_ActualizarEstado(id, estado)
{
    if(estado==true)
    {
        var titulo = 'ACTIVAR?';
        var texto = 'LA FAMILIA PODRA SER ASCOCIADA A PRODUCTOS!';
    }
    else
    {
        var titulo = 'BLOQUEAR?';
        var texto = 'LA FAMILIA NO PODRA SER ASOCIADA A PRODUCTOS!';
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
            Familias_CambiarEstado(id, estado)
        } else if (result.isDenied) {

        }
    })
}

$(document).ready(function() {
    $('#Tabla_Listado').DataTable();

    if($('#familiaid').val()!=0){
        CargarCaracteristicasFamilias();
    }
});

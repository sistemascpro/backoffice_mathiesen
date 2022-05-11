function EliminarOpcion(id)
{
    Swal.fire({
    title: 'ELIMINAR?',
    text: 'LA INFORMACIÓN YA NO PODRÁ SER RECUPERADA!',
    showDenyButton: false,
    showCancelButton: true,
    confirmButtonText: `SI`,
    confirmButtonColor: `#52BE80`,
    denyButtonText: `NO`,
    cancelButtonText: `NO`,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url:  $('#InputNombreRuta').val()+'EliminarOpcion',
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    _token : $("#_token").val()
                    , id :  id
                },
                success:function(data)
                {
                    if( data=='OK' )
                    {
                        CargarOpcionesCaracteristicas();
                    }
                    else
                    {
                        QuitarFondoToast();
                        $('#ToastBody').html(data);
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

function Caracteristicas_AgregarOpcion(Contenido, id) {

    if( typeof Contenido=='undefined' && ( typeof $('#opcionseleccion').val()=='undefined' || $('#opcionseleccion').val().length<=0 ) ) 
    {
        $('#ToastBody').html('DEBRE INGRESAR UNA OPCION')
        $("#Toaster").addClass("bg-danger").addClass("text-white");
        $('#Toaster').toast("show");
    } 
    else 
    {
        if( typeof Contenido!='undefined' )
        {
            $('#ContenidoOpciones').find('tbody').append(`
            <tr>
                <td><input type='hidden' class="ClassContenidoSeleccion" id="ContenidoOpcionExiste[]" name="ContenidoOpcionExiste[]" value="`+Contenido+`">`+Contenido+`</td>
                <td><input type="button" class="QuitarLinea btn btn-danger px-4" value="QUITAR" onclick="EliminarOpcion(`+id+`);"/></td>
            </tr>
            `);
        }
        else
        {
            $('#ContenidoOpciones').find('tbody').append(`
            <tr>
                <td><input type='hidden' class="ClassContenidoSeleccion" id="ContenidoOpcion[]" name="ContenidoOpcion[]" value="`+$('#opcionseleccion').val()+`">`+$('#opcionseleccion').val()+`</td>
                <td><input type="button" class="QuitarLinea btn btn-danger px-4" value="QUITAR"/></td>
            </tr>
            `);
            $('#opcionseleccion').val('');
            $(".QuitarLinea").click(function() {
                $(this).closest("tr").remove();
            });
        }
    }
}

function CargarFormaCaracteristica() {

    if($('#tipo').val()==0)
    {
        var Salida = '';
    }
    else if($('#tipo').val()==1)
    {
        var Salida =`
        <div class="row mb-3">
            <div class="col-sm-3">
                <p class="mb-0">SOLO NUMERO</p>
            </div>
            <div class="col-sm-9 text-secondary">
                <input
                type="number"
                class="form-control"
                maxlength="250"
                id="solonumero"
                name="solonumero"
                value=""
                />
            </div>
        </div>
        `;
    }
    else if($('#tipo').val()==2)
    {
        var Salida =`
        <div class="row mb-3">
            <div class="col-sm-3">
                <p class="mb-0">AREA DE TEXTO</p>
            </div>
            <div class="col-sm-9 text-secondary">
                <textarea
                type="text"
                class="form-control"
                rows="10"
                id="areadetexto"
                name="areadetexto"
                value=""
                /></textarea>
            </div>
        </div>
        `;
    }
    else if($('#tipo').val()==4)
    {
        var Salida =`
        <div class="row mb-3">
            <div class="col-sm-3">
                <p class="mb-0">CAMPO DE TEXTO</p>
            </div>
            <div class="col-sm-9 text-secondary">
                <input
                type="text"
                class="form-control"
                maxlength="250"
                id="campodetexto"
                name="campodetexto"
                value=""
                />
            </div>
        </div>
        `;
    }
    else if($('#tipo').val()==3)
    {
        var Salida =`
        <div class="row mb-3">
            <div class="col-sm-3">
                <p class="mb-0">AGREGAR OPCION</p>
            </div>
            <div class="col-sm-6 text-secondary">
                <input
                type="text"
                class="form-control"
                maxlength="250"
                id="opcionseleccion"
                name="opcionseleccion"
                value=""
                />
            </div>
            <div class="col-sm-3">
                <input type="button" class="btn btn-primary px-4" value="AGREGAR OPCION" onclick="Caracteristicas_AgregarOpcion();" />
            </div>
        </div>
        <div id="DivContenidoOpciones">
            <table id="ContenidoOpciones" class="table table-striped table-responive table-bordered">
                <thead><tr><th>OPCION</th><th>QUITAR</th></tr></thead>
                <tbody></tbody>
            </table>
        </div>
        `;
    }
    $('#DetalleCaracteristica').html(Salida);

    if( ($('#tipo').val()==3 || $('#tipo').val()) && $('#id').val()!=0 )
    {
        CargarOpcionesCaracteristicas()
    }
}

function CargarOpcionesCaracteristicas(){

    $('#DivContenidoOpciones').html(`
        <table id="ContenidoOpciones" class="table table-striped table-responive table-bordered">
            <thead><tr><th>OPCION</th><th>QUITAR</th></tr></thead>
            <tbody></tbody>
        </table>
    `);

    $.ajax({
        url:  $('#InputNombreRuta').val()+'GetOpciones',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , id :  $('#id').val()
        },
        success:function(data)
        {
            var datos=JSON.parse(data);
            if(datos.length>0)
            {
                for(var i=0; i<datos.length; i++)
                {
                    Caracteristicas_AgregarOpcion(datos[i]['opcion'], datos[i]['id']);
                }
            }
        },error:function(XMLHttpRequest,textStatus,errorThrown){
            ToastSessionExpirada();
        }
    });
}

function Caracteristicas_GuardarCambios()
{
    var CantidadOpciones = 0;
    $('.ClassContenidoSeleccion').each(function(index, element){
        CantidadOpciones++
    });

    var Requeridos = ValidarRequeridos($('#InputNombreRequired').val());

    if(Requeridos>0) { }
    else if( $('#tipo').val()==1 && $('#libre').val()=='NO' && ( typeof $('#solonumero').val()=='undefined' || $('#solonumero').val().length<=0 ) )
    {
        $('#ToastBody').html('DEBE INGRESAR UN VALOR EN EL CAMPO SOLO NUMEROS')
        $("#Toaster").addClass("bg-danger").addClass("text-white");
        $('#Toaster').toast("show");
    }
    else if( $('#tipo').val()==1 && $('#libre').val()=='SI' && typeof $('#solonumero').val()=='undefined' )
    {
        $('#ToastBody').html('EL CAMPO SOLO NUMERO NO ESTA CREADO')
        $("#Toaster").addClass("bg-danger").addClass("text-white");
        $('#Toaster').toast("show");
    }
    else if( $('#tipo').val()==2 && $('#libre').val()=='NO' && ( typeof $('#areadetexto').val()=='undefined' || $('#areadetexto').val().length<=0 ) )
    {
        $('#ToastBody').html('DEBE INGRESAR UN VALOR EN EL CAMPO AREA DE TEXTO')
        $("#Toaster").addClass("bg-danger").addClass("text-white");
        $('#Toaster').toast("show");
    }
    else if( $('#tipo').val()==2 && $('#libre').val()=='SI' && ( typeof $('#areadetexto').val()=='undefined' ) )
    {
        $('#ToastBody').html('EL CAMPO AREA DE TEXTO NO ESTA CREADO')
        $("#Toaster").addClass("bg-danger").addClass("text-white");
        $('#Toaster').toast("show");
    }
    else if( $('#tipo').val()==4 && $('#libre').val()=='NO' && ( typeof $('#campodetexto').val()=='undefined' || $('#campodetexto').val().length<=0 ) )
    {
        $('#ToastBody').html('DEBE INGRESAR UN VALOR EN EL CAMPO DE TEXTO')
        $("#Toaster").addClass("bg-danger").addClass("text-white");
        $('#Toaster').toast("show");
    }
    else if( $('#tipo').val()==4 && $('#libre').val()=='NO' && ( typeof $('#campodetexto').val()=='undefined' ) )
    {
        $('#ToastBody').html('EL CAMPO DE TEXTO NO ESTA CREADO')
        $("#Toaster").addClass("bg-danger").addClass("text-white");
        $('#Toaster').toast("show");
    }
    else if( $('#tipo').val()==3 && CantidadOpciones==0 )
    {
        $('#ToastBody').html('DEBE INGRESAR MINIMO UNA OPCION')
        $("#Toaster").addClass("bg-danger").addClass("text-white");
        $('#Toaster').toast("show");
    }
    else
    {
        if(Requeridos<=0)
        {
            var formInfo = new FormData($("#Caracteristicas_FormGuardar")[0]);
            $.ajax({
                url: $('#InputNombreRuta').val()+'Guardar',
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
}

function Caracteristicas_CrearEditar(id)
{
    var form = document.createElement("form");
    form.method = "POST";
    form.action = $('#InputNombreRuta').val()+'CrearEditar';
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

function Caracteristicas_CambiarEstado(id, estado)
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

function Caracteristicas_UpdateEstado(id, estado)
{
    if(estado==true)
    {
        var titulo = 'ACTIVAR?';
        var texto = 'LA CARACTERISTICA PODRA SER ASCOCIADA A PRODUCTOS!';
    }
    else
    {
        var titulo = 'BLOQUEAR?';
        var texto = 'LA CARACTERISTICA NO PODRA SER ASOCIADA A PRODUCTOS!';
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
            Caracteristicas_CambiarEstado(id, estado)
        } else if (result.isDenied) {

        }
    })
}

$(document).ready(function()
{
    $('#Tabla_Listado').DataTable( );

    if( $('#id').val()!=0 )
    {
        CargarFormaCaracteristica();
    }
});


function GuardarUsuarioExistente()
{
    if( $('#UsuarioExistente').val().length==0){
        $('#UsuarioExistente').addClass("is-invalid");
        ToastFaltaInformacion();
    }
    else{
        $('#UsuarioExistente').removeClass("is-invalid");
        $.ajax({
            url: 'mant_clientes_GuardarUsuarioExistente',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                _token : $("#_token").val()
                , UsuarioId : $('#UsuarioExistente').val()
                , ClienteId : $('#ClienteId').val()
            },
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
            },error:function(XMLHttpRequest,textStatus,errorThrown){
                ToastSessionExpirada();
            }
        });
    }
}

function bloquearUsuario(id, estado)
{
    $.ajax({
        url: 'mant_clientes_updateEstadoUsuario',
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

function editarUsuario(id)
{
    $.ajax({
        url: 'mant_clientes_EditarUsuario',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , id : id
        },
        success:function(data)
        {
            if(data.length>0)
            {
                $('#UsuarioId').val(data[0]['id_md5']);
                $('#usuario').val(data[0]['usuario']);
                let estado = document.getElementById('estado');
                if(data[0]['estado']==true) {
                    estado.value = true;
                }
                else{
                    estado.value = false;
                }
                $('#rut').val(data[0]['rut']);
                $('#nombres').val(data[0]['nombres']);
                $('#apellidos').val(data[0]['apellidos']);
                $('#telefono1').val(data[0]['telefono1']);
                $('#telefono2').val(data[0]['telefono2']);
                $('#email').val(data[0]['email']);
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

function GuardarFamilias()
{
    var Requeridos = ValidarRequeridos('SubFamRequired');

    if(Requeridos<=0){
        var formInfo = new FormData($("#FormGuardarSubFamilias")[0]);
        $.ajax({
            url: 'mant_clientes_GuardarSubFamilias',
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

function GuardarUsuario()
{
    var Requeridos = ValidarRequeridos('UsuRequired');

    var Contrasenias=0;
    if($('#UsuarioId').val()=='dcfcd07e645d245babe887e5e2daa016' && $('#contrasenia1').val().trim().length==0){
        Contrasenias++;
        $('#contrasenia1').addClass("is-invalid");
    }
    else if($('#UsuarioId').val()=='dcfcd07e645d245babe887e5e2daa016' && $('#contrasenia2').val().trim().length==0){
        Contrasenias++;
        $('#contrasenia2').addClass("is-invalid");
    }

    if(Contrasenias>0){
        ToastFaltaInformacion();
    }
    else if(Requeridos<=0 && Contrasenias==0){
        $('#contrasenia1').removeClass("is-invalid");
        $('#contrasenia2').removeClass("is-invalid");
        var formInfo = new FormData($("#FormGuardarUsuario")[0]);
        $.ajax({
            url: 'mant_clientes_GuardarUsuario',
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
    form.action = "mant_clientes_crearEditar";
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

$(document).ready(function() {
    $('#Clientes_List').DataTable(
    );

    $('#Usuarios_List').DataTable(
    );

});

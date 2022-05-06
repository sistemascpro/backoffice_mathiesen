function CargarProducto(Codigo, Descripcion)
{
    $.ajax({
        url: 'mant_prodpromosregalosCargarProducto',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            _token : $("#_token").val()
            , Codigo : $('#'+Codigo).val()
        },
        success:function(data)
        {
            if(data.length>0)
            {
                $('#'+Descripcion).val(data[0]['DesProd'])
            }
            
        },error:function(XMLHttpRequest,textStatus,errorThrown){
            ToastSessionExpirada();
        }
    });
}

function GuardarCambios()
{
    var Requeridos = ValidarRequeridos('PromRegaRequired');

    if(Requeridos<=0){

        if( $('#cant1').val()<=0 || $('#cant2').val()<=0){
            QuitarFondoToast();
            ToastError("DEBE INGRESAR LAS CANTIDADES");
        }
        else if( $('#precio2').val()<=0){
            QuitarFondoToast();
            ToastError("DEBE INGRESAR EL PRECIO DE REGALO");
        }
        else {
            var formInfo = new FormData($("#FormGuardar")[0]);
            $.ajax({
                url: 'mant_prodpromosregalosGuardar',
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

function crearEditar(id)
{
    var form = document.createElement("form");
    form.method = "POST";
    form.action = "mant_prodpromosregalosCrearEditar";
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
    $('#TablaLista').DataTable(
    );
});

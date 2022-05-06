function puntitos(n) {   
    n = String(n);
    var RgX = /^(.*\s)?([-+\u00A3\u20AC]?\d+)(\d{3}\b)/;
    return n == (n = n.replace(RgX, "$1$2.$3")) ? n : puntitos(n);
  }
function CargarPreContenidoCarro(data){
    if(data==undefined){
        $('#DivBolsaCantProductos').html(0);
        $('#DivBolsaTotal').html('$ 0');
    }
    else if(!data){
        $('#DivBolsaCantProductos').html(0);
        $('#DivBolsaTotal').html('$ 0');
    }else if(data.length<=0){
        $('#DivBolsaCantProductos').html(0);
        $('#DivBolsaTotal').html('$ 0');
    }else{
        $('#DivBolsaCantProductos').html(data[0]['cantidad']);
        $('#DivBolsaTotal').html('$ '+puntitos(data[0]['total']));
    }
}
function CargandoProductos(){
    return`
        <section class="mt-3 static-media-section pb-80 bg-white">
            <div class="container">
                <div class="static-media-wrap bg-warning rounded-5">
                    <H1 class="mt-2 mb-2 sub-title text-white" data-animation-in="fadeInRight" data-delay-in="2" style="opacity: 1; animation-delay: 2s;">CARGANDO PRODUCTOS `+cargando()+`</H1>
                </div>
            </div>
        </section>
    `;
}

function ProductosNoEncontrados(){
    return`
        <section class="mt-3 static-media-section pb-80 bg-white">
            <div class="container">
                <div class="static-media-wrap bg-warning rounded-5">
                    <H1 class="mt-2 mb-2 sub-title text-white" data-animation-in="fadeInRight" data-delay-in="2" style="opacity: 1; animation-delay: 2s;">NO SE ENCONTRARON PRODUCTOS RELACIONADOS</H1>
                </div>
            </div>
        </section>`+EcommerceBanners1()+`
    `;
}

function EcommerceBanners1(){

    return `
    <div class="common-banner bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-30">
                    <div class="banner-thumb">
                        <a href="shop-grid-4-column.html" class="zoom-in d-block overflow-hidden">
                            <img src="assets/img/banner/1.jpg" alt="banner-thumb-naile">
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-30">
                    <div class="banner-thumb">
                        <a href="shop-grid-4-column.html" class="zoom-in d-block overflow-hidden">
                            <img src="assets/img/banner/2.jpg" alt="banner-thumb-naile">
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-30">
                    <div class="banner-thumb">
                        <a href="shop-grid-4-column.html" class="zoom-in d-block overflow-hidden">
                            <img src="assets/img/banner/3.jpg" alt="banner-thumb-naile">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>`;
}
function cargando(){

    return `
    <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-danger" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-info" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    `;
}
function selectAllChk(clase)
{
    var requeridos = 0;
    $('.'+clase).each(function(index, element){
        element.checked = true;
    });
}

function revisarDigito(dvr)
{
    var CopiaRut = dvr;
    dv = dvr + ""
    if ( dv != '0' && dv != '1' && dv != '2' && dv != '3' && dv != '4' && dv != '5' && dv != '6' && dv != '7' && dv != '8' && dv != '9' && dv != 'k'  && dv != 'K')
    {
        return false;
    }
    return true;
}

function revisarDigito2(crut)
{
    var CopiaRut = crut;
    largo = crut.length;
    if ( largo < 2 )
    {
            return false;
    }
    if ( largo > 2 )
        rut = crut.substring(0, largo - 1);
    else
        rut = crut.charAt(0);
    dv = crut.charAt(largo-1);
    revisarDigito( dv );

    if ( rut == null || dv == null )
        return 0

    var dvr = '0'
    suma = 0
    mul  = 2

    for (i= rut.length -1 ; i >= 0; i--)
    {
        suma = suma + rut.charAt(i) * mul
        if (mul == 7)
            mul = 2
        else
            mul++
    }
    res = suma % 11
    if (res==1)
        dvr = 'k'
    else if (res==0)
        dvr = '0'
    else
    {
        dvi = 11-res
        dvr = dvi + ""
    }
    if ( dvr != dv.toLowerCase() )
    {
            return false;
    }

    return true;
}

function ValidateRut(texto)
{
    var CopiaRut = texto;
    var tmpstr = "";
    for ( i=0; i < texto.length ; i++ )
        if ( texto.charAt(i) != ' ' && texto.charAt(i) != '.' && texto.charAt(i) != '-' )
            tmpstr = tmpstr + texto.charAt(i);
    texto = tmpstr;
    largo = texto.length;

    if ( largo < 2 )
    {
            return false;
    }

    for (i=0; i < largo ; i++ )
    {
        if ( texto.charAt(i) !="0" && texto.charAt(i) != "1" && texto.charAt(i) !="2" && texto.charAt(i) != "3" && texto.charAt(i) != "4" && texto.charAt(i) !="5" && texto.charAt(i) != "6" && texto.charAt(i) != "7" && texto.charAt(i) !="8" && texto.charAt(i) != "9" && texto.charAt(i) !="k" && texto.charAt(i) != "K" )
        {
            return false;
        }
    }

    var invertido = "";
    for ( i=(largo-1),j=0; i>=0; i--,j++ )
        invertido = invertido + texto.charAt(i);
    var dtexto = "";
    dtexto = dtexto + invertido.charAt(0);
    dtexto = dtexto + '-';
    cnt = 0;

    for ( i=1,j=2; i<largo; i++,j++ )
    {
        //alert("i=[" + i + "] j=[" + j +"]" );
        if ( cnt == 3 )
        {
            dtexto = dtexto + '.';
            j++;
            dtexto = dtexto + invertido.charAt(i);
            cnt = 1;
        }
        else
        {
            dtexto = dtexto + invertido.charAt(i);
            cnt++;
        }
    }

    invertido = "";
    for ( i=(dtexto.length-1),j=0; i>=0; i--,j++ )
        invertido = invertido + dtexto.charAt(i);


    if ( revisarDigito2(texto) )
        return invertido.toUpperCase();

    return false;
}

function ValidateRut_FocusOut(texto)
{
    var nombre_campo = texto;
    texto = $('#'+texto).val();
    var CopiaRut = texto;
    var tmpstr = "";
    for ( i=0; i < texto.length ; i++ )
        if ( texto.charAt(i) != ' ' && texto.charAt(i) != '.' && texto.charAt(i) != '-' )
            tmpstr = tmpstr + texto.charAt(i);
    texto = tmpstr;
    largo = texto.length;

    if ( largo < 2 )
    {
    }

    for (i=0; i < largo ; i++ )
    {
        if ( texto.charAt(i) !="0" && texto.charAt(i) != "1" && texto.charAt(i) !="2" && texto.charAt(i) != "3" && texto.charAt(i) != "4" && texto.charAt(i) !="5" && texto.charAt(i) != "6" && texto.charAt(i) != "7" && texto.charAt(i) !="8" && texto.charAt(i) != "9" && texto.charAt(i) !="k" && texto.charAt(i) != "K" )
        {
        }
    }

    var invertido = "";
    for ( i=(largo-1),j=0; i>=0; i--,j++ )
        invertido = invertido + texto.charAt(i);
    var dtexto = "";
    dtexto = dtexto + invertido.charAt(0);
    dtexto = dtexto + '-';
    cnt = 0;

    for ( i=1,j=2; i<largo; i++,j++ )
    {
        //alert("i=[" + i + "] j=[" + j +"]" );
        if ( cnt == 3 )
        {
            dtexto = dtexto + '.';
            j++;
            dtexto = dtexto + invertido.charAt(i);
            cnt = 1;
        }
        else
        {
            dtexto = dtexto + invertido.charAt(i);
            cnt++;
        }
    }

    invertido = "";
    for ( i=(dtexto.length-1),j=0; i>=0; i--,j++ )
        invertido = invertido + dtexto.charAt(i);


    if ( revisarDigito2(texto) )
    {
        $('#'+nombre_campo).val(invertido.toUpperCase());
        $('#'+nombre_campo).removeClass("is-invalid");

    }
    else
    {
        $('#'+nombre_campo).val('');
        $('#'+nombre_campo).addClass("is-invalid");
        ToastRutInvalido();
    }
}

function ValidateRut_Tipeando(texto)
{
    var nombre_campo = texto;
    texto = $('#'+texto).val();
    var CopiaRut = texto;
    var tmpstr = "";
    for ( i=0; i < texto.length ; i++ )
        if ( texto.charAt(i) != ' ' && texto.charAt(i) != '.' && texto.charAt(i) != '-' )
            tmpstr = tmpstr + texto.charAt(i);
    texto = tmpstr;
    largo = texto.length;

    if ( largo < 2 )
    {
    }

    for (i=0; i < largo ; i++ )
    {
        if ( texto.charAt(i) !="0" && texto.charAt(i) != "1" && texto.charAt(i) !="2" && texto.charAt(i) != "3" && texto.charAt(i) != "4" && texto.charAt(i) !="5" && texto.charAt(i) != "6" && texto.charAt(i) != "7" && texto.charAt(i) !="8" && texto.charAt(i) != "9" && texto.charAt(i) !="k" && texto.charAt(i) != "K" )
        {
        }
    }

    var invertido = "";
    for ( i=(largo-1),j=0; i>=0; i--,j++ )
        invertido = invertido + texto.charAt(i);
    var dtexto = "";
    dtexto = dtexto + invertido.charAt(0);
    dtexto = dtexto + '-';
    cnt = 0;

    for ( i=1,j=2; i<largo; i++,j++ )
    {
        //alert("i=[" + i + "] j=[" + j +"]" );
        if ( cnt == 3 )
        {
            dtexto = dtexto + '.';
            j++;
            dtexto = dtexto + invertido.charAt(i);
            cnt = 1;
        }
        else
        {
            dtexto = dtexto + invertido.charAt(i);
            cnt++;
        }
    }

    invertido = "";
    for ( i=(dtexto.length-1),j=0; i>=0; i--,j++ )
        invertido = invertido + dtexto.charAt(i);


    if ( revisarDigito2(texto) )
        $('#'+nombre_campo).val(invertido.toUpperCase());
}

function ToastError(Contenido){
    QuitarFondoToast();
    $('#ToastBody').html(Contenido)
    $("#Toaster").addClass("bg-danger").addClass("text-white");
    $('#Toaster').toast("show");
}

function ValidarRequeridos(clase)
{
    var requeridos = 0;
    $('.'+clase).each(function(index, element){
        if( element.value.length==0 ) {
            element.classList.add("is-invalid");
            requeridos++;
        }
        else {
            element.classList.remove("is-invalid");
        }
    });
    if(requeridos>0) {
        ToastFaltaInformacion();
    }
    return requeridos;
}

function ToastFaltaInformacion(){
    QuitarFondoToast();
    $('#ToastBody').html('DEBE INGRESAR TODA LA INFORMACIÓN SOLICITADA')
    $("#Toaster").addClass("bg-danger").addClass("text-white");
    $('#Toaster').toast("show");
}

function QuitarFondoToast(){
    $("#Toaster").removeClass("bg-danger").removeClass("text-white");
    $("#Toaster").removeClass("bg-success").removeClass("text-white");
    $("#Toaster").removeClass("bg-warning").removeClass("text-white");
}

function ToastRutInvalido(){
    QuitarFondoToast();
    $('#ToastBody').html('EL RUT INGRESADO NO ES VÁLIDO')
    $("#Toaster").addClass("bg-danger").addClass("text-white");
    $('#Toaster').toast("show");
}

function ToastSessionExpirada(){
    QuitarFondoToast();
    $('#ToastBody').html('LA SESSIÓN ESTÁ EXPIRADA')
    $("#Toaster").addClass("bg-danger").addClass("text-white");
    $('#Toaster').toast("show");
}

function ToastInformacionActualizada(){
    QuitarFondoToast();
    $('#ToastBody').html('INFORMACIÓN ACTUALIZADA CORRECTAMENTE')
    $("#Toaster").addClass("bg-success").addClass("text-white");
    $('#Toaster').toast("show");
    setTimeout(function(){location.reload()}, 250);
}

function ToastInformacionEliminada(){
    QuitarFondoToast();
    $('#ToastBody').html('INFORMACIÓN ELIMINADA CORRECTAMENTE')
    $("#Toaster").addClass("bg-success").addClass("text-white");
    $('#Toaster').toast("show");
    setTimeout(function(){location.reload()}, 250);
}

function ToastInformacionGuardada(){
    QuitarFondoToast();
    $('#ToastBody').html('INFORMACIÓN GUARDADA CORRECTAMENTE')
    $("#Toaster").addClass("bg-success").addClass("text-white");
    $('#Toaster').toast("show");
    setTimeout(function(){location.reload()}, 250);
}

function ValidarCaracteres(campo){
    $('#'+campo).val( $('#'+campo).val().replace(/'/g, '').replace(/"/g, '') );
}
$(document).ready(function() {

    /*
    $('.single-select').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
    });
    */

});


function revisarDigito( dvr )
{
	var CopiaRut = dvr;
	dv = dvr + ""
	if ( dv != '0' && dv != '1' && dv != '2' && dv != '3' && dv != '4' && dv != '5' && dv != '6' && dv != '7' && dv != '8' && dv != '9' && dv != 'k'  && dv != 'K')
	{
		return false;
	}
	return true;
}

function revisarDigito2( crut )
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

function ValidateRut (texto)
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

function RutDigito (rut)
{
	if (!rut || !rut.length || typeof rut !== 'string') {
		return -1;
	}
	// serie numerica
	var secuencia = [2,3,4,5,6,7,2,3];
	var sum = 0;
	//
	for (var i=rut.length - 1; i >=0; i--) {
		var d = rut.charAt(i)
		sum += new Number(d)*secuencia[rut.length - (i + 1)];
	};
	// sum mod 11
	var rest = 11 - (sum % 11);
	// si es 11, retorna 0, sino si es 10 retorna K,
	// en caso contrario retorna el numero
	return rest === 11 ? 0 : rest === 10 ? "K" : rest;
}

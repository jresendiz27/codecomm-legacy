
/*AJAX*/
//
//
//
//
//
var xmlhttp;
var object;

function valmethod(method)
{
	if (method != "GET" && method != "POST")
	{
		return "GET";
	}
	else
	{
		return method;
	}
}

function loadXMLDoc(url, params, method, newobject)
{
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
		object = newobject;
		xmlhttp.onreadystatechange=stateChange;
		method = valmethod(method);
		if (method == "GET")
		{
			xmlhttp.open(method,url+"?"+params,true);
			xmlhttp.send(null);
		}
		else if (method == "POST")
		{
			
			xmlhttp.open(method, url, true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.setRequestHeader("Content-length", params.length);
			xmlhttp.setRequestHeader("Connection", "close");
			xmlhttp.send(params);
		}
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.onreadystatechange=stateChange;
		method = valmethod(method);
		if (method == "GET")
		{
			xmlhttp.open(method,url+params,true);
			xmlhttp.send();
		}
		else if (method == "POST")
		{
			xmlhttp.open(method, url, true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.setRequestHeader("Content-length", params.length);
			xmlhttp.setRequestHeader("Connection", "close");
			xmlhttp.send(params);
		}
	}
}

function stateChange()
{
	if (xmlhttp.readyState==4)
	{
		if (xmlhttp.status==200)
		{// process whatever has been sent back here
			document.getElementById(object).innerHTML=xmlhttp.responseText;
		}
		else
		{
			document.getElementById(object).innerHTML="Error al intentar actualizar la informaci&oacute;n. Verifique su conexi&oacute;n a internet.";
		}
	}
}

//
//
//
//
//
/*AJAX*/


function sendCode()
{
	str = document.getElementById("txt").value;
	//str = str.replace(/!/g,"%21");
	//str = str.replace(/\*/g,"%2A");
	//str = str.replace(/'/g,"%27");
	//str = str.replace(/\(/g,"%28");
	//str = str.replace(/\)/g,"%29");
	//str = str.replace(/;/g,"%3B");
	//str = str.replace(/@/g,"%40");
	//str = str.replace(/\+/g,"%2B");
	//str = str.replace(/$/g,"%24");
	//str = str.replace(/\//g,"%2F");
	//str = str.replace(/\?/g,"%3F");
	//str = str.replace(/%/g,"%25");
	//str = str.replace(/\[/g,"%5B");
	//str = str.replace(/\]/g,"%5D");
	str = encodeURI(str);
	str = str.replace(/&/g,"%26");
	str = str.replace(/#/g,"%23");
	str = str.replace(/\n/g,"%0A");
	if (document.getElementById("bb").checked) {
		str = str + "&bb=bb";
	}
	if (document.getElementById("existc").checked){
		str = str + "&exist=exist";
		
	}
	loadXMLDoc ('preview.php', 'txt=' + str, 'POST', 'preview');
}

function focusito()
{


document.getElementById("txt").focus();

}

function writemap() {
	document.write (
	"<table border=\"0\">\n" +
                  "<tr>\n" +
                    "<td height=\"36\">\n" +
                  "<img src=\"b_btn.gif\" alt=\"Negritas\" onclick=\"negrita()\"></td>\n" +
                    "<td><img src=\"i_btn.gif\" alt=\"Cursiva\" onClick=\"cursiva()\"></td>\n" +
                    "<td><img src=\"u_btn.gif\" alt=\"Subrayado\" onClick=\"subrayado()\"></td>\n" +
                    "<td><img src=\"cros_btn.gif\" alt=\"Tachado\" width=\"30\" height=\"30\" onClick=\"tachado()\"></td>\n" +
                    "<td><img src=\"hid_btn.GIF\" alt=\"Oculto\" width=\"30\" height=\"30\" onClick=\"oculto()\"></td>\n" +
                    "<td><img src=\"size_btn.gif\" alt=\"Tamaño\" width=\"30\" height=\"30\" onClick=\"tamano()\"></td>\n" +
                    "<td><img src=\"code_btn.gif\" alt=\"Código\" width=\"50\" height=\"30\" onClick=\"codigo()\"></td>\n" +
                    "<td><img src=\"img_btn.gif\" alt=\"Im&aacute;genes\" width=\"30\" height=\"30\" onClick=\"img()\"></td>\n" +
                    "<td><img src=\"link_btn.gif\" alt=\"Vinculos\" width=\"30\" height=\"30\" onClick=\"url()\"></td>\n" +
                    "<td><img src=\"vid_btn.gif\" alt=\"Videos\" width=\"30\" height=\"30\" onClick=\"youtube()\"></td>\n" +
                  "</tr>\n" +
                  "<tr>\n" +
                  "<td colspan=\"12\"><center><img src=\"colors.jpg\" alt=\"Colores\" border=\"0\" usemap=\"#MapMap\"></center>\n" +
                    "<map name=\"MapMap\">\n" +
                      "<area shape=\"rect\" coords=\"1,1,13,12\" alt=\"Fiusha\" onClick=\"fiusha();\">\n" +
                      "<area shape=\"rect\" coords=\"1,17,13,30\" alt=\"Purple\" onClick=\"purple();\">\n" +
                      "<area shape=\"rect\" coords=\"17,1,29,12\"  alt=\"Gray\" onClick=\"gray();\">\n" +
                      "<area shape=\"rect\" coords=\"17,17,29,29\"  alt=\"Blue\" onClick=\"blue();\">\n" +
                      "<area shape=\"rect\" coords=\"32,1,45,14\"  alt=\"Steelblue\" onClick=\"steelblue();\">\n" +
                      "<area shape=\"rect\" coords=\"33,17,45,29\"  alt=\"RoyalBlue\" onClick=\"royalblue();\">\n" +
                      "<area shape=\"rect\" coords=\"48,0,61,13\"  alt=\"LightBlue\" onClick=\"lightblue();\">\n" +
                      "<area shape=\"rect\" coords=\"49,18,61,29\"  alt=\"DodgerBlue\" onClick=\"dodgerblue();\">\n" +
                      "<area shape=\"rect\" coords=\"64,1,78,15\"  alt=\"OliveDrab\" onClick=\"olivedrab();\">\n" +
                      "<area shape=\"rect\" coords=\"65,17,77,29\"  alt=\"Green\" onClick=\"green();\">\n" +
                      "<area shape=\"rect\" coords=\"80,0,94,16\"  alt=\"PaleGreen\" onClick=\"palegreen();\">\n" +
                      "<area shape=\"rect\" coords=\"80,16,94,30\"  alt=\"YellowGreen\" onClick=\"yellowgreen();\">\n" +
                      "<area shape=\"rect\" coords=\"95,0,110,15\"  alt=\"AntiqueWhite\" onClick=\"antiquewhite();\">\n" +
                      "<area shape=\"rect\" coords=\"97,16,111,30\"  alt=\"Yellow\" onClick=\"yellow();\">\n" +
                      "<area shape=\"rect\" coords=\"111,0,127,16\"  alt=\"LightGoldenrodYellow\" onClick=\"lightgoldenrodyellow();\">\n" +
                      "<area shape=\"rect\" coords=\"111,16,127,30\"  alt=\"Gold\" onClick=\"gold();\">\n" +
                      "<area shape=\"rect\" coords=\"128,1,142,16\"  alt=\"LightSalmon\" onClick=\"lightsalmon();\">\n" +
                      "<area shape=\"rect\" coords=\"129,16,142,28\"  alt=\"Orange\" onClick=\"orange();\">\n" +
                      "<area shape=\"rect\" coords=\"145,1,159,15\"  alt=\"Pink\" onClick=\"pink();\">\n" +
                      "<area shape=\"rect\" coords=\"145,16,158,29\"  alt=\"Red\" onClick=\"red();\">\n" +
                      "<area shape=\"rect\" coords=\"159,1,175,15\"  alt=\"Brown\" onClick=\"brown();\">\n" +
                      "<area shape=\"rect\" coords=\"161,16,173,30\"  alt=\"DarkRed\" onClick=\"darkred();\">\n" +
                      "<area shape=\"rect\" coords=\"177,2,190,15\"  alt=\"DarkGray\" onClick=\"darkgray();\">\n" +
                      "<area shape=\"rect\" coords=\"177,17,190,28\"  alt=\"DimGray\" onClick=\"dimgray();\">\n" +
                      "<area shape=\"rect\" coords=\"192,1,207,15\"  alt=\"LightGray\" onClick=\"lightgray();\">\n" +
                      "<area shape=\"rect\" coords=\"193,16,206,30\"  alt=\"DarkSlateGray\" onClick=\"darkslategray();\">\n" +
                      "<area shape=\"rect\" coords=\"208,1,223,16\"  alt=\"White\" onClick=\"white();\">\n" +
                      "<area shape=\"rect\" coords=\"209,16,221,29\"  alt=\"Black\" onClick=\"black();\">\n" +
                    "</map></td>\n" +
                  "</tr>\n" +
                "</table>"
		);
}
function escribe()
	{
	var txtarea;
	txtarea=document.mpost.txt.value;
	var ifrDocument=document.getElementById('main').contentDocument || document.getElementById('main').contentWindow.document;
    var ifrBody=ifrDocument.getElementsByTagName('body')[0];
    //agregar algo adelante:
    ifrBody.innerHTML=txtarea;
    //para agregar detrás: ifrBody.innerHTML+='lo que sea';  
	}
var navegador=navigator.userAgent;//obtengo el navegador
//los siguientes devuelven solo true o false
var explorer=/msi/i.test(navegador);
var opera=/opera/i.test(navegador);
var firefox=/gecko/i.test(navegador);
var otro=!(explorer||firefox);
var insertor,insertar,formulario,texto,lector="";
//van las funciones
function datos_ie()
	{
	texto=document.selection.createRange().text;
	if (formulario.createTextRange)
		formulario.posi = document.selection.createRange().duplicate();
	return true;
	}
function captura_ie()	
	{
	return texto;
	}
function captura_mo() 
	{
	with (formulario) 
	return value.substring(selectionStart, selectionEnd);	
	}
function captura_otro()	
	{
	return "";
	}
function poner_mo(f, x)	
	{
	var ini = f.selectionStart;//inicio de rango de seleccion
	var fin = f.selectionEnd;//fin del rango de seleccion
	var inicio = f.value.substr(0,ini);//se divide la cadena
	var fin = f.value.substr(fin, f.value.length);//se divide la cadena
	
	f.value = inicio + x + fin;
	if (ini == fin)	
		{
		f.selectionStart = inicio.length + x.length;
		f.selectionEnd = f.selectionStart;
		}
	else
		{
		f.selectionStart = inicio.length;
		f.selectionEnd = inicio.length + x.length;
		}
	f.focus();
	}
function poner_otro(f, x)	
	{// opera u otros navegadores desconocidos
	f.value += x;
	f.focus();
	}
function poner_ie(f, x)	
	{
	f.focus();
	if (f.createTextRange)	
		{
		if (!f.posi)	
			datos_ie();
		with(f)	
			{
			var actuar = (posi.text == "");
			posi.text = x;
			if (!actuar)
				posi.moveStart("character", -x.length);
			posi.select();
			}
		}
	}
function ini_editor(formu)	
	{
	formulario = formu;
	
	if (opera || firefox)	
		{
		insertar = function(f, x) {poner_mo(f, x);};
		lector = captura_mo;
		}	

	else if (otro)	
		{
		insertar = function(f, x) {poner_otro(f, x);};
		lector = captura_otro;
		}

	else if (explorer)	
		{
		formulario.onchange = datos_ie;
		formulario.onclick  = datos_ie;
		insertar = function(f, x) {poner_ie(f, x);};
		lector = captura_ie;
		}
	return formu;
	}
/*
*
*veamos k desmadre va aki!
*
*/
	var elEditor;	// declaración necesaria para el funcionamiento de la librería editor.js

			// simple ejemplo de inserción dentro de un textarea
			//texto en negritas
			function negrita()	
			{
				if(lector().length==0)
				{
				insertar(elEditor, '[b]' + 'texto' + '[/b]');
				}
				else
				{
				insertar(elEditor, '[b]' + lector() + '[/b]');
				}
                        sendCode();
			}
			//cursiva
			function cursiva()	
			{
				if(lector().length==0)
				{
				insertar(elEditor, '[i]' + 'texto' + '[/i]');
				}
				else
				{
				insertar(elEditor, '[i]' + lector() + '[/i]');
				}
                        sendCode();
			}
			//subrayado
			function subrayado()	
			{
				if(lector().length==0)
				{
				insertar(elEditor, '[u]' + 'texto' + '[/u]');
				}
				else
				{
				insertar(elEditor, '[u]' + lector() + '[/u]');
				}
                        sendCode();
			}
			//texto tachado
			function tachado()	
			{
				if(lector().length==0)
				{
				insertar(elEditor, '[s]' + 'texto' + '[/s]');
				}
				else
				{
				insertar(elEditor, '[s]' + lector() + '[/s]');
				}
                        sendCode();
			}
			//texto oculto
			function oculto()	
			{
				if(lector().length==0)
				{
				insertar(elEditor, '[spoiler]' + 'texto' + '[/spoiler]');
				}
				else
				{
				insertar(elEditor, '[spoiler]' + lector() + '[/spoiler]');
				}
                        sendCode();
			}
			//tamaño del texto
			function tamano()	
			{
				if(lector().length==0)
				{
				insertar(elEditor, '[size=\"porcentaje\"]' + 'texto' + '[/size]');
				}
				else
				{
				insertar(elEditor, '[size=\"porcentaje\"]' + lector() + '[/size]');
				}
                        sendCode();
			}
			//texto para codigos
			function codigo()	
			{
				if(lector().length==0)
				{
				insertar(elEditor, '[code]' + 'texto' + '[/code]');
				}
				else
				{
				insertar(elEditor, '[code]' + lector() + '[/code]');
				}
                        sendCode();
			}
			//texto para imagenes
			function img()	
			{
				if(lector().length==0)
				{
				insertar(elEditor, '[img]' + 'vinculo' + '[/img]');
				}
				else
				{
				insertar(elEditor, '[img]' + lector() + '[/img]');
				}
                        sendCode();
			}
			//texto para vinculos
			function url()	
			{
				if(lector().length==0)
				{
				insertar(elEditor, '[url=\"vinculo\"]' + 'texto' + '[/url]');
				}
				else
				{
				insertar(elEditor, '[url=\"vinculo\"]' + lector() + '[/url]');
				}
                        sendCode();
			}
			//texto para videos de iotevi
			function youtube()	
			{
				if(lector().length==0)
				{
				insertar(elEditor, '[youtube="vinculo"]');
				}
				else
				{
				insertar(elEditor, '[youtube=\"vinculo\"' + lector() + ']');
				}
                        sendCode();
			}
/*
para los colores
*/
function fiusha()
	{
		if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#DA70D6\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#DA70D6\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function purple()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#800080\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#800080\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function gray()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#808080\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#808080\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function blue()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#0000FF\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#0000FF\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function steelblue()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#4682B4\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#4682B4\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function royalblue()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#4169E1\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#4169E1\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function lightblue()
	{
	var b="[color=\"#ADD8E6\"][/color]\n";
	document.mpost.txt.value+=b;
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#ADD8E6\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#ADD8E6\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function dodgerblue()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#1E90FF\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#1E90FF\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function olivedrab()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#6B8E23\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#6B8E23\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function green()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#008000\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#008000\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function palegreen()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#98FB98\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#98FB98\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function yellowgreen()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#9ACD32\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#9ACD32\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function antiquewhite()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#FAEBD7\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#FAEBD7\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function yellow()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#FFFF00\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#FFFF00\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function lightgoldenrodyellow()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#FAFAD2\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#FAFAD2\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function gold()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#FFD700\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#FFD700\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function lightsalmon()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#FFA07A\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#FFA07A\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function orange()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#FF4500\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#FF4500\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function pink()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#FFC0CB\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#FFC0CB\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function red()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#FF0000\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#FF0000\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function brown()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#8B4513\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#8B4513\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function darkred()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#8B0000\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#8B0000\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function darkgray()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#A9A9A9\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#A9A9A9\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function dimgray()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#696969\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#696969\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function lightgray()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#D3D3D3\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#D3D3D3\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function darkslategray()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#2F4F4F\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#2F4F4F\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function white()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#FFFFFF\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#FFFFFF\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
function black()
	{
	if(lector().length==0)
			{
			insertar(elEditor, '[color=\"#000000\"]'+'texto'+'[/color]');
			}
		else
			{
			insertar(elEditor, '[color=\"#000000\"]' + lector() + '[/color]');
			}
                        sendCode();
	}
/*
*
*
*para redimensionar imagenes
*
*/
//**/

function resize_img(id)
{
//http://halowiki.net/images/thumb/8/8c/H3_promo_banner.jpg/1000px-H3_promo_banner.jpg
//var x=document.getElementsByTagName(tag)
	if((document.getElementById(id).width>800))
		{
		var percent=0.90;
		do
		  {
		  var new_width=Math.round(document.getElementById(id).width*percent);
		  //alert(percent+" porcentaje "+new_width+" nuevo valor del ancho");
		  var new_height=Math.round(document.getElementById(id).height*percent);
		  //alert(percent+" porcentaje "+new_height+" nuevo valor del alto");
		  document.getElementById(id).width=new_width;
		  document.getElementById(id).height=new_height;
		  //document.getElementById(id).id="img"+i;
		  percent-=0.05;
		  }
		while(document.getElementById(id).width>800);
		document.getElementById(id).style.visibility='visible';
		}
	else
		{
		document.getElementById(id).style.visibility='visible';
		}
}

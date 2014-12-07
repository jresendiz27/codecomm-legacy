<?php
function bienvenida()
	{

		$saludo1=" ";

		$days=array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
		$dias=array("Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");

		$meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$months=array("January","February","March","April","May","June","July","August","September","October","November","December");

		$dia_sistema=date("l");
		$dia_numero="<b>".date("d")."</b>";
		$mes_sistema=date("F");
		$ano="<b>".date("Y")."</b>";

		$hora=date("H");

		if($hora>=0 and $hora<=12)
		{
			$saludo="<b>Buenos Dias</b>";
		}
		else if($hora>12 and $hora<18)
		{
			$saludo="<b>Buenas Tardes</b>";
		}
		else
		{
			$saludo="<b>Buenas Noches</b>";
		}
	
		for($i=0;$i<sizeof($months);$i++)
		{
			if($mes_sistema==$months[$i])
			{
				$mes_sistema="<b>".$meses[$i]."</b>";
			}
		}
		for($o=0;$o<sizeof($days);$o++)
		{
			if($dia_sistema==$days[$o])
			{
				$dia_sistema="<b>".$dias[$o]."</b>";
			}
		}
		echo "<p class=\"date\" align=\"center\">\t".$saludo."\t\t\t\t\tHoy nos encontramos a\t".$dia_sistema."\t".$dia_numero."\tde\t".$mes_sistema."\tde\t".$ano."</p>";
	}
?>

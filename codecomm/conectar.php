<?php
	if (!function_exists(conectar)) {
	function conectar() {
		// Realizamos conexión a la base de datos guardando el valor del vínculo en una variable
		$vinculoactual = mysql_connect("mysqldatabase","user","password");
		// Si ese valor es falso entonces no se pudo realizar y devolvemos -1
		if (!$vinculoactual) {
			return -1;
		}
		// Si no podemos seleccionar base de datos...
		if (!mysql_select_db("mysqldatabase",$vinculoactual)) {
			return -1;
		}
		// Regresamos el valor de la conexión, necesario para acceder a la base de datos
		return $vinculoactual; 
	}
	}
?>
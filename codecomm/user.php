<?php
	// Incluimos la libreria "conectar.php"
	include "conectar.php";
	
	// Iniciamos sesión
	session_start();
	
	// Conexión a base de datos:
	$vinculo = conectar();
	
	// Si enviamos el valor de que queríamos cerrar sesión
	if (isset($_GET["logout"])) {
		unset($_SESSION["user"]);
	}
	// Si el botón es apretado, fijamos como valores de la sesión los valores de cajas de textos
	else if (isset($_POST["login"])) {
		$_SESSION["user"] = stripslashes(trim($_POST["user"]));
		$_SESSION["pass"] = stripslashes(trim($_POST["pass"]));
	}
	// Si el valor de la sesión (el de usuario) no existe, lo ponemos como cadena vacia
	if (!isset($_SESSION["user"])) {
		$_SESSION["user"] = "";
		$_SESSION["pass"] = "";
	}
	
	// Checamos si el usuario existe:
	$user = $_SESSION["user"];
	$pass = $_SESSION["pass"];
	$result = mysql_query("SELECT * FROM MUsuario WHERE nom_user = '$user' AND pass_user = '$pass'", $vinculo);
	// Si no existe, borramos las variables de sesión
	if (mysql_num_rows($result) != 1) {
		unset($_SESSION["user"], $_SESSION["pass"]);
	}
?>
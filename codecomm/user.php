<?php
	// Incluimos la libreria "conectar.php"
	include "conectar.php";
	
	// Iniciamos sesi�n
	session_start();
	
	// Conexi�n a base de datos:
	$vinculo = conectar();
	
	// Si enviamos el valor de que quer�amos cerrar sesi�n
	if (isset($_GET["logout"])) {
		unset($_SESSION["user"]);
	}
	// Si el bot�n es apretado, fijamos como valores de la sesi�n los valores de cajas de textos
	else if (isset($_POST["login"])) {
		$_SESSION["user"] = stripslashes(trim($_POST["user"]));
		$_SESSION["pass"] = stripslashes(trim($_POST["pass"]));
	}
	// Si el valor de la sesi�n (el de usuario) no existe, lo ponemos como cadena vacia
	if (!isset($_SESSION["user"])) {
		$_SESSION["user"] = "";
		$_SESSION["pass"] = "";
	}
	
	// Checamos si el usuario existe:
	$user = $_SESSION["user"];
	$pass = $_SESSION["pass"];
	$result = mysql_query("SELECT * FROM MUsuario WHERE nom_user = '$user' AND pass_user = '$pass'", $vinculo);
	// Si no existe, borramos las variables de sesi�n
	if (mysql_num_rows($result) != 1) {
		unset($_SESSION["user"], $_SESSION["pass"]);
	}
?>
<?php
	function dummysession() {
	}
	session_start();
	if ($_GET["close"] == 1) {
		unset($_SESSION["user"], $_SESSION["pass"]);
	}
	else if (isset($_POST["login"]))
	{
		$_SESSION["loginatt"] = true;
		$_SESSION["user"]=stripslashes(trim($_POST["user"]));
		$_SESSION["pass"]=hash("sha256", "enc".strtoupper(stripslashes(trim($_POST["user"]))).stripslashes($_POST["pass"]));
	}
	$user = mysql_real_escape_string($_SESSION["user"]);
	$pass = mysql_real_escape_string($_SESSION["pass"]);
	$result = mysql_query("SELECT * FROM MUsuario WHERE UPPER(nick_user) = UPPER('$user') AND pass_user = '$pass'", $vinculo);
	echo mysql_error();
	if (mysql_num_rows($result) != 1) {
		unset($_SESSION["user"], $_SESSION["pass"]);
		if (isset ($_SESSION["loginatt"])) {
			header ("Location: loginerr.php");
		}
	}
	else {
		unset ($_SESSION["loginatt"]);
		$fila = mysql_fetch_array($result);
		$tipo_user = $fila["id_tipo"];
		$_SESSION["user"] = $fila["nick_user"];
		$id_comment = $fila["id_user"];
		$id_my_user = $fila["id_user"];
		if ($tipo_user == 4) {
			$_SESSION["pass"] = "";
			header ("Location: ban.php");
		}
		else if (isset($fila["fecban_user"])){
			date_default_timezone_set("UTC");
			$fecha = date("Y-m-d H:i:s");
			$fechadiv1 = preg_split("#[ :\-]#", $fila["fecban_user"]);
			$fechadiv2 = preg_split("#[ :\-]#", $fecha);
			$tiempo1 = mktime ($fechadiv1[3], $fechadiv1[4], $fechadiv1[5], $fechadiv1[1], $fechadiv1[2], $fechadiv1[0]);
			$tiempo2 = mktime ($fechadiv2[3], $fechadiv2[4], $fechadiv2[5], $fechadiv2[1], $fechadiv2[2], $fechadiv2[0]);
			if (($tiempo2 - $tiempo1) < (60*60*24*28)) {
				$_SESSION["fecha"] = (60*60*24*28) - ($tiempo2 - $tiempo1);
				$_SESSION["pass"] = "";
				header ("Location: ban.php");
			}
		}
	}
	
?>

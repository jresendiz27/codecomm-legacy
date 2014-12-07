<?php 
	session_start();
	if (isset ($_SESSION["loginatt"])) {
		unset ($_SESSION["loginatt"]);
	}
	else {
		header ("Location: index.php");
	}
	include "header.php";
?>
<td>Error en el login. Si olvidaste tu contraseña, todavía puedes <a href="password.php">recuperarla.</a></td></tr></table>
<?php include "foot.php" ?>
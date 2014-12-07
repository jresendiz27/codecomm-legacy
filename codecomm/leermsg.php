<?php
	include ("header.php");
	include ("postlib.php");
?>
<td valign="top">
		<h2>Mensajes</h2>
<?php if (isset($_GET["id"])) {
		$id = intval($_GET["id"]);
	}
	else {
		$id = 0;
	}
	if ($id > 0) {
		mysql_query ("SET NAMES 'utf8'");
		$user = $_SESSION["user"];
		$fila = mysql_fetch_array(mysql_query("SELECT * FROM MUsuario WHERE UPPER(nick_user) = '$user'", $vinculo));
		$id_user = $fila["id_user"];
		$result = mysql_query("SELECT * FROM EMensaje WHERE id_user = $id_user AND id_msg = $id", $vinculo);
		echo mysql_error();
		if ($fila = mysql_fetch_array($result)) {
			// Mensaje que enviaste
			echo "<p><b><i>Asunto</i>: ".htmlspecialchars($fila["nom_msg"], ENT_COMPAT, 'UTF-8')."</b></p>";
			echo "<p>Destinatarios:</p>";
			$result = mysql_query ("SELECT * FROM DMensaje NATURAL JOIN MUsuario WHERE id_msg = $id", $vinculo);
			while ($filauser = mysql_fetch_array($result)) {
				echo "<p>".htmlspecialchars($filauser["nick_user"])."</p>";
			}
			echo "<p>".replacebb($fila["limpbb_msg"], !$fila["verbb_msg"], "\t\t", $fila["cuerpo_msg"])."</p>";
		}
		else {
			// Mensaje que recibiste
			$result = mysql_query("SELECT * FROM EMensaje JOIN DMensaje ON EMensaje.id_msg = DMensaje.id_msg WHERE DMensaje.id_user = $id_user AND EMensaje.id_msg = $id", $vinculo);
			if ($fila = mysql_fetch_array($result)) {
				if (isset($_POST["delete"])) {
					mysql_query("DELETE FROM DMensaje WHERE id_msg = $id AND id_user = $id_user");
					echo "<p>El mensaje ha sido borrado satisfactoriamente</p>";
				}
				else {
					$filauser = mysql_fetch_array(mysql_query("SELECT * FROM EMensaje NATURAL JOIN MUsuario WHERE id_msg = $id", $vinculo));
					echo "<p><b><i>Asunto</i>: ".htmlspecialchars($fila["nom_msg"], ENT_COMPAT, 'UTF-8')."</b></p>";
					echo "<p>De: ".htmlspecialchars($filauser["nick_user"])."</p>";
					echo "<p>".replacebb($fila["limpbb_msg"], !$fila["verbb_msg"], "\t\t", $fila["cuerpo_msg"])."</p>";
					echo "<form action=\"leermsg.php?id=".$id."\" method=\"post\"><p><input type=\"submit\" name=\"delete\" value=\"Borrar Mensaje\"/> Una vez borrado, no se puede recuperar.</p></form>";
					mysql_query("UPDATE DMensaje SET leido_msg = true WHERE id_msg = '$id' AND id_user = '$id_my_user'", $vinculo);
				}
			}
			else {
				echo ("ID Incorrecto. El mensaje no te pertenece.");
			}
		}
	}
	else {
		echo "No se ha seleccionado un mensaje.";
	}
?>
	</td></tr></table>
<?php include "foot.php" ?>

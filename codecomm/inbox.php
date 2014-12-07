<td valign="top">
		<h2>Bandeja de entrada</h2>
		<table align="center" width="700" border="1">
			<tr>
				<th>Asunto</th>
				<th>Usuario</th>
				<th>Fecha</th>
			</tr>
<?php
	$user = $_SESSION["user"];
	$fila = mysql_fetch_array(mysql_query("SELECT * FROM MUsuario WHERE UPPER(nick_user) = '$user'", $vinculo));
	$id_user = $fila["id_user"];
	$result = mysql_query("SELECT * FROM EMensaje JOIN DMensaje ON EMensaje.id_msg = DMensaje.id_msg WHERE DMensaje.id_user = $id_user", $vinculo);
	echo mysql_error();
	while ($fila = mysql_fetch_array($result)) {
		$id_msg = $fila["id_msg"];
		$filauser = mysql_fetch_array(mysql_query("SELECT * FROM MUsuario NATURAL JOIN EMensaje WHERE id_msg = $id_msg", $vinculo));
		$nick_user = $filauser["nick_user"];
		if ($fila["leido_msg"]) {
			echo "<tr><td><a class=\"amigos\"href=\"leermsg.php?id=".$id_msg."\">\"".$fila["nom_msg"]."\"</a></td><td align=\"center\" width=\"150\">".$nick_user."</td><td align=\"center\" width=\"180\"><span style=\"font-size:80%\">".$fila["fec_msg"]." UTC</span></td></tr>";
		}
		else {
			echo "<tr><td><a class=\"amigos\" href=\"leermsg.php?id=".$id_msg."\">\"".$fila["nom_msg"]."\" (Nuevo)</a><td align=\"center\" width=\"150\">".$nick_user."</td><td align=\"center\" width=\"180\"><span style=\"font-size:80%\">".$fila["fec_msg"]." UTC</span></td></tr>";
		}
	}
?>
		</table>
	</td></tr></table>
<?php include "foot.php" ?>
	<td valign="top">
		<table align="center" width="700" border="1">
			<tr>
				<td>Asunto</td>
				<td>Fecha</td>
			</tr>
<?php
	$user = $_SESSION["user"];
	$fila = mysql_fetch_array(mysql_query("SELECT * FROM MUsuario WHERE UPPER(nick_user) = '$user'", $vinculo));
	$id_user = $fila["id_user"];
	$result = mysql_query("SELECT * FROM EMensaje WHERE id_user = $id_user", $vinculo);
	echo mysql_error();
	while ($fila = mysql_fetch_array($result)) {
		echo "<tr><td><a class=\"amigos\" href=\"leermsg.php?id=".$fila["id_msg"]."\">".$fila["nom_msg"]."</td><td align=\"center\" width=\"180\"><span style=\"font-size:inherit;\">".$fila["fec_msg"]."</span></tr>";
	}
?>
	</td></tr></table>
<?php include "foot.php" ?>
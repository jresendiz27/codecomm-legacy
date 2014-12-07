<?php
	include ("header.php");
	include ("postlib.php");
?>
		<td valign="top">
			<table border="1" width="359">
				<tr><th colspan="2">Noticias CodeComm</th></tr>
<?php
	$result = mysql_query("SELECT * FROM MPost WHERE id_sub = 2 ORDER BY fec_post DESC", $vinculo);
	$num = 0;
	while (($fila = mysql_fetch_array($result)) && ($num < 3)) {
		print "<tr><td><a href=\"verpost.php?id=".$fila["id_post"]."\">".$fila["nom_post"]."</a></td><td><span style=\"font-size:65%\">".$fila["fec_post"]." UTC</span></td></tr>";
		print "<tr><td colspan=\"2\"><span style=\"font-size:85%\">"
			.preg_replace("#&aacute;([\w\W]*?)&eacute;#u", "<$1>" , preg_replace("#<[\w\W]*#u", "", preg_replace("#<([\w\W]*?)>#u", "&aacute;$1&eacute;", substr(replacebb(true, true, "", $fila["cuerpo_post"]), 0, 200))))
			."... <a href=\"verpost.php?id=".$fila["id_post"]."\">Mas+</a></span></td></tr>";
		$num++;
	}
?>
			</table>
		</td>
		<td valign="top">
			<table border="1" width="350">
				<tr><th colspan="2">Posts Recientes</th></tr>
<?php
	$result = mysql_query("SELECT * FROM MPost NATURAL JOIN MUsuario ORDER BY fec_post DESC", $vinculo);
	$num = 0;
	while (($fila = mysql_fetch_array($result)) && ($num < 5)) {
		print "<tr><td colspan=\"2\"><a href=\"verpost.php?id=".$fila["id_post"]."\">".$fila["nom_post"]."</a></td></tr><tr><td><span style=\"font-size:85%\">".$fila["nick_user"]."</span></td><td><span style=\"font-size:65%\">".$fila["fec_post"]." UTC</span></td></tr>";
		$num++;
	}
?>		
			</table>
		</td>
	</tr></table>
	</body>
</html>
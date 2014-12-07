<?php
	include "header.php";
?>
<td valign="top">
<?php
	if (isset($_GET["sub"])) {
		$id = intval($_GET["sub"]);
		$result = mysql_query("SELECT * FROM CSubcategoria WHERE id_sub = $id");
		if (mysql_num_rows($result) != 1) {
		?>
			No existe subcategoria</td>
		</tr>
<?php
		}
		else { 
			$limit = 20;
			print "<table>";
			$fila = mysql_fetch_array($result);
			print "<tr><td width=\"250\" valign=\"bottom\"><span style=\"font-size:150%;\">".$fila["nom_sub"]."</span></td><td valign=\"bottom\"><span>".$fila["des_cat"]."</span></td></tr>";
			print "</table><table border=\"1\"><tr><th>Usuario</th><th>Nombre del post</th><th width=\"180\">Fecha</th></tr>";
			// Recordar ordenar por prioridad y fecha
			$result = mysql_query("SELECT * FROM MPost NATURAL JOIN MUsuario WHERE id_sub = $id");
			$cant = ceil (mysql_num_rows($result) / $limit);
			$actpage = intval($_GET["page"]);
			if (($actpage < 1) || ($actpage > $cant)) {
				$actpage = 1;
			}
			$poststart = ($actpage - 1) * $limit;
			$result = mysql_query("SELECT * FROM MPost NATURAL JOIN MUsuario WHERE id_sub = $id ORDER BY prior_post DESC, fec_post DESC LIMIT $poststart, $limit");
			$post = array();
			while ($fila = mysql_fetch_array($result)) {
				$post[count($post)] = $fila;
			}
			foreach ($post as $elem) {
				print "<tr><td><a href=\"perfil.php?nick=".htmlspecialchars($elem["nick_user"], ENT_COMPAT, 'UTF-8')."\">".htmlspecialchars($elem["nick_user"], ENT_COMPAT, 'UTF-8')."</a></td><td><a href=\"verpost.php?id=".$elem["id_post"]."\">".htmlspecialchars($elem["nom_post"], ENT_COMPAT, 'UTF-8')."</a></td><td><span style=\"font-size:80%\">".$elem["fec_post"]." UTC</span></td></tr>";
				unset($sub);
			}
			print "</table>";
			print "<p align=\"right\">";
			$firstpage = $actpage - 3;
			$lastpage = $actpage + 3;
			if ($firstpage < 1) {
				$firstpage = 1;
			}
			else if ($firstpage == 2) {
				print "<a href=\"vercat.php?sub=".$id."&page=1\">1</a> ";
			}
			else if ($firstpage != 1){
				print "<a href=\"vercat.php?sub=".$id."&page=1\">1</a> ... ";
			}
			if ($lastpage > $cant) {
				$lastpage = $cant;
			}
			for ($i = $firstpage; $i <= $lastpage; $i++) {
				print "<a href=\"vercat.php?sub=".$id."&page=".$i."\">".$i."</a> ";
			}
			if ($lastpage < ($cant - 1)) {
				print "... <a href=\"vercat.php?sub=".$id."&page=".$cant."\">".$cant."</a> ";
			}
			else if ($lastpage != $cant) {
				print "<a href=\"vercat.php?sub=".$id."&page=".$cant."\">".$cant."</a> ";
			}
			print "</p>";
			print "<form action=\"vercat.php\" method=\"get\"><p align=\"right\" style=\"font-size: 10pt\">Ir a página <input type=\"text\" name=\"page\" size=\"4\" style=\"height: 10pt;\"/><input type=\"hidden\" name=\"sub\" value=\"".$id."\"></p></form>";
		}
	}
	else {
		$id = intval($_GET["cat"]);
		$result = mysql_query("SELECT * FROM CCategoria WHERE id_cat = $id");
		if (mysql_num_rows($result) != 1) {
?>
			No existe la categoria</td>
		</tr>
<?php 
		}
		else {
			print "<table>";
			$fila = mysql_fetch_array($result);
			print "<tr><td align=\"left\" width=\"250\" height=\"50\" valign=\"bottom\"><span style=\"font-size:200%;\">".$fila["nom_cat"]."</span></td><td valign=\"bottom\"><span>".$fila["des_cat"]."</span></td></tr>";
			$result = mysql_query("SELECT * FROM CSubcategoria WHERE id_cat = $id ORDER BY id_sub");
			$sub = array();
			while ($fila = mysql_fetch_array($result)) {
				$sub[count($sub)] = $fila;
			}
			foreach ($sub as $elem) {
				print "<tr><td colspan=\"2\" align=\"left\"><a href=\"vercat.php?sub=".$elem["id_sub"]."\">".$elem["nom_sub"]."</a></td></tr>";
				unset($sub);
			}
			print "</table>";
		}
	}
?>
	</table>
<?php include "foot.php" ?>
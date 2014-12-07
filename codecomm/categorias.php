<?php
function lista_cat() {
		$result = mysql_query("SELECT * FROM CCategoria ORDER BY id_cat");
		$cat = array();
		while ($fila = mysql_fetch_array($result)) {
			$cat[count($cat)] = $fila;
		}
		foreach ($cat as $elem) {
			$id_elem = $elem["id_cat"];
			$sub = array();
			$result = mysql_query("SELECT * FROM CSubcategoria WHERE id_cat = $id_elem ORDER BY id_sub");
			print "<td height=\"37\" class=\"tmenu\">";
			print "<div class=\"menu\">";
			print "<ul>";
			print "<li><a href=\"vercat.php?cat=".$elem["id_cat"]."\">".$elem["nom_cat"]."</a>";
			print "<ul>";
			while ($fila = mysql_fetch_array($result)) {
				print "<li><a href=\"vercat.php?sub=".$fila["id_sub"]."\">".$fila["nom_sub"]."</a></li>";
			}
			print "</ul></li>";
			print "</ul>";
			print "</div>    </td>";
			unset($sub);
		}
	}
function lista_cat_ex() {
		$result = mysql_query("SELECT * FROM CCategoria ORDER BY id_cat");
		$cat = array();
		while ($fila = mysql_fetch_array($result)) {
			$cat[count($cat)] = $fila;
		}
		foreach ($cat as $elem) {
			$id_elem = $elem["id_cat"];
			$sub = array();
			$result = mysql_query("SELECT * FROM CSubcategoria WHERE id_cat = $id_elem ORDER BY id_sub");
			print "<td valign=\"top\" align = \"left\">";
			print "<dl>";
			print "<dt><a href=\"vercat.php?cat=".$elem["id_cat"]."\">".$elem["nom_cat"]."</a></dt>";
			while ($fila = mysql_fetch_array($result)) {
				print "<dd><a href=\"vercat.php?sub=".$fila["id_sub"]."\">".$fila["nom_sub"]."</a></dd>";
			}
			print "</td>";
			print "</dl>";
			unset($sub);
		}
	}
?>
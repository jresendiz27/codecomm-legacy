<?php
	if (!function_exists("conectar")) {
		include "conectar.php";
	}
	print "<option selected=\"selected\" disabled=\"disabled\" value=\"\">--Seleccione subcategor&iacute;a--</option>";
	$vinculo = conectar();
	$idcat = $_GET["idcat"];
	if (!isset($_GET["idcat"])) {		
		$idcat = $_POST["idcat"];
		if (!isset($_POST["idcat"])) {
			$idcat = 1;
		}
	}
	if ($vinculo === -1) {
		print "<option>Error</option>";
	}
	else {
		$result = mysql_query("SELECT * FROM CSubcategoria WHERE id_cat = $idcat", $vinculo);
		while ($row = mysql_fetch_array($result)) {
			print "<OPTION VALUE=\"".$row["id_sub"]."\">".$row["nom_sub"]."</OPTION>";
		}
		mysql_close($vinculo);
	}
	unset($vinculo);
?>
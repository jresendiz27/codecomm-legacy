<?php
	$result = mysql_query("SELECT * FROM MUsuario WHERE id_user = $ciertoid", $vinculo);
	if($fila = mysql_fetch_array(result)) {
		$bancant = intval($fila["bans_user"]) + 1;
		date_default_timezone_set("UTC");
		$fecha = date("Y-m-d H:i:s");
		mysql_query ("UPDATE MUsuario SET fecban_user = '$fecha', bans_user = $bancat WHERE id_user = $ciertoid", $vinculo);
		if ($bancant > 3) {
			mysql_query ("UPDATE MUsuario SET id_tipo = 3 WHERE id_user = $ciertoid", $vinculo);
		}
	}
	else {
		print "ERROR";
	}
?>
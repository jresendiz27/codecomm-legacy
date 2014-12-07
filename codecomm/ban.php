<?php include "header.php";
	if (isset($_SESSION["fecha"])) {
		if ($_SESSION["fecha"] > (60*60*24*2)) {
			$cadtiempo = floor($_SESSION["fecha"] / (60*60*24))." dias.";
		}
		else if ($_SESSION["fecha"] > (60*60*24)) {
			$cadtiempo = "hasta mañana.";
		}
		else if ($_SESSION["fecha"] > (60*60*2)) {
			$cadtiempo = floor($_SESSION["fecha"] / (60*60))." horas.";
		}
		else if ($_SESSION["fecha"] > (60*60)) {
			$cadtiempo = "una hora.";
		}
		else {
			$cadtiempo = " menos de una hora.";
		}
?>
	<td>Has sido baneado temporalmente. Espera <?php echo $cadtiempo; ?></td></tr></table>
<?php 
		unset($_SESSION["fecha"]);
	} else { ?>
	<td>Has sido baneado</td></tr></table>
<?php } ?>
<?php include "foot.php" ?>
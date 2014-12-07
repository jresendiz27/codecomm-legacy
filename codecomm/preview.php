<?php
	include "postlib.php";
?>
		<hr />
		<h2>Vista previa</h2>
		<p><b>Advertencia:</b> Contenido dinámico, tal como videos de <a href="http://www.youtube.com" target="_blank">YouTube</a>, se recargarán cada vez que la vista previa se actualice.</p>
		<hr />
		<?php
			$bb = true;
			$exist = false;
			if (isset($_POST["bb"])) {
				$bb = false;
			}
			else {
				$bb = true;
			}
			if (isset($_POST["exist"])) {
				$exist = true;
			}
			else {
				$exist = false;
			}
			echo replacebb($exist, $bb, "\t\t", stripslashes($_POST["txt"]));
		?>

<?php include "header.php" ?>
<td>
<?php
	if (isset($_SESSION["user"])) {
?>
		<h2>Borrar post</h2>
<?php
		if (isset($_GET["id"])) {
			$id = intval($_GET["id"]);
			unset($result);
			$result = mysql_query("SELECT * FROM MPost WHERE id_post = $id");
			if (mysql_num_rows($result) == 1) {
				$fila = mysql_fetch_array($result);
				if (($id_my_user == $fila["id_user"]) || ($tipo_user == 3) || ($tipo_user == 2)) {
					if (!isset($_POST["delete"])) {
?>
						<form action="delpost.php?id=<?php echo $id; ?>" method="post">
							<p>¿Estás seguro de que deseas realizar esta acción? <input type="submit" name="delete" value="Sí"/></p>
						</form>
<?php
					}
					else {
						mysql_query("DELETE FROM MPost WHERE id_post = $id");
						mysql_query("DELETE FROM MComentario WHERE id_post = $id");
?>
						<p>Post borrado... :( ... T_T ... XD ... 0_0</p>
						<p align="center"><img src="http://3.bp.blogspot.com/_HIi8dlKxMgE/Sw6WJurUp4I/AAAAAAAAAxE/Go1AvZNl_0c/s1600/gato-con-botas.jpg"/></p>
<?php
					}
				}
				else {
?>
					<p>No tienes privilegios para borrar este post.</p>
<?php
				}
			}
			else {
?>
				<p>El post seleccionado no existe.</p>
<?php
			}
		}
		else {
?>
			<p>No se ha seleccionado post.</p>
<?php
		}
	}
	else {
		include "motivar.php";
	}
?>
</td></tr></table>
<?php include "foot.php"; ?>
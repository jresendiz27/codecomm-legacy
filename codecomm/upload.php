<?php include ("header.php");?>
<?php if(isset($_SESSION['user']))
	{ ?>
	<td>
	<h2>Subir avatar</h2>
	<p><?php echo $uploaderr; ?></p>
	<ol>
		<li>Elige un avatar cuyo tamaño sea menor a 100 Kb</li>
		<li>Confirma tu elección y súbelo</li>
	</ol>
	<div align="center">
	<hr>
		<form enctype="multipart/form-data" action="subir.php" method="post" id="id">
			<input type="hidden" name="MAX_FILE_SIZE">
			<input type="file" name="imagen" size="70">
			<p></p>
			<input type="submit" name="Upload" value="Subir avatar">
		</form>
	<hr>
		<form action="subir.php" method="post">
			<p>También puedes eliminar el avatar actual</p>
			<p><input type="submit" name="Delete" value="Borrar"></p>
		</form>
	</div>
	</td></tr></table>
<?php } else {?>
	<td><p>Inicia sesion primero</p></td></tr></table>
<?php } ?>
<?php include "foot.php" ?>

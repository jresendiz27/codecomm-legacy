<?php
	if (!function_exists(conectar)) {
		include "conectar.php";
	}
	$vinculo = conectar();
	if (!function_exists(dummysession)) {
		include "sesion.php";
	}
	if (!function_exists(replacebb)) {
		include "postlib.php";
	}
	if (isset($_POST["id"])) {
		$id = $_POST["id"];
	}
	else {
		$id = $_GET["id"];
	}
?>
		<form  name="fcomment" method = "POST" action="verpost.php?id=<?php echo $id;?>"> 
		<table align="center" BORDER = "1" CELLPADDING ="10" WIDTH = "95%" style="background-image:url(images/classic/1335.png);">
        <tr>
			<td>
<?php
				mysql_query ("SET NAMES 'utf8'");
				if (isset($_SESSION["user"])) {
					if (isset($_GET["remcom"])) {
						$idcom = $_GET["remcom"];
						if (($tipo_user == 3) || ($tipo_user == 2)) {
							mysql_query("DELETE FROM MComentario WHERE id_com = $idcom");
						}
						else {
							mysql_query("DELETE FROM MComentario WHERE id_com = $idcom AND id_user = $id_my_user");
						}
					}
					if (isset($_POST["comment"])) {
						$comment = $_POST["comment"];
						if (strlen($comment) >= 5) {
							if (strlen($comment) <= 500) {
								mysql_query("INSERT INTO MComentario(id_user, id_post, cuerpo_com) VALUE($id_comment, $id, _utf8'$comment')", $vinculo);
							}
						}
					}
				}
				$resultComen = mysql_query("SELECT * FROM MComentario NATURAL JOIN MUsuario WHERE id_post = $id ORDER BY id_com", $vinculo);
				while($rowComen = mysql_fetch_array($resultComen))
				{
				if($rowComen['avatar_user']==""||$rowComen['avatar_user']==null||$rowComen['avatar_user']=="null")
					{
					$img="default.gif";
					}
				else
					{
					$img="users/".$rowComen['avatar_user'];
					}
				$size = getimagesize($img);
				if ($size[0] > $size[1]) {
					$mult = 30 / $size[0];
				}
				else {
					$mult = 30 / $size[1];
				}
			?>		<table border="0" style="color:#FFF;">
				    <tr>
					<td width="100">
					<a href="perfil.php?nick=<?php echo htmlspecialchars($rowComen["nick_user"], ENT_COMPAT, 'UTF-8'); ?>"></a> <a href="perfil.php?nick=<?php echo htmlspecialchars($rowComen["nick_user"], ENT_COMPAT, 'UTF-8'); ?>"><img src="<?php echo htmlspecialchars($img, ENT_COMPAT, 'UTF-8'); ?>" width="<?php echo $size[0] * $mult; ?>" height="<?php echo $size[1] * $mult; ?>" alt="<?php echo htmlspecialchars($rowComen["nick_user"], ENT_COMPAT, 'UTF-8'); ?>" style="border:none;" align="bottom"/></a>
					<p><?php echo htmlspecialchars($rowComen["nick_user"], ENT_COMPAT, 'UTF-8'); ?></p>
					</td>
					<td style="border:solid 1px #fff;" width="600"><? echo replacebb(false, true,"",$rowComen["cuerpo_com"]); ?></td>
					</tr>
					<tr>
					<td colspan="2">
					<?php if (isset($_SESSION["user"])) {
					if ((strcmp($_SESSION["user"], $rowComen["nick_user"]) == 0) || ($tipo_user == 3) || ($tipo_user == 2)) {
						$id_com =  $rowComen["id_com"];
						echo "<br /><p align=\"right\"><a href=\"verpost.php?id=".$id."&remcom=".$id_com."\" target=\"_self\" onclick=\"loadXMLDoc('comentario.php', 'remcom=".$id_com."&amp;id=".$id."', 'GET', 'commentfeed'); return false;\">Borrar</a></p>";
					}
					} ?>
					</td>
					</tr>
					</table>
					<br />
					<?
						}
						mysql_free_result($resultComen);
					?>


			
			
			</TD>
		</TR>

		<?php if (isset($_SESSION["user"])) { ?>

		<tr>
			<TD id="cell_ta">
				<CENTER><TEXTAREA NAME="comment"  ID="comment" ROWS=3 COLS = 90 onclick="borra()">Escribe un comentario...</TEXTAREA></CENTER>
			    <p><b>Longuitud: de 5 a 500 caracteres</b></p>
				<p align="center"><INPUT TYPE= "submit"  onclick="loadXMLDoc('comentario.php', 'comment=' + encodeURIComponent(document.getElementById('comment').value) + '&amp;id=<?php echo $id; ?>', 'POST', 'commentfeed'); return false;" NAME = "publish" value = "Publicar"></p>			
			</TD>
		</TR>
		<?php } else { ?>
		<tr>
			<td>Para publicar comentarios, hay que estar registrado.</td>
		</tr>
		<?php } ?>
		</TABLE>
		
		</form>


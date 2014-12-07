<?php
	include "header.php";
	include "postlib.php";
	$vinculo = conectar();
	$usuario;
	$user_post;
	$date_post;
	$nom_post;
	$id = intval($_GET["id"]);
	if(isset($id)&&$id!=null&&$id!=0)
	{
	$rs=mysql_query("SELECT * FROM MPost NATURAL JOIN MUsuario WHERE id_post = '$id'", $vinculo);
	if(mysql_num_rows($rs)==1)
	{
	while($row=mysql_fetch_array($rs))
		{
		$user_post = $row['nick_user'];
		$date_post = $row['fec_post']." UTC";
		if (strcmp($row['fec_post'], $row['fecedit_post']) != 0) {
			$date_post = $date_post."<br /><span style=\"font-size:70%\">Edición: ".$row['fecedit_post']." UTC</span>";
		}
		$nom_post = $row['nom_post'];
		$avatar= "users/".$row['avatar_user'];
			$size = getimagesize($avatar);
			if ($size[0] > $size[1]) {
				$mult = 100 / $size[0];
			}
			else {
				$mult = 100 / $size[1];
			}
		}
	}
	}
?>
<td valign="top">
<?php
	if (isset($id)) {
		mysql_query ("SET NAMES 'utf8'");
		?>
		<center>
		<table border="0" align="center">
			<tr>
				<td colspan="2"><center><h3><?php echo htmlspecialchars($nom_post, ENT_COMPAT, 'UTF-8'); ?></h3></center></td>
			</tr>
			<tr>
				<td width="50%" align="center">Usuario</td>
				<td width="50%" align="center">Fecha</td>
			</tr>
			<tr>
				<td width="50%" align="center"><a class="amigos" style="font-size:12px;" href="perfil.php?nick=<? echo htmlspecialchars($user_post, ENT_COMPAT, 'UTF-8'); ?>" target="_self"><img src="<?php echo $avatar; ?>" width="<?php echo $size[0] * $mult; ?>" height="<?php echo $size[1] * $mult; ?>" align="bottom" style="border:none;"/><p><? echo htmlspecialchars($user_post, ENT_COMPAT, 'UTF-8');?></p></a></td>
				<td width="50%" align="center"><? echo $date_post;?></td>
			</tr>
		</table>
		</center>
		<br/>
		<hr/>
		<br/>
		<br/>
		<div id="post" width="800">
		<?
		$result = mysql_query("SELECT * FROM MPost NATURAL JOIN MUsuario WHERE id_post = $id", $vinculo);
		if ($fila = mysql_fetch_array($result)) {
			if (isset($_GET["addfav"])) {
				$result = mysql_query ("SELECT * FROM MFavorito WHERE id_post = $id AND id_user = $id_comment");
				if (mysql_num_rows($result) == 0) {
					mysql_query ("INSERT INTO MFavorito(id_post, id_user) VALUE($id, $id_comment)");
				}
			}
			echo replacebb($fila["limpbb_post"], !$fila["verbb_post"], "\t\t", $fila["cuerpo_post"]);
			if (isset($_SESSION["user"])) {
				if ((strcmp($_SESSION["user"], $fila["nick_user"]) == 0) || ($tipo_user == 3) || ($tipo_user == 2)) {
					echo "<p align=\"right\"><a href=\"creacion.php?idpost=".$id."\" target=\"_self\">Modificar Post</a></p>";
					echo "<p align=\"right\"><a href=\"delpost.php?id=".$fila["id_post"]."\" target=\"_self\">Borrar Post</a></p>";
				}
			}
?>
		<hr />
		</div>
		<div align="right"><table border="0" cellpadding="5"><tr><? if(isset($_SESSION["user>"])) { ?><td>Añadir a favoritos</td><? } ?><td>Compartir en Facebook</td></tr><tr><? if(isset($_SESSION["user"])) {?><td align="right"><a href="verpost.php?id=<?php echo $id; ?>&addfav=1">Añadir</a></td><? } ?><td align="right"><iframe src="http://www.facebook.com/plugins/like.php?href=http://www.insysdev.co.cc/codecomm/verpost.php?id=<?php echo $id; ?>&amp;layout=button_count&amp;show_faces=true&amp;width=150&amp;action=like&amp;font&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowtransparency="true"></iframe></td></tr></table></div>
		<hr />
<?php
			echo "<div id=\"commentfeed\">";
			include "comentario.php";
			echo "</div>";
		}
		else
		{
		echo "El post seleccionado no existe";
		}
	
	}
	else
	{
	echo "No se ha seleccionado post";
	}
	
	mysql_close($vinculo);
?>
	</td></tr></table>
<?php include "foot.php" ?>
<?php
	header("Content-type: text/html; charset=utf-8");

	include "header.php";

	function leercat() {
		$vinculo = conectar();
		$id_cat = intval($_POST["idcat"]);
		$result = mysql_query("SELECT * FROM CCategoria WHERE id_cat = $id_cat", $vinculo);
		if (!mysql_fetch_array($result)) {
			$id_cat = 1;
		}
		$result = mysql_query("SELECT * FROM CCategoria ORDER BY id_cat", $vinculo);
		while ($row = mysql_fetch_array($result)) {
			if ($row["id_cat"] == $id_cat) {
				print "<OPTION SELECTED=\"selected\" VALUE=\"".$row["id_cat"]."\">".$row["nom_cat"]."</OPTION>";
			}
			else {
				print "<OPTION VALUE=\"".$row["id_cat"]."\">".$row["nom_cat"]."</OPTION>";
			}
		}
		mysql_close($vinculo);
		unset($vinculo);
	}
	
	mysql_query ("SET NAMES 'utf8'");

	if (!isset($_SESSION["user"])) {
		include "motivar.php";
	}
	else {
		unset($id);

		if (isset($_POST["idpost"])) {
			$id = intval($_POST["idpost"]);
		}
		else if (isset($_GET["idpost"])){
			$id = intval($_GET["idpost"]);
		}
		
		$msg = stripslashes($_POST["txt"]);
		$nom = stripslashes(trim($_POST["nombre"]));
		$sub = $_POST["sub"];

		if (isset($id) && isset($_GET["idpost"])) {
			$fila = mysql_fetch_array(mysql_query("SELECT * FROM MPost WHERE id_post = '$id'", $vinculo));
			$msg = $fila["cuerpo_post"];
			$nom = $fila["nom_post"];
			$prior = $fila["prior_post"];
		}
	
		if (isset($_POST["create"])) {

			$vinculo = conectar();
		
			$valido = true;
			$error = "<h3>ERROR:</h3><ul>";
		
			if (isset($_POST["txt"])) {
				if (strlen(trim($msg)) < 50) {
					$valido = false;
					$error = $error."<li>El post contiene menos de 50 caracteres sin contar espacios al inicio y final.</li>";
				}
			}
			else {
				$error = $error."<li>No se recibió post.</li>";
				$valido = false;
			}
		
			if (strlen(trim($nom)) < 5) {
				$error = $error."<li>El t&iacute;tulo debe contener mínimo 5 caracteres sin contar espacios al inicio y al final.</li>";
				$valido = false;
			}
			else if (strlen($nom) > 255) {
				$valido = false;
				$error = $error."<li>El título contiene más de 255 caracteres.</li>";
			}
			if (!isset($sub) || strcmp($sub, "") == 0) {
				$sub = "0";
			}
			$result = mysql_query("SELECT * FROM CSubcategoria WHERE id_sub = $sub", $vinculo);
			if (!mysql_fetch_array($result)) {
				$error = $error."<li>No se ha seleccionado una categoría válida.</li>";
				$valido = false;
			}
			if (isset($id)) {
				if (($tipo_user != 2) && ($tipo_user != 3)) {
					$result = mysql_query("SELECT * FROM MPost NATURAL JOIN MUsuario WHERE UPPER(nick_user) = '$user' AND id_post = $id", $vinculo);
					if (!mysql_fetch_array($result)) {
						$error = $error."<li>El post no te pertenece.</li>";
						$valido = false;
					}
				}
			}
			if (isset($_POST["prior"]) && (($tipo_user == 2) || ($tipo_user == 3))) {
				$prior = intval($_POST["prior"]);
				if (($prior < 0) || ($prior > 100)) {
					$prior = 0;
				}
			}
			else {
				$prior = 0;
			}
			
			if (!$valido) {
				$error = $error."</ul><br />";
			}
			else {
				date_default_timezone_set("UTC");
				$fecha = date("Y-m-d H:i:s");
				if (isset($_POST["exist"])) {
					$exist = "true";
				}
				else {
					$exist = "false";
				}
				if (isset($_POST["bb"])) {
					$bb = "true";
				}
				else {
					$bb = "false";
					$exist = "false";
				}
				$fila = mysql_fetch_array(mysql_query("SELECT * FROM MUsuario WHERE UPPER(nick_user) = '$user'", $vinculo));
				$id_user = $fila["id_user"];
				$msg = mysql_real_escape_string($msg);
				$nom = mysql_real_escape_string($nom);
				if (isset($id)) {
					mysql_query("UPDATE MPost SET ".
						"nom_post = _utf8'$nom', ".
						"id_sub = $sub, ".
						"fecedit_post = '$fecha', ".
						"cuerpo_post = _utf8'$msg', ".
						"verbb_post = $bb, ".
						"limpbb_post = $exist, ".
						"prior_post = $prior ".
						"WHERE id_post = $id",
						$vinculo);
				}
				else {
					mysql_query("INSERT INTO MPost(id_user, nom_post, id_sub, fec_post, fecedit_post, cuerpo_post, verbb_post, limpbb_post, prior_post,tags_post) "
						."VALUE($id_user, _utf8'$nom', $sub, '$fecha', '$fecha', _utf8'$msg', $bb, $exist, $prior,'null')",
						$vinculo);
				}
				print mysql_error();
			}
		}
	
		unset($vinculo);
?>
			<td valign="top"><center><h2>Creación de post</h2></center>
			<? if (!$valido) { ?>
			<noscript><p class="advice"><b>Advertencia: para el uso completo de las funciones que ofrece el editor, se recomienda habilitar JavaScript.</p></noscript>
			<table align="center">
			<tr>
				<td class="cpost" valign="top" width="400">
				<form action="creacion.php" method="POST" accept-charset="UTF-8" name="mpost" id="mpost">
					<?php echo $error; ?>
					<center>
					<p>Nombre del post (5~255 caracteres)</p>
					<p><input type="text" name="nombre" maxlength="255" size="50" value="<?php echo $nom; ?>"></p>
					<script type="text/javascript"><!--
						writemap();
					--></script>
				<p>
					<b>El post debe contener un m&iacute;nimo de 50 caracteres</b>
				</p>
				<textarea rows="20" cols="45" name="txt" id="txt" onkeyup="sendCode();" onfocus="elEditor = ini_editor(this);" on><?php echo $msg; ?></textarea>
				</td>
			<td height="600" class="cpost" align="left">
			<p align="left"><input type="checkbox" name="bb" id="bb" <?php if (isset($_POST["bb"])) echo "checked=\"checked\""; ?> onchange="if (!this.checked) { document.getElementById('existp').style.display = 'none'; document.getElementById('existc').checked = false; } else document.getElementById('existp').style.display = 'block'; sendCode();">Aceptar bbcode</p>
				<p align="left" id="existp"><input type="checkbox" name="exist" id="existc" <?php if (isset($_POST["exist"])) echo "checked=\"checked\""; ?> onchange="sendCode();">Borrar etiquetas no existentes (si bbcode est&aacute; habilitado)</p>
				<div>
                <table>
					<tr>
						<td>
							<select name="idcat" onChange="loadXMLDoc('subcat.php', 'idcat=' + this.value, 'GET', 'sublist')">
							<?php leercat() ?>
							</select>
						</td>
						<td>
							<select name="sub" id="sublist">
							<?php include "subcat.php"; ?>
							</select>
						</td>
						<td>
							<input type="submit" name="update" value="Actualizar"/>
						</td>
					</tr>
				</table>
                </div>
				<?php if (($tipo_user == 3) || ($tipo_user == 2)) { ?><p>Prioridad (0~100, siendo 100 la más alta, 0 como defecto): <input type="text" name="prior" value="0" size="3" maxlength="3"></p><?php } ?>
				<?php if (isset($id)) { ?><input type="hidden" name="idpost" value="<?php echo $id; ?>"><?php } ?>
				<p><input name="create" type="submit" value="Crear" />
				o...
				<input name="previewbtn" type="submit" value="Vista previa"></p>
			</center>
		  </form>
		 </td>
				</tr>
				<tr>
				<td colspan="2">
				<span id="preview">
				<?php include "preview.php"; ?>
				<noscript><hr />Para visualizar vista previa automática, se requiere JavaScript</noscript>
				</span>
				</td>
		</tr>
		  <? } else { ?>
		  <td>El post ha sido publicado correctamente.</td>
		  <? } ?>
		</tr></table>
	  </td></tr>
	</table>
<?php } ?>
<?php include "foot.php" ?>

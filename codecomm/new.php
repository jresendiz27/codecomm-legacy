<?php
$user=$_SESSION["user"];
$final;
/*function amigos($user)
	{
	$con = mysql_connect("localhost","root","pass");
	if (!$con)
	{
	die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("pepo", $con);
	$result = mysql_query("SELECT list_amig FROM MUsuario where nick_user='$user'");
	
if(mysql_num_rows($result) == 1)
  {
$row = mysql_fetch_array($result);
  $final=split(',', $row['list_amig']);
  for($i=0;$i<sizeof($final);$i++)
		{
		echo "<button type=\"button\" name=\"".$final[$i]."\" id=\"".$final[$i]."\" value=\"".$final[$i]."\" onclick=\"anade();\">".$final[$i]."</button>";
		echo "<br>";
		}
  }
else
	{
	echo "imbecil no tienes amigos!";
	}
mysql_close($con);
	}
amigos($user);
*/
$valido = false;

if (isset($_POST["destlist"])) {
	$destlist = preg_replace("#[^0-9,]#", "", $_POST["destlist"]);
}
else {
	$destlist = "";
}
$destarray = preg_split("#,#", $destlist);
$destarray = array_unique ($destarray);
$destlist = "";
$cant = 0;
foreach ($destarray as $elem) {
	if (strcmp($elem, "") != 0) {
		if (!isset($_POST[$elem])) {
			$result = mysql_query("SELECT * FROM MUsuario WHERE id_user = $elem", $vinculo);			
			if ($fila = mysql_fetch_array($result)) {
				if (strcmp($fila["nick_user"], $_SESSION["user"]) != 0) {
					$destlist = $destlist.",".$elem;
					$cant += 1;
				}
			}
		}
	}
}
$destlist = preg_replace("#^,#", "", $destlist);
if (isset($_POST["dest"])) {
	$dest = strtoupper($_POST["destname"]);
	$result = mysql_query("SELECT * FROM MUsuario WHERE UPPER(nick_user) = '$dest'", $vinculo);
	echo mysql_error();
	if ($fila = mysql_fetch_array($result)) {
		if (strcmp($fila["nick_user"], $_SESSION["user"]) != 0) {
			$destlist = $destlist.",".$fila["id_user"];
			$cant += 1;
		}
	}
}

$msg = stripslashes($_POST["txt"]);
$nom = stripslashes(trim($_POST["nombre"]));

$error = "";

if(isset($_POST["msg"])) 
{
	$valido = true;
	$error = "<h3>ERROR:</h3><ul>";
	
	if (isset($_POST["txt"])) {
		if (strlen(trim($msg)) < 10) {
			$valido = false;
			$error = $error."<li>El mensaje contiene menos de 10 caracteres sin contar espacios al inicio y final.</li>";
		}
	}
	else {
		$valido = false;
		$error = $error."<li>No se ha recibido un mensaje.</li>";
	}
	
	if (strlen(trim($nom)) < 5) {
		$valido = false;
		$error = $error."<li>El asunto debe contener mínimo 5 caracteres sin contar espacios al inicio y al final.</li>";
	}
	else if (strlen($nom) > 255) {
		$valido = false;
		$error = $error."<li>El asunto contiene más de 255 caracteres.</li>";
	}
	
	if ($cant < 1) {
		$valido = false;
		$error = $error."<li>No se ha incluido ningún remitente</li>";
	}
	
	$error = $error."</ul><br />";
}


if ($valido) {
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
	mysql_query("INSERT INTO EMensaje(id_user, nom_msg, fec_msg, cuerpo_msg, verbb_msg, limpbb_msg) "
		."VALUE($id_user, _utf8'$nom', '$fecha', _utf8'$msg', $bb, $exist)",
		$vinculo);
	$result =  mysql_query("SELECT * FROM EMensaje WHERE id_user = $id_user AND fec_msg = '$fecha'",
		$vinculo);
	print mysql_error();
	$fila = mysql_fetch_array($result);
	$id_msg = $fila["id_msg"];
	$destarray = preg_split("#,#", $destlist);
	$destarray = array_unique($destarray);
	foreach($destarray as $elem) {
		if (strcmp($elem, "") != 0) {
			mysql_query("INSERT INTO DMensaje(id_msg, id_user, leido_msg) "
				."VALUE($id_msg, $elem, false)",
				$vinculo);
		}
	}

	$form1 = "msg enviado";
}
else 
	{
	$form1="<form action=\"msg.php?data=new\" method=\"post\" name=\"mpost\" id=\"mpost\">".$error.
	"<p>Titulo: <input type=\"text\" name=\"nombre\" size=\"70\" value=\"".$nom."\" maxlenght=\"255\"/> (5~255 caracteres)</p>
	<p>Agregar destinatario: <input type=\"text\" name=\"destname\" size=\"70\" maxlength=\"60\"/> <input type=\"submit\" name=\"dest\" value=\"Agregar\"></p>
	<p>Destinatarios: </p><ul>\n";
	$destarray = preg_split("#,#", $destlist);
	$destarray = array_unique($destarray);
	foreach($destarray as $elem) {
		if (strcmp($elem, "") != 0) {
			$result = mysql_query("SELECT * FROM MUsuario WHERE id_user = $elem", $vinculo);
			$fila = mysql_fetch_array($result);
			$form1 = $form1."<li>".$fila["nick_user"]." <input type=\"submit\" name=\"".$fila["id_user"]."\" value=\"Remover\"></li>\n";
		}
	}
	$form1 = $form1."</ul><table border=\"0\" align=\"center\">
		<tr>
		  <td width=\"450\">
				<center>
				<script type=\"text/javascript\"><!--
					writemap();
				--></script>
	</table>
	<table align=\"center\"><tr><td valign=\"top\">
	<p align=\"center\">Mensaje<br />(mínimo 10 caracteres sin contar espacios al inicio y final):<br /><br /><textarea rows=\"40\" cols=\"45\" name=\"txt\" id=\"txt\" onkeyup=\"sendCode();\">".$msg."</textarea></p>
	</td>
	<td height=\"890\" class=\"vprev\" valign=\"top\"><span id=\"preview\">";
	$form2=
"	<noscript><hr />Para visualizar vista previa automática, se requiere JavaScript</noscript>
	</span></td>
	</tr></table>
	<p align=\"center\"><input type=\"checkbox\" name=\"bb\" id=\"bb\" onchange=\"if (!this.checked) { document.getElementById('existp').style.display = 'none'; document.getElementById('existc').checked = false; } else document.getElementById('existp').style.display = 'block'; sendCode();\">Aceptar bbcode</p>
	<p align=\"center\" id=\"existp\"><input type=\"checkbox\" name=\"exist\" id=\"existc\" onchange=\"sendCode();\">Borrar etiquetas no existentes (si bbcode est&aacute; habilitado)</p>
	<input type=\"hidden\" name=\"destlist\" value=\"".$destlist."\">
	<p align=\"center\"><input type=\"submit\" name=\"msg\" value=\"Enviar mensaje\" /></p><p align=\"center\">ó...</p><p align=\"center\"><input type=\"submit\" name=\"previewbtn\" value=\"Vista previa\" /></p>
	</form>
	";
	}?>
<td valign="top">
<h2>Mensaje nuevo</h2>
<noscript><p class="advice">Es necesario Javascript para disfrutar la funcionalidad total de la pagina</p></noscript>
<?php
	echo $form1;
	include "preview.php";
	echo $form2;
?>
</td></tr></table>
<?php include "foot.php" ?>

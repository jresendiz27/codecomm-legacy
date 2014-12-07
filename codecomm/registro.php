<?php
	header("Content-type: text/html; charset=utf-8");
	
	session_start();
	if (isset($_SESSION["user"])) {
		header("Location: index.php");
	}

	include "header.php";
	
	function lista_pais($vinculo) {
		$result = mysql_query("SELECT * FROM CPais ORDER BY nom_pais",$vinculo);
		if (strcmp($_POST["pais"], "") == 0) {
			$lista = "							<option value=\"\" selected=\"selected\" disabled=\"disabled\">--- Seleccione uno ---</option>\n";
		}
		else {
			$lista = "							<option value=\"\" disabled=\"disabled\">--- Seleccione uno ---</option>\n";
		}
		while ($fila = mysql_fetch_assoc($result)) {
			$lista = $lista."							<option value=\"".$fila["id_pais"]."\"";
			if (strcmp($_POST["pais"], $fila["id_pais"]) == 0) {
				$lista = $lista." selected=\"selected\"";
			}
			$lista = $lista.">".$fila["nom_pais"]."</option>\n";
		}
		return $lista;
	}
	
	function lista_dominio($vinculo) {
		$result = mysql_query("SELECT * FROM CDominio", $vinculo);
		if (strcmp($_POST["dominio"], "") == 0) {
			$lista = "							<option value=\"\" selected=\"selected\" disabled=\"disabled\">--- Seleccione uno ---</option>\n";
		}
		else {
			$lista = "							<option value=\"\" disabled=\"disabled\">--- Seleccione uno ---</option>\n";
		}
		while ($fila = mysql_fetch_assoc($result)) {
			$lista = $lista."							<option value=\"".$fila["id_dom"]."\"";
			if (strcmp($_POST["dominio"], $fila["id_dom"]) == 0) {
				$lista = $lista." selected=\"selected\"";
			}
			$lista = $lista.">".$fila["nom_dom"]."</option>\n";
		}
		return $lista;
	}

	function validar() {
		$vinculo = conectar();
		if ($vinculo === -1) {
			print "ERROR";
			return;
		}
		require_once('recaptchalib.php');
		$publickey = "6LeDY7oSAAAAAD8At7vvIVCr4f4XiyjZ5F_sJ2bq";
		$privatekey = "6LeDY7oSAAAAADZBF0T7TIaO-pjotCEltIfx8DBH";
		$captcha = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
		mysql_query ("SET NAMES 'utf8'");
		$valido = true;
		$nombre = stripslashes(trim($_POST["nombre"]));
		$apellidos = stripslashes(trim($_POST["apellidos"]));
		$email = stripslashes(trim($_POST["email"]));
		$dominio = stripslashes(trim($_POST["dominio"]));
		$pais = $_POST["pais"];
		$usuario = stripslashes(trim($_POST["usuario"]));
		$contrasena = stripslashes($_POST["contrasena"]);
		$confirmacion = stripslashes($_POST["confirmacion"]);
		$dia = trim($_POST["dia"]);
		$mes = $_POST["mes"];
		$ano = trim($_POST["ano"]);
		$nacimiento = "";
		$img_error = "<IMG SRC=\"error.png\" ALT=\"Error: \" width=\"20\" HEIGHT=\"20\" style=\"vertical-align:middle;\">";
		$msgconfirm = "<h3>ERROR</h3>\n".
			"		<p>Hubo un error al procesar la solicitud de registro.</p>\n";
		$form_encabezado = 
			"		<p>\n".
			"			<br>\n".
			"			<br>\n".
			"			<b>* Campo obligatorio</b><br>\n".
			"			<b>** Campo obligatorio, inmutable\n".
			"		</p>\n".
			"		<HR>\n".
			"		<form action=\"registro.php\" method=\"POST\">\n";
		$form_nombre =
			"			<table cellspacing=\"10\">\n".
			"				<tr>\n".
			"					<td width=400 style=\"width:400px;\">\n".
			"						<b>Nombre*:</b> <input type=\"text\" name=\"nombre\" id=\"nombre\" maxlength=\"100\" value=\"";
		$form_nombre_medio =
			"\">\n".
			"					</td>\n".
			"					<td>\n";
		$form_nombre_final =
			"					</td>\n";
			"				</tr>\n";
		$form_apellidos =
			"				<tr>\n".
			"					<td width=400 style=\"width:400px;\">\n".
			"						Apellidos: <input type=\"text\" name=\"apellidos\" maxlength=\"200\" value=\"";
		$form_apellidos_medio =
			"\">\n".
			"					</td>\n".
			"					<td>\n";
		$form_apellidos_final =
			"					</td>\n".
			"				</tr>\n";
		$form_fecha =
			"				<tr>\n".
			"					<td width=400 style=\"width:400px;\">\n".
			"						<b>Fecha de nacimiento**</b>:\n".
			"						<input type=\"text\" name=\"dia\" id=\"dia\" value=\"d&iacute;a\" size=3 maxlength=2 onclick=\"javascript:if (this.value == 'd&iacute;a') this.value='';\">\n".
			"						<select name=\"mes\" id=\"mes\">\n".
			"							<option value=\"\" selected=\"selected\" disabled=\"disabled\">mes</option>\n".
			"							<option value=\"1\">Enero</option>\n".
			"							<option value=\"2\">Febrero</option>\n".
			"							<option value=\"3\">Marzo</option>\n".
			"							<option value=\"4\">Abril</option>\n".
			"							<option value=\"5\">Mayo</option>\n".
			"							<option value=\"6\">Junio</option>\n".
			"							<option value=\"7\">Julio</option>\n".
			"							<option value=\"8\">Agosto</option>\n".
			"							<option value=\"9\">Septiembre</option>\n".
			"							<option value=\"10\">Octubre</option>\n".
			"							<option value=\"11\">Noviembre</option>\n".
			"							<option value=\"12\">Diciembre</option>\n".
			"						</SELECT>\n".
			"						<input type=\"text\" name=\"ano\" id=\"ano\" value=\"a&ntilde;o\" size=3 maxlength=4 ONCLICK=\"javascript:if (this.value == 'a&ntilde;o') this.value='';\">\n".
			"					</td>\n".
			"					<td>\n";
		$form_fecha_final =
			"					</td>\n".
			"				</tr>\n";
		$form_email =
			"				<tr>\n".
			"					<td width=400 style=\"width:400px;\">\n".
			"						<b>Correo electr&oacute;nico*:</b><BR>\n".
			"						<input type=\"text\" name=\"email\" id=\"email\" value=\"";
		$form_email_medio =
			"					</td>\n".
			"					<td>\n";
		$form_email_final = 
			"					</td>\n".
			"				</tr>\n";
		$form_pais =
			"				<tr>\n".
			"					<td width=400 style=\"width:400px;\">\n".
			"						<b>Pais:*</b>\n".
			"						<select name=\"pais\" id=\"pais\">\n";
		$form_pais_medio =
			"						</select>\n".
			"					</td>\n".
			"					<td>\n";
		$form_pais_final = 
			"					</td>\n".
			"			</table>\n";
		$form_usuario =
			"			<HR>\n".
			"			<table cellspacing=\"10\">\n".
			"				<tr>\n".
			"					<td width=400 style=\"width:400px;\">\n".
			"						<b>Seud√≥nimo (3-20 caracteres)**:</b> <input type=\"text\" name=\"usuario\" id=\"usuario\" size=\"20\" maxlength=\"20\" value=\"";
		$form_usuario_medio = 
			"\">\n".
			"					</td>\n".
			"					<td>\n";
		$form_usuario_final = 
			"					</td>\n".
			"				</tr>\n".
			"			</table>\n";
		$form_contrasena =
			"			<HR>\n".
			"			<table cellspacing=\"10\">\n".
			"				<tr>\n".
			"					<td width=400 style=\"width:400px;\">\n".
			"						<b>Contrase&ntilde;a (4 a 20 caracteres)*:</b> <input type=\"password\" name=\"contrasena\" id=\"contrasena\" size=\"20\" maxlength=\"20\">\n".
			"					</td>\n".
			"					<td>\n";
		$form_contrasena_final =
			"					</td>\n".
			"				</tr>\n";
		$form_confirmacion =
			"				<tr>\n".
			"					<td width=400 style=\"width:400px;\">\n".
			"						<b>Confirmar contrase&ntilde;a*:</b> <input type=\"password\" name=\"confirmacion\" id=\"confirmacion\">\n".
			"					</td>\n".
			"					<td>\n";
		$form_confirmacion_final =
			"					</td>\n".
			"				</tr>\n".
			"			</table>\n";
		$form_captcha =
			"			<hr>\n".
			"			<table cellspacing=\"10\">\n".
			"				<tr>\n".
			"					<td width=400 style=\"width:400px;\">\n".
			preg_replace("#Type the two words:#u", "Teclea las dos palabras:", recaptcha_get_html($publickey)).
			"					</td>\n".
			"					<td>\n";
		$form_captcha_final =
			"					</td>\n".
			"				</tr>\n".
			"			</table>\n";
		$form_terminos =
			"			<hr>\n".
			"			<table cellspacing=\"10\">\n".
			"				<tr>\n".
			"					<td width=400 style=\"width:400px;\">\n".
			"						<input type=\"checkbox\" name=\"terminos\" id=\"terminos\"> <b>Acepto los <a href=\"terminos.html\" target=\"_blank\">t&eacute;rminos de uso</a> de CodeComm*</b>.\n".
			"					</td>\n".
			"					<td>\n";
		$form_terminos_final =
			"					</td>\n".
			"				</tr>\n".
			"			</table>\n";
		$form_enviar =
			"			<p>\n".
			"				<input type=\"submit\" name=\"enviar\" value=\"Enviar\">\n".
			"			</p>\n".
			"		</FORM>\n";
		if (!isset($_POST["enviar"])) {
			include "form.php";
		}
		else {
			if (strcmp($nombre, "") == 0) {
				$form_nombre_medio = $form_nombre_medio."						".$img_error."El campo de nombre est&aacute; vacio.\n";
				$valido = false;
			}
			else if(!ereg("^[a-zA-Z·ÈÌÛ˙¸]",$nombre))
				{
				$form_nombre_medio = $form_nombre_medio."						".$img_error."El campo de nombre no contiene caracteres validos.\n";
				$valido = false;
				}
			else if(!ereg("^[a-zA-Z·ÈÌÛ˙¸]",$apellidos))
				{
				$form_apellidos_medio = $form_apellidos_medio."						".$img_error."El campo de nombre no contiene caracteres validos.\n";
				$valido = false;
				}
			else if (strlen($nombre) > 100) {
				$form_nombre_medio = $form_nombre_medio."						".$img_error."El nombre no debe contener m&aacute;s de 100 caracteres\n";
				$valido = false;
			}
			else {
				$form_nombre = $form_nombre.$nombre;
			}
			if (strlen($apellidos) > 200) {
				$form_apellidos_medio =  $form_apellidos_medio."						".$img_error."El apellido no debe contener m&aacute;s de 200 caracteres\n";
				$valido = false;
			}
			else {
				$form_apellidos = $form_apellidos.$apellidos;
			}
			if (strcmp($email, "") == 0) {
				$form_email_medio =  $form_email_medio."						".$img_error."El campo de correo electronico est&aacute; vacio.<BR>\n";
				$valido = false;
			}
			else if (strpos($email, "@") !== false) {
				$form_email_medio =  $form_email_medio."						".$img_error."Correo electr&oacute;nico inv&aacute;lido: Formato incorrecto (no es necesario el arroba de nuevo).<BR>\n";
				$valido = false;
			}
			else{
				$emailvalido = true;
				if (strcmp($email, "") === 0) {
					$form_email_medio =  $form_email_medio."						".$img_error."Correo electr&oacute;nico inv&aacute;lido: No existe usuario (nada antes del arroba).\n";
					$valido = false;
					$emailvalido = false;
				}
				else {
					if (strpos($email, ".") === 0) {
						$form_email_medio =  $form_email_medio."						".$img_error."Correo electr&oacute;nico inv&aacute;lido: No se permite el punto al principio del correo<BR>\n";
						$valido = false;
						$emailvalido = false;
					}
					if (strpos($email, " ") !== false) {
						$form_email_medio =  $form_email_medio."						".$img_error."Correo electr&oacute;nico inv&aacute;lido: Formato incorrecto (el correo contiene espacios).<BR>\n";
						$valido = false;
						$emailvalido = false;
					}
					if (strlen($email) > 64) {
						$form_email_medio =  $form_email_medio."						".$img_error."Correo electr&oacute;nico inv&aacute;lido: El usuario (antes del arroba) debe tener menos de 64 caracteres<BR>\n";
						$valido = false;
						$emailvalido = false;
					}
					if (strcmp(substr($email, strlen($email) - 1, 1), ".") == 0) {
						$form_email_medio =  $form_email_medio."						".$img_error."Correo electr&oacute;nico inv&aacute;lido: No se permite el punto antes del arroba.<BR>\n";
						$valido = false;
						$emailvalido = false;
					}
					if (strcmp(preg_replace("#[A-Za-z0-9!\#\$%&'*+\-/=?\^_`{|}~.]#", "", $email), "") != 0) {
						$form_email_medio =  $form_email_medio."						".$img_error."Correo electr&oacute;nico inv&aacute;lido: Contiene caracteres ilegales.<BR>\n";
						$valido = false;
						$emailvalido = false;
					}
					if (strcmp(preg_replace("#[^.]#", "", preg_replace("#[^.].#", "", $email)), "") != 0) {
						if (strpos($email, ".") !== 0) {
							$form_email_medio =  $form_email_medio."						".$img_error."Correo electr&oacute;nico inv&aacute;lido: Contiene dos o m√°s puntos seguidos.<BR>\n";
							$valido = false;
							$emailvalido = false;
						}
						else if (strlen(preg_replace("#[^.]#", "", preg_replace("#[^.].#", "", $email))) > 1){
							$form_email_medio =  $form_email_medio."						".$img_error."Correo electr&oacute;nico inv&aacute;lido: Contiene dos o m√°s puntos seguidos.<BR>\n";
							$valido = false;
							$emailvalido = false;
						}
					}
				}
				if ($emailvalido) {
					$domcmp = mysql_real_escape_string($dominio);
					$result = mysql_query("SELECT * FROM CDominio WHERE id_dom='$domcmp'", $vinculo);
					if (mysql_num_rows($result) != 1) {
						$form_email_medio = $form_email_medio."								".$img_error."<b>FATAL:</b> Intento de acceso a una clave de dominio no existente.\n";
						$valido = false;
						$emailvalido = false;
					}
				}
				if ($emailvalido) {
					$domcmp = mysql_real_escape_string($dominio);
					$emailcmp = mysql_real_escape_string($email);
					$result = mysql_query("SELECT * FROM MUsuario NATURAL JOIN CDominio WHERE id_dom='$domcmp' AND email_user='$emailcmp'", $vinculo);
					if (mysql_num_rows($result) > 0) {
						$form_email_medio = $form_email_medio."								".$img_error."Ya existe un usuario con el mismo correo electr√≥nico.\n";
						$valido = false;
						$emailvalido = false;
					}
					else {
						$form_email = $form_email.$email;
					}
				}
			}
			if (strcmp($pais, "") == 0) {
				$form_pais_medio = $form_pais_medio."						".$img_error."Debe de seleccionar un pa&iacute;s.\n";
				$valido = false;
			}
			else {
				$paiscmp = mysql_real_escape_string($pais);
				$result = mysql_query("SELECT * FROM CPais WHERE id_pais= '$paiscmp'", $vinculo);
				if (mysql_num_rows($result) != 1) {
					$form_pais_medio = $form_pais_medio."								".$img_error."<b>FATAL:</b> Intento de acceso a una clave de pa√≠s no existente.\n";
					$valido = false;
				}
			}
			if (strcmp($usuario, "") == 0) {
				$form_usuario_medio =  $form_usuario_medio."						".$img_error."El campo del nombre de usuario est&aacute; vacio.\n";
				$valido = false;
			}
			else if (strlen($usuario) < 3) {
				$form_usuario_medio =  $form_usuario_medio."						".$img_error."El seud√≥nimo debe contener 3 caracteres como m&iacute;nimo.\n";
				$valido = false;
			}
			else if (strlen($usuario) > 20) {
				$form_usuario_medio =  $form_usuario_medio."						".$img_error."El seud√≥nimo debe contener 20 caracteres como m&aacute;ximo.\n";
				$valido = false;
			}
			else if (strlen(preg_replace("#[ -~]#", "", $usuario)) > 0) {
				$form_usuario_medio =  $form_usuario_medio."						".$img_error."S√≥lo son v√°lidos caracteres dentro del ASCII 7-bits\n";
				$valido = false;
			}
			else {
				$usuariocmp = mysql_real_escape_string(strtoupper($usuario));
				$result = mysql_query("SELECT * FROM MUsuario WHERE UPPER(nick_user)='$usuariocmp'",$vinculo);
				if (mysql_num_rows($result) > 0) {
					$form_usuario_medio =  $form_usuario_medio."								".$img_error."El seud√≥nimo ya existe.\n";
					$valido = false;
				}
				else {
					$form_usuario = $form_usuario.$usuario;
				}
			}
			if (strlen($contrasena) < 4){
				$form_contrasena = $form_contrasena."						".$img_error."La contrase&ntilde;a debe ser de m&iacute;nimo 4 caracteres.\n";
				$valido = false;
			}
			else if (strlen($contrasena) > 20) {
				$form_contrasena = $form_contrasena."						".$img_error."La contrase&ntilde;a debe ser de m&aacute;ximo 20 caracteres.\n";
				$valido = false;
			}
			else if (strcmp($contrasena, $confirmacion) != 0) {
				$form_confirmacion = $form_confirmacion."						".$img_error."Las contrase&ntilde;as no coinciden.\n";
				$valido = false;
			}
			if (!($captcha->is_valid)) {
				$form_captcha = $form_captcha."						".$img_error."Las palabras no corresponden.\n";
				$valido = false;
			}
			if (!isset($_POST["terminos"])) {
				$form_terminos = $form_terminos."						".$img_error."Para registrarte, debes leer y aceptar los <A HREF=\"terminos.html\" TARGET=\"_blank\">T&eacute;rminos de Uso</A>.\n";
				$valido = false;
			}
			if (((strcmp($dia, "") != 0) && (strcmp($dia, "d√≠a") != 0)) || (strcmp($mes, "") != 0) || ((strcmp($ano, "") != 0) && (strcmp($ano, "a√±o") != 0))) {			
				$arreglonum = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
				$cantdias = array (31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
				//$huevo  =  "			<LI>No mientas. Sabemos que no eres tan viejo. <A HREF=\"http://en.wikipedia.org/wiki/Oldest_people#Ten_oldest_people_currently_living\" TARGET=\"_blank\">Wikipedia lo dice</A>. ;)</LI>\n";
				while (strpos($dia, "0") === 0) {
					$dia = substr($dia, 1);
				}
				while (strpos($ano, "0") === 0) {
					$ano = substr($ano, 1);
				}
				if ((strcmp(str_replace($arreglonum, "", $dia), "") != 0) && (strcmp($dia, "d√≠a") != 0)) {
					$form_fecha =  $form_fecha."						".$img_error."El d&iacute;a s&oacute;lo debe de contener n&uacute;meros<BR>\n";
					$valido = false;
				}
				else if ((strcmp($dia, "") == 0) || (strcmp($dia, "d√≠a") == 0)) {
					$form_fecha =  $form_fecha."						".$img_error."El campo de d&iacute;a est&aacute; vacio.<BR>\n";
					$valido = false;
				}
				if (strcmp($mes, "") == 0) {
					$form_fecha =  $form_fecha."						".$img_error."El campo de mes est&aacute; vacio.<BR>\n";
					$valido = false;
				}
				if ((strcmp(str_replace($arreglonum, "", $ano), "") != 0) && (strcmp($ano, "a√±o") != 0)) {
					$form_fecha =  $form_fecha."						".$img_error."El a&ntilde;o s&oacute;lo debe de contener n&uacute;meros.<BR>\n";
					$valido = false;
				}
				else if ((strcmp($ano, "") == 0) || (strcmp($ano, "a√±o") == 0)) {
					$form_fecha =  $form_fecha."						".$img_error."El campo de a&ntilde;o est&aacute; vacio.<BR>\n";
					$valido = false;
				}
				if ($valido) {
					if ((intval($mes) == 2) && ((intval($ano) % 4) == 0)) {
						if ((intval($ano) % 100) == 0) {
							if (intval($ano) % 400 == 0) {
								$cantdias[1] = 29;
							}
						}
						else {
							$cantdias[1] = 29;
						}
					}
					if (intval($dia) > $cantdias[intval($mes) - 1]) {
						$form_fecha =  $form_fecha."						".$img_error."La fecha no existe.<BR>\n";
						$valido = false;
					}
					// Huevo de pascua
					/*else if ($valido) {
						if (intval($ano) < 1895) {
							$msgconfirm = $msgconfirm.$huevo;
							$valido = false;
						}
						else if (intval($ano) == 1895) {
							if (intval($mes) < 5) {
								$msgconfirm = $msgconfirm.$huevo;
								$valido = false;
							}
							else if (intval($mes) == 5) {
								if (intval($dia) < 10) {
									$msgconfirm = $msgconfirm.$huevo;
									$valido = false;
								}
							}
						}
					}*/
				}
				if ($valido) {
					if (intval($mes) < 10) {
						$mes = "0".$mes;
					}
					if (intval($dia) < 10) {
						$dia = "0".$dia;
					}
					$nacimiento = "'".$ano."-".$mes."-".$dia."'";
				}
			}
			else {
				$form_fecha =  $form_fecha."						".$img_error."La fecha es obligatoria.<BR>\n";
				$valido = false;
			}
			if ($valido) {
				$msgconfirm = "¬°¬°Felicidades ".htmlspecialchars($nombre)."!! Tu registro a CodeComm ha sido completado satisfactoriamente. Puedes empezar inmediatamente a usar CodeComm. S√≥lo accede <a href=\"index.php\">aqu√≠</a>.\n";
			}
			else {
				$msgconfirm = $msgconfirm."		</UL>\n";
			}
			if ($valido) {
				$nombre = mysql_real_escape_string($nombre);
				$apellidos = mysql_real_escape_string($apellidos);
				$email = mysql_real_escape_string($email);
				$usuario = mysql_real_escape_string($usuario);
				$contrasena = mysql_real_escape_string(hash("sha256", "enc".strtoupper($usuario).$contrasena));
				date_default_timezone_set("UTC");
				$fecha = date("Y-m-d H:i:s");
				mysql_query(
					"INSERT INTO MUsuario (nom_user, ap_user, nick_user, nac_user, email_user, id_dom, id_pais, pass_user, reg_user, id_tipo, id_skin, vernom_user, vernac_user, veremail_user, bans_user) ".
					"VALUE (_utf8'$nombre', _utf8'$apellidos', '$usuario', $nacimiento, '$email', $dominio, '$pais', _utf8'$contrasena', '$fecha', 1, 1, false, false, false, 0)",
					$vinculo); 
				print $msgconfirm;
				$_SESSION["loginatt"] = true;
				$_SESSION["user"]=$usuario;
				$_SESSION["pass"]=$contrasena;
			}
			else {
				print $msgconfirm;
				include "form.php";
			}
		}
		mysql_close($vinculo);
	}
?>
	<td valign="top">
		<h2>Registro a CodeComm</h2>
		<script>
			var RecaptchaOptions = {
				lang : 'es'
			};
		</script>
		<?php
			validar();
		?>
	</td></tr></table>
<?php include "foot.php" ?>

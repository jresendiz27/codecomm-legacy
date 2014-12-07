<?php
	include "curpage.php";
	include "conectar.php";
	$vinculo = conectar();
	mysql_query ("SET NAMES 'utf8'");
	include "sesion.php";
	include "skin.php";
	include "welcome.php";
	include "categorias.php";
	$navegador = getenv("HTTP_USER_AGENT");
	if (preg_match("/MSIE/i", "$navegador")) 
	{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>CodeComm - InSysDev</title>
		<link href="<?php echo $csstheme; ?>" media="screen" rel="StyleSheet" type="text/css">
		<link rel="shortcut icon" href="cdcmm_ico.png"/>
		<style TYPE="text/css">
			.codestyle {
				font-family: "Courier New";
				border-style: solid;
				border-width: 1px;
				background-color: #CCC;
				color: #000;
				display: block;
			}
			.comments{
				background:#F7F7F7;
				color:#000000;
			}
		</style>
		<script type = "text/javascript">
		function borra()
			{
			if (document.getElementById("comment").value=="Escribe un comentario...") 
				{
				document.getElementById("comment").value="";
				}
			}
		</script>
	</head>
	<body>
		<?php echo $div;?>
		<center>
		<?php echo $br;?>
		<table width="800" height="120" border="0" class="tmain">
			<tr>
				<td colspan="10"><?php bienvenida($_SESSION['user']);?></td>
			</tr>
			<tr>
				<td colspan="10" class="header">
					<div align="center">
					<img src="images/logo.png" width="83" height="111" alt="CodeComm" align="left" />
					<img src="images/gamaus.gif" alt="Gamaus" width="83" height="99"  align="right"/>	</div>
				</td>
			</tr>
			<tr>
			<font size="6">
			<p class="iex_a">Al parecer tienes problemas con el diseño de la pagina, Codecomm te recomienda Firefox,Opera, Chrome o Safari como navegador web. <a href="http://www.mozilla.com/es-MX/?gclid=CJzY2uPHtqECFQ8bawod12re_A" target="_blank">¡Descarga Firefox aqui!</a></p></font>
			</tr>
		</table>
<?php if (!isset($_SESSION["user"])) { ?>
<table width="152" border="0" align="center">
<form action="index.php" method="post">
  <tr>
    <td><p class="access">Usuario
        <input type="text" name="user" />
      </p></td>
    </tr>
  <tr>
    <td height="26">
      <p class="access">Contraseña<input type="password" name="pass" />
      </p></td>
    </tr>
  <tr>
	<td>
	<p class="access"><input type="submit" value="acceder" name="login" /></p>
	</td>
  </tr>
</form>
</table>
<?php } else { ?>
<table width="800" border="0">
  <span class="iex_a">
  <tr>
    <td><a href="index.php?theme=<?php echo $csstheme; ?>&close=1">Cerrar sesión</a></td>
    <td><a href="creacion.php">Crear post</a></td>
    <td><a href="perfil.php?nick=<?php echo $_SESSION["user"]; ?>">Mi Perfil</a></td>
  </tr>
  <tr>
	<td><a href="msg.php?data=new">Nuevo Mensaje</a></td>
    <td><a href="msg.php?data=inbox">Bandeja de entrada</a></td>
	<td><a href="msg.php?data=send">Enviados</a></td>
  </tr>
  </span>
</table>
<?php } ?>
<table width="800" border="0" class="general" align="center">
  <tr>
    <td class="iex_td" width="200">
	<dl class="iex_thm">
	<dt><a href="#">Temas</a></dt>
	<dd></dd>
	<?php lista_skin_ex(); ?>
	</dl>
	<?php lista_cat_ex(); ?>
	</td>
<?php } else { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>CodeComm - InSysDev</title>
		<link href="<?php echo $csstheme ?>" media="screen" rel="StyleSheet" type="text/css">
		<link rel="shortcut icon" href="cdcmm_ico.png"/>
		<script type="text/javascript" src="mail.js"></script>
		<script type="text/javascript" src="ajax.js"></script>
                <script type="text/javascript">
		function muestraReloj() 
		{
  		var fechaHora = new Date();
		var horas = fechaHora.getHours();
  		var minutos = fechaHora.getMinutes();
  		var segundos = fechaHora.getSeconds();
 
 	 	if(horas < 10) { horas = '0' + horas; }
  		if(minutos < 10) { minutos = '0' + minutos; }
  		if(segundos < 10) { segundos = '0' + segundos; }
 
  		document.getElementById("date").innerHTML = horas+':'+minutos+':'+segundos;
		}
 
		window.onload = function() 
		{
  		setInterval(muestraReloj, 1000);
		}
 
		</script>
		<style TYPE="text/css">
			.codestyle {
				font-family: "Courier New";
				border-style: solid;
				border-width: 1px;
				background-color: #CCC;
				color: #000;
				display: block;
			}
			.comments{
				background:#F7F7F7;
				color:#000000;
			}
			.codestyle {
				font-family: "Courier New";
				border-style: solid;
				border-width: 1px;
				background-color: #CCC;
				color: #000;
				display: block;
			}
		</style>
		<script type = "text/javascript">
		function borra()
			{
			if (document.fcomment.comment.value=="Escribe un comentario...") 
				{
				document.fcomment.comment.value="";
				}
			}
		function mostrar() {
		div = document.getElementById('login');
		//div.style.float ='left';
		//div.style.width ='250';
		//div.style.height ='400';
		div.style.display = 'inline';
		//div.style.position ='relative';
		}
	
		function cerrar() {
		div = document.getElementById('login');
		div.style.display='none';

		}
		</script>
	</head>
	<body>
		<?php echo $div;?>
		<center>
		<?php echo $br;?>
		<table width="900" height="120" border="0" class="tmain">
			<tr>
				<td colspan="9"><?php bienvenida($_SESSION['user']);?></td>
				<td><p id="date" align="center" class="date"></td>
			</tr>
			<tr>
				<td colspan="10" class="header">
					<div align="center">
					<img src="images/logo.png" width="83" height="111" alt="CodeComm" align="left" />
					<img src="images/gamaus.gif" alt="Gamaus" width="83" height="99"  align="right"/>	</div>
				</td>
			</tr>
			<?if(!isset($_SESSION["user"])){?>
			<noscript>
			<center>
			<form action="index.php" method="post">
			<div align="center" style="display:float;">
				<tr>
					<td>
					<p style="font-family:Verdana;color:#000000;">Usuario:<input type="text" name="user" value="user" /></p>
					</td>
				</tr>
				<tr>
					<td>
					<p style="font-family:Verdana;color:#000000;">Contraseña:<input type="password" name="pass" value="password" /></p>
					</td>
				</tr>
				<tr>
					<td>
					<center><input name="login" type="submit" value="Acceder" /></center>
					</td>
				</tr>
				<tr>
					<td>
					<p style="font-size:80%;color:#000000;"><a href="password.php">Recuperar contraseña</a></p>
					</td>
				</tr>
			</div>
			</form>
			</center>
			</noscript>
			<? } ?>
		</table>
		<table width="900" border="0" class="tmain">
			<tr>
				<td height="37" class="tmenu">
					<div class="menu">
					<ul>
						<li><a href="index.php" target="_self">Inicio</a></li>
					</ul>
					</div>
				</td>
				<td height="37" class="tmenu">
					<div class="menu">
					<ul>
						<li><a href="#" >Comunidad</a></li>
					</ul>
					</div>
				</td>
<td height="37" class="tmenu">
					<div class="menu">
					<ul>
						<li><a href="buscar.php" >Buscador</a></li>
					</ul>
					</div>
				</td>
<?php if (!isset($_SESSION["user"])) { ?>
				<td height="37" class="tmenu">	
				<div class="menu">
				<ul>
				<li><a href="javascript:mostrar();">Accede</a></li>
				</ul>
				</div>
					<div class="login" id="login" style="display:none;clear:left;">	
							<center><a href="javascript:cerrar();" class="links"><img src="images/hide.gif" align="middle" width="20" height="10" border="0"/></a></center>
								<form action="index.php" method="post" onsubmit="javascript:cerrar();">
									<p class="access">Usuario</p> 
									<p align="center"><input type="text" name="user" value="user" /></p>
									<p class="access">Contraseña</p>
									<p align="center"><input type="password" name="pass" value="password" /></p>
									<hr/>
									<center><input name="login" type="submit" value="Acceder" /></center>
									<hr/>
									<p class="access" style="font-size:80%;"><a href="password.php">Recuperar contraseña</a></p>
									<p></p>
								</form>
					</div>
				</td>
				<td height="37" class="tmenu">
					<div class="menu">
					<ul>
						<li><a href="registro.php">Reg&iacute;strate</a></li>
					</ul>
					</div>
				</td>
<?php }  else { ?>
				<td height="37" class="tmenu">
					<div class="menu">
					<ul>
						<li><a href="perfil.php?nick=<?php echo htmlspecialchars($_SESSION["user"]) ?>"><?php echo htmlspecialchars($_SESSION["user"]); ?></a>
						<ul>
							<li><a href="perfil.php?nick=<?php echo htmlspecialchars($_SESSION["user"]); ?>">Perfil</a></li>
							<li><a href="creacion.php">Crear post</a></li>
							<li><a href="msg.php?data=new">Nuevo mensaje</a></li>
							<li><a href="msg.php?data=inbox">Bandeja de entrada</a></li>
							<li><a href="msg.php?data=send">Enviados</a></li>
							<li><a href="index.php?theme=<?php echo $csstheme; ?>&close=1">Cerrar sesión</a></li>
						</ul>
						</li>
					</ul>
					</div>
				</td>
<?php } ?>
				<td height="37" class="tmenu">
					<div class="menu">
					<ul>
						<li><a href="#">Temas</a>
							<ul>
								<?php lista_skin() ?>
							</ul>
						</li>
					</ul>
					</div>
				</td>
			</tr>
		</table>
		<table width="900" border="0" class="tmain">
			<tr>
				<?php lista_cat() ?>
			</tr>
		</table>
		<table width="900" class="general"><tr>
<?php } ?>
